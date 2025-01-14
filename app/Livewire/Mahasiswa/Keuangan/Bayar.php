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

    public $transaksi;

    public function mount($snap_token)
    {
        $this->token = $snap_token;
        $this->transaksi = Transaksi::where('order_id', $snap_token)->first();
    }

    public function hapus($id_transaksi)
    {
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        $transaksi->delete();
        return redirect()->route('mahasiswa.keuangan');
    }


    public function render()
    {
        $transaksi = Transaksi::where('order_id', $this->token)->first();
        $tagihan = Tagihan::find($transaksi->id_tagihan);


        return view('livewire.mahasiswa.keuangan.bayar', ['tagihan' => $tagihan, 'transaksi' => $transaksi]);
    }
}
