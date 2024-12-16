<?php

namespace App\Livewire\Dosen\Bobot;

use Livewire\Component;
use App\Models\Matakuliah;

class Index extends Component
{
    public function render()
    {
        $matakuliah = Matakuliah::where('nidn', Auth()->user()->nim_nidn)->paginate(10);
        return view('livewire.dosen.bobot.index',[
            'matakuliah' => $matakuliah
        ]);
    }
}
