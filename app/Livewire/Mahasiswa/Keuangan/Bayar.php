<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Crypt;

class Bayar extends Component
{

    public $order;
    public $id_tagihan;

    public $transaksi;

    public function mount($order_id)
    {
        $this->order = $order_id;
        $this->transaksi = Transaksi::where('order_id', $order_id)->first();
    }

    public function hapus($id_transaksi)
    {
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)->first();
        $transaksi->delete();
        return redirect()->route('mahasiswa.keuangan');
    }


    public function render()
    {
        $transaksi = Transaksi::where('order_id', $this->order)->first();
        $tagihan = Tagihan::find($transaksi->id_tagihan);


        return view('livewire.mahasiswa.keuangan.bayar', ['tagihan' => $tagihan, 'transaksi' => $transaksi]);
    }
}
