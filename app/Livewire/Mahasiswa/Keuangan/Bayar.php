<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Tagihan;

class Bayar extends Component
{

    public $token;

    public function mount($snap_token)
    {
        $this->token = $snap_token;
    }

    public function render()
    {
        return view('livewire.mahasiswa.keuangan.bayar', ['token' => $this->token]);
    }
}
