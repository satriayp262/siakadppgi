<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Kelas;

class Index extends Component
{
    public $matakuliah;
    public $prodi;
    public $dosen;
    public $mahasiswa;
    public $user;
    public $kelas;

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

        $users = User::query()->count();
        $this->user = $users;

        $kelass = Kelas::query()->count();
        $this->kelas = $kelass;
    }


    public function render()
    {
        return view('livewire.admin.dashboard.index');
    }
}
