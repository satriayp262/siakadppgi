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


    public function render()
    {
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('NIM', $user->nim_nidn)->first();

        // $krs = KRS::where('NIM', $mahasiswa->NIM)->get();

        $semester = Semester::where('is_active', true)->first();

        $krsFiltered = KRS::where('NIM', $mahasiswa->NIM)
            ->where('id_semester', $semester->id_semester)
            ->get();
        return view('livewire.mahasiswa.emonev.index', [
            'krs' => $krsFiltered
        ]);
    }
}