<?php

namespace App\Livewire\Dosen\Bobot\Kelas;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\Attributes\On;

class Index extends Component
{
    public $kode_mata_kuliah;

    #[On('kelasUpdated')]
    public function handelKelasUpdated(){
        $this->dispatch('updated', ['message' => 'Kelas Berhasil Diupdate']);

    }

    public function render()
    {
        $id_matkul = Matakuliah::where('kode_mata_kuliah', $this->kode_mata_kuliah)->first()->id_mata_kuliah;
        $kelas = Kelas::where('id_mata_kuliah', $id_matkul)->get();
        return view('livewire.dosen.bobot.kelas.index',[
            'kelas' => $kelas
        ]);
    }
}
