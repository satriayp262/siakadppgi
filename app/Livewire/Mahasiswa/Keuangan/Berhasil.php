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
        }
        if ($tagihan->status_tagihan == 'Lunas') {
            // Generate nomor kwitansi
            $tagihan->metode_pembayaran = 'Midtrans Payment';
            $tagihan->no_kwitansi = rand();

            // Pastikan kwitansi unik
            while (Tagihan::where('no_kwitansi', $tagihan->no_kwitansi)->exists()) {
                $tagihan->no_kwitansi = rand();
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
