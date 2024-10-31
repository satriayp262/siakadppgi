<?php

namespace App\Livewire\Dosen\InputNilai;

use Livewire\Component;
use App\Models\Matakuliah;

class Index extends Component
{
    public function render()
    {
        $matkuls = Matakuliah::where('nidn', Auth()->user()->nim_nidn)
        ->get();
        return view('livewire.dosen.input-nilai.index',[
            'matkuls' => $matkuls
        ]);
    }
}
