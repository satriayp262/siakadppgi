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
        if (!$transaksi) {
            return; // Transaksi tidak ditemukan
        }

        // Update status transaksi
        $transaksi->status = 'success';
        $transaksi->save();

        $tagihan = Tagihan::find($transaksi->id_tagihan);
        if (!$tagihan) {
            return; // Tagihan tidak ditemukan
        }

        // Hitung pembayaran setelah biaya admin
        $bayar = $transaksi->nominal - 5000;

        // Update total bayar
        $tagihan->total_bayar += $bayar;

        // Periksa apakah sudah lunas
        if ($tagihan->total_bayar == $tagihan->total_tagihan) {
            $tagihan->status_tagihan = 'Lunas';
        } else {
            // Logika cicilan
            if (strpos($tagihan->metode_pembayaran, 'Cicil') !== false) {
                $maxCicilan = (int) filter_var($tagihan->metode_pembayaran, FILTER_SANITIZE_NUMBER_INT);
                if ($tagihan->cicilan_ke < $maxCicilan) {
                    $tagihan->cicilan_ke++;
                } else {
                    $tagihan->status_tagihan = 'Lunas';
                }
            } elseif ($tagihan->metode_pembayaran === 'Bayar Penuh') {
                $tagihan->status_tagihan = 'Lunas';
            }
        }

        $tagihan->save();
    }


    public function render()
    {
        return view('livewire.mahasiswa.keuangan.berhasil')->layout('components.layouts.guest');
        ;
    }
}
