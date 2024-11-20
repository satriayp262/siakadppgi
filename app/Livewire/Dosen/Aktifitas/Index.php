<?php

namespace App\Livewire\Dosen\Aktifitas;

use App\Models\Aktifitas;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $matakuliah = Matakuliah::where('nidn', Auth()->user()->nim_nidn)->paginate(10);
        return view('livewire.dosen.aktifitas.index',[
            'matakuliah' => $matakuliah
        ]);
    }
}
