<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $id_berita_acara, $tanggal, $nidn = '', $nama_dosen = '', $materi, $id_kelas, $id_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $nama_kelas, $nama_mata_kuliah;

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'id_mata_kuliah' => 'required|integer|max:255',
            'jumlah_mahasiswa' => 'required|integer',
            'id_kelas' => 'required|integer',
        ];
    }

    public function mount()
    {
        if ($this->id_mata_kuliah) {
            // Fetch Matakuliah
            $matkul = Matakuliah::find($this->id_mata_kuliah);
            if ($matkul) {
                $this->nama_mata_kuliah = $matkul->nama_mata_kuliah;
            }
        }

        if ($this->id_kelas) {
            $kelas = Kelas::find($this->id_kelas);
            if ($kelas) {
                $this->nama_kelas = $kelas->nama_kelas;
            }
        }

        $user = Auth::user();
        $dosen = Dosen::where('nidn', $user->nim_nidn)->first();

        if ($dosen) {
            $this->nidn = $dosen->nidn;
            $this->nama_dosen = $dosen->nama_dosen;
        }
    }

    public function save()
    {
        $this->validate();

        $semesterAktif = Semester::where('is_active', 1)->first();

        if (!$semesterAktif) {
            session()->flash('error', 'Tidak ada semester aktif.');
            return;
        }

        BeritaAcara::create([
            'tanggal' => $this->tanggal,
            'nidn' => $this->nidn,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'materi' => $this->materi,
            'jumlah_mahasiswa' => $this->jumlah_mahasiswa,
            'id_kelas' => $this->id_kelas,
            'id_semester' => $semesterAktif->id, 
        ]);

        session()->flash('success', 'Berita Acara berhasil disimpan.');
        $this->resetExcept('nidn', 'id_mata_kuliah', 'id_kelas');
        $this->dispatch('acaraCreated');
    }

    public function messages()
    {
        return [
            'nidn.required' => 'Nama dosen tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'materi.required' => 'Materi tidak boleh kosong',
            'id_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
            'jumlah_mahasiswa.required' => 'Jumlah mahasiswa tidak boleh kosong',
            'id_kelas.required' => 'Kelas tidak boleh kosong',
        ];
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.create');
    }
}
