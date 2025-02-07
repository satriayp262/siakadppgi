<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use App\Models\Prodi;
use App\Models\Semester;

class Transaksi extends Component
{

    public $selectedMahasiswa;

    public function mount()
    {
        // Ambil data mahasiswa dari session
        $this->mahasiswas = session('selectedMahasiswa', []);
    }

    public function render()
    {
        $prodis = Prodi::all();

        $semesters = Semester::all();

        return view('livewire.staff.tagihan.transaksi', [
            'mahasiswas' => $this->mahasiswas,
            'prodis' => $prodis,
            'semesters' => $semesters,
        ]);
    }
}
