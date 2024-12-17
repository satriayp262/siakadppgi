<?php

namespace App\Livewire\Dosen\Bobot\Kelas;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\Attributes\On;

class Index extends Component
{
    public $kode_mata_kuliah,$url;

    #[On('kelasUpdated')]
    public function handelKelasUpdated(){

        $this->dispatch('BobotUpdate', ['message' => 'Kelas Berhasil Diupdate', 'link' => $this->url]);

    }

    public function render()
    {
        $this->url = request()->url();

        $id_matkul = Matakuliah::where('kode_mata_kuliah', $this->kode_mata_kuliah)->first()->id_mata_kuliah;
        $kelas = Kelas::where('id_mata_kuliah', $id_matkul)->get();
        return view('livewire.dosen.bobot.kelas.index',[
            'kelas' => $kelas
        ]);
    }
}
