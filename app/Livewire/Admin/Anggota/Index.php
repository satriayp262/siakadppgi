<?php

namespace App\Livewire\Admin\Anggota;

use App\Models\Kelas;
use Livewire\Component;

class Index extends Component
{
    public $search;
    public function render()
    {
        $kelas = Kelas::paginate(10);

        return view('livewire.admin.anggota.index',[
            'kelas' => $kelas
        ]);
    }
}
