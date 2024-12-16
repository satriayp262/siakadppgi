<?php

namespace App\Livewire\Mahasiswa\Emonev;

use App\Models\Dosen;
use App\Models\KRS;
use App\Models\Matakuliah;
use Livewire\Component;
use App\Models\Kelas;
use App\Models\Mahasiswa;

class Index extends Component
{
    public $NIM;

    public $id_kelas;

    public $id_mata_kuliah;


    public function render()
    {
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('NIM', $user->nim_nidn)->first();

        $krs = KRS::where('NIM', $mahasiswa->NIM)->get();

        $kelasIds = $krs->pluck('id_kelas');

        $kelas = Kelas::whereIn('id_kelas', $kelasIds)->get();

        $matkulIds = [];

        foreach ($kelas as $kls) {
            $matkulIds[] = $kls->id_mata_kuliah;
        }

        $matkul = Matakuliah::whereIn('id_mata_kuliah', $matkulIds)->get();

        $dosenIds = $matkul->pluck('nidn');

        $dosen = Dosen::whereIn('nidn', $dosenIds)->get();


        return view('livewire.mahasiswa.emonev.index', [
            'dosen' => $dosen
        ]);
    }
}