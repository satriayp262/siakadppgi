<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Cicilan_BPP;
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
            return $this->dispatch('warning', [
                'message' => 'Transaksi tidak ditemukan',
            ]);
        }

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

            $tagihan->status_tagihan = 'Belum Lunas';

            if ($transaksi->bulan != null) {
                $s = Cicilan_BPP::where('id_tagihan', $tagihan->id_tagihan)->count();
                $count_cicilan = $s + 1;
                $cicilan = Cicilan_BPP::create([
                    'id_tagihan' => $tagihan->id_tagihan,
                    'jumlah_bayar' => $bayar,
                    'tanggal_bayar' => $transaksi->tanggal_transaksi,
                    'cicilan_ke' => $count_cicilan,
                    'bulan' => $transaksi->bulan,
                    'metode_pembayaran' => 'Midtrans Payment',
                ]);

                $cicilan->save();
            }

        }

        if ($tagihan->status_tagihan == 'Lunas') {

            $tagihan->no_kwitansi = rand();
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
