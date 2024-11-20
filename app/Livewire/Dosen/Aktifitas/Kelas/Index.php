<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Kelas;
use App\Models\Matakuliah;
use Livewire\Component;

class Index extends Component
{
    public $kode_mata_kuliah;




    public function render()
    {
        $id_matkul = Matakuliah::where('kode_mata_kuliah', $this->kode_mata_kuliah)->first()->id_mata_kuliah;
        $kelas = Kelas::where('id_mata_kuliah', $id_matkul)->get();
        return view('livewire.dosen.aktifitas.kelas.index',[
            'kelas' => $kelas
        ]);
    }
}
