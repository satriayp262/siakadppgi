<?php

namespace App\Livewire\Admin\Prodi;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title(' | PRODI')]

class Index extends Component
{
    public $kode_prodi, $nama_prodi;

    public function render()
    {
        return view('livewire.admin.prodi.index');
    }
}
