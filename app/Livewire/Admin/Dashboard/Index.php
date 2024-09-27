<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class Index extends Component
{
    public $matakuliah;
    public $prodi;
    public $dosen;
    public $mahasiswa;

    public function mount()
    {
        $matkul = Matakuliah::query()->count();
        $this->matakuliah = $matkul;

        $prodis = Prodi::query()->count();
        $this->prodi = $prodis;

        $dosens = Dosen::query()->count();
        $this->dosen = $dosens;

        $mahasiswas = Mahasiswa::query()->count();
        $this->mahasiswa = $mahasiswas;
    }


    public function render()
    {
        return view('livewire.admin.dashboard.index');
    }
}
