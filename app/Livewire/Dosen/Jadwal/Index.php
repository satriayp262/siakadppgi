<?php

namespace App\Livewire\Dosen\Jadwal;

use App\Models\Dosen;
use Livewire\Component;

class Index extends Component
{

    public $dosen;

    public function mount()
    {
        $this->dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();
    }

    public function render()
    {
        return view('livewire.dosen.jadwal.index');
    }
}
