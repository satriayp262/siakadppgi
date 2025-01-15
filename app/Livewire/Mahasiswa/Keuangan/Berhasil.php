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
            if ($tagihan->total_bayar == 0) {
                $tagihan->total_bayar = $transaksi->nominal - 5000;
            } else {
                $bayar = $transaksi->nominal - 5000;
                $tagihan->total_bayar = $tagihan->total_bayar + $bayar;
            }
            if ($tagihan->total_bayar == $tagihan->total_tagihan) {
                $tagihan->status_tagihan = 'Lunas';
            }
            $tagihan->save();
        }
    }

    public function render()
    {
        return view('livewire.mahasiswa.keuangan.berhasil')->layout('components.layouts.guest');
        ;
    }
}
