<?php

namespace App\Livewire\Mahasiswa\Emonev;

use App\Models\Dosen;
use App\Models\Emonev;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Pertanyaan;
use App\Models\Jawaban;
use App\Models\Kelas;
use App\Models\MahasiswaEmonev;

use Vinkla\Hashids\Facades\Hashids;

class Show extends Component
{

    public $jawaban = [];
    public $id;
    public $semester;
    public $saran;
    public $emon;
    public $sesi;
    public $pertanyaan;
    public $mahasiswa;
    public $id_kelas;




    public function mount($id_mata_kuliah, $nama_semester)
    {
        $decoded = Hashids::decode($id_mata_kuliah);
        $this->id = $decoded[0] ?? null;
        $this->id_kelas = $decoded[1] ?? null;

        if (!$this->id || !$this->id_kelas)
            abort(404);


        $this->semester = $nama_semester;
    }



    public function save()
    {
        // Validasi input
        $this->validate([
            'jawaban' => 'required|array|min:' . Pertanyaan::count(),
            'jawaban.*' => 'required',
            'saran' => 'required|string',
        ], [
            'jawaban.required' => 'Jawaban wajib diisi.',
            'jawaban.array' => 'Jawaban harus berupa array.',
            'jawaban.min' => 'Semua pertanyaan harus dijawab.',
            'jawaban.*.required' => 'Setiap jawaban wajib diisi.',
            'saran.required' => 'Saran wajib diisi.',
            'saran.string' => 'Saran harus berupa teks.',
        ]);

        // Ambil data yang dibutuhkan
        $matkul = Matakuliah::with('dosen')->findOrFail($this->id);
        $semester = Semester::where('nama_semester', $this->semester)->firstOrFail();
        $mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim_nidn)->firstOrFail();

        // Cek apakah sudah ada data MahasiswaEmonev
        $emon = MahasiswaEmonev::where('NIM', $mahasiswa->NIM)
            ->where('id_mata_kuliah', $this->id)
            ->where('id_semester', $semester->id_semester)
            ->first();

        // Tentukan sesi (1 jika belum ada data, +1 jika sudah ada)
        $sesi = $emon ? $emon->sesi + 1 : 1;

        // Simpan data MahasiswaEmonev (gunakan update jika sudah ada)
        if ($emon) {
            $emon->update(['sesi' => $sesi]);
        } else {
            $emon = MahasiswaEmonev::create([
                'NIM' => $mahasiswa->NIM,
                'id_semester' => $semester->id_semester,
                'id_mata_kuliah' => $this->id,
                'nidn' => $matkul->dosen->nidn,
                'sesi' => $sesi,
            ]);
        }

        // Simpan data e-Monev
        $emonev = Emonev::create([
            'id_mata_kuliah' => $this->id,
            'id_semester' => $semester->id_semester,
            'nidn' => $matkul->dosen->nidn,
            'id_kelas' => $this->id_kelas,
            'saran' => $this->saran,
        ]);

        // Simpan jawaban
        foreach ($this->jawaban as $id_pertanyaan => $nilai) {
            Jawaban::create([
                'id_emonev' => $emonev->id_emonev,
                'id_pertanyaan' => $id_pertanyaan,
                'nilai' => $nilai,
            ]);
        }
        // Reset input setelah sukses
        $this->reset(['jawaban', 'saran']);

        // Beri notifikasi sukses ke user
        $this->dispatch('created', ['message' => 'Data e-Monev berhasil disimpan.']);

        return redirect()->route('mahasiswa.emonev');
    }




    public function render()
    {

        $matkul = Matakuliah::query()->where('id_mata_kuliah', $this->id)->first();
        $pertanyaan = Pertanyaan::query()->get();
        $semester = Semester::query()->where('nama_semester', $this->semester)->pluck('id_semester', 'nama_semester');
        $kelas = Kelas::query()->where('id_kelas', $this->id_kelas)->first();
        $mahasiswa = Mahasiswa::query()->where('NIM', auth()->user()->nim_nidn)->value('NIM');
        $dosen = Dosen::query()->where('nidn', $matkul->nidn)->value('nidn');

        $mahasiswaemonev = MahasiswaEmonev::query()
            ->where('NIM', $mahasiswa)
            ->where('id_mata_kuliah', $this->id)
            ->where('id_semester', $semester->first())
            ->where('nidn', $dosen)
            ->value('sesi');


        return view('livewire.mahasiswa.emonev.show', [
            'matkul' => $matkul,
            'pertanyaans' => $pertanyaan,
            'semester' => $semester->keys()->first(),
            'kelas' => $kelas,
            'mahasiswaemonev' => $mahasiswaemonev,

        ]);
    }
}
