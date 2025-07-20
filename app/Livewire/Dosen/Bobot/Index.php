<?php

namespace App\Livewire\Dosen\Bobot;

use Livewire\Component;
use App\Models\Matakuliah;

class Index extends Component
{
    public $nidn;
    public function render()
    {
        $matakuliah = Matakuliah::where('nidn', $this->nidn)->paginate(10);
        return view('livewire.dosen.bobot.index',[
            'matakuliah' => $matakuliah
        ]);
    }
}
