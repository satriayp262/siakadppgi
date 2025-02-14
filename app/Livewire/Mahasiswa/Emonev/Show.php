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

class Show extends Component
{

    public $jawaban = [];
    public $id;
    public $semester;
    public $saran;



    public function mount($id_mata_kuliah, $nama_semester)
    {
        $this->id = $id_mata_kuliah;
        $this->semester = $nama_semester;
    }



    public function save()
    {
        $this->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|in:6,7,8,9,10',
            'saran' => 'nullable|string',
        ], [
            'jawaban.required' => 'Jawaban wajib diisi.',
            'jawaban.array' => 'Jawaban harus berupa array.',
            'jawaban.*.required' => 'Setiap jawaban wajib diisi.',
            'jawaban.*.in' => 'Jawaban harus bernilai antara 6 hingga 10.',
            'saran.string' => 'Saran harus berupa teks.',
        ]);

        // Ambil data yang dibutuhkan
        $matkul = Matakuliah::with('dosen')->findOrFail($this->id);
        $semester = Semester::where('nama_semester', $this->semester)->firstOrFail();
        $mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim_nidn)->firstOrFail();

        // Simpan data e-Monev
        $emonev = Emonev::create([
            'id_mata_kuliah' => $this->id,
            'id_semester' => $semester->id_semester,
            'nidn' => $matkul->dosen->nidn,
            'NIM' => $mahasiswa->NIM,
            'saran' => $this->saran,
            'sesi' => 1
        ]);

        // Simpan jawaban untuk setiap pertanyaan
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
    }



    public function render()
    {
        $matkul = Matakuliah::query()->where('id_mata_kuliah', $this->id)->first();
        $pertanyaan = Pertanyaan::query()->get();
        $semester = $this->semester;
        return view('livewire.mahasiswa.emonev.show', [
            'matkul' => $matkul,
            'pertanyaans' => $pertanyaan,
            'semester' => $semester,

        ]);
    }
}
