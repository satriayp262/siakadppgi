<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Tagihan;
use App\Models\Transaksi;
use Livewire\Component;


class Berhasil extends Component
{
    public $id_transaksi;

    public function mount($id_transaksi)
    {
        $this->id_transaksi = $id_transaksi;
        $this->updatebayar();
    }

    public function updatebayar()
    {
        $transaksi = Transaksi::find($this->id_transaksi);
        if ($transaksi) {
            $transaksi->status = 'success';
            $transaksi->save();
        }
        $tagihan = Tagihan::find($transaksi->id_tagihan);
        if ($tagihan) {
            $tagihan->status_tagihan = 'Lunas';
            $tagihan->total_bayar = $transaksi->nominal;
            $tagihan->save();
        }
    }

    public function render()
    {
        return view('livewire.mahasiswa.keuangan.berhasil');
    }
}
