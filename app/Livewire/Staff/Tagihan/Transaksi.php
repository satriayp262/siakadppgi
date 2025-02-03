<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;

class Transaksi extends Component
{

    public $mahasiswas;

    public function mount()
    {
        // Ambil data mahasiswa dari session
        $this->mahasiswas = session('selectedMahasiswa', []);
    }

    public function render()
    {
        return view('livewire.staff.tagihan.transaksi', [
            'mahasiswas' => $this->mahasiswas
        ]);
    }
}
