<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Crypt;

class Bayar extends Component
{

    public $token;
    public $id_tagihan;

    public function mount($snap_token)
    {
        $data = Crypt::decrypt($snap_token);
        $this->transaksi = $data['transaksi'];
    }

    public function render()
    {
        $x = $this->transaksi['id_tagihan'];
        $transaksi = Transaksi::where('id_tagihan', $x)->first();
        $tagihan = Tagihan::find($transaksi->id_tagihan);


        return view('livewire.mahasiswa.keuangan.bayar', ['tagihan' => $tagihan, 'transaksi' => $transaksi]);
    }
}
