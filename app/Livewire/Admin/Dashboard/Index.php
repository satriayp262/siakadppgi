<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Prodi;

class Index extends Component
{
    public $matakuliah;
    public $prodi;

    public function mount()
    {
        $matkul = Matakuliah::query()->count();
        $this->matakuliah = $matkul;

        $prodis = Prodi::query()->count();
        $this->prodi = $prodis;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.index');
    }
}
