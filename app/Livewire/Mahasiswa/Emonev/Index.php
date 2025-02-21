<?php

namespace App\Livewire\Mahasiswa\Emonev;

use App\Models\Dosen;
use App\Models\KRS;
use App\Models\Matakuliah;
use App\Models\Semester;
use Livewire\Component;
use App\Models\Kelas;
use App\Models\Mahasiswa;

class Index extends Component
{
    public $NIM;

    public $id_kelas;

    public $id_mata_kuliah;

    public $id_semester;

    public function mount($nama_semester)
    {
        $this->nama_semester = Semester::where('nama_semester', $nama_semester)->first();
    }


    public function render()
    {
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('NIM', $user->nim_nidn)->first();


        $semester = $this->nama_semester->id_semester;


        $krs = KRS::where('NIM', $mahasiswa->NIM)
            ->where('id_semester', $semester)
            ->get();

        foreach ($krs as $k) {
            $kelas = Kelas::where('id_kelas', $k->id_kelas)->first();
        }






        return view('livewire.mahasiswa.emonev.index', [
            'krs' => $krs,
            'semester' => $this->nama_semester,
            'k' => $kelas,
        ]);
    }
}