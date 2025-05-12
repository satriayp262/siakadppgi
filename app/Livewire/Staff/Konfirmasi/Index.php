<?php

namespace App\Livewire\Staff\Konfirmasi;

use App\Models\Konfirmasi_Pembayaran;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Tagihan;
use Illuminate\Container\Attributes\Tag;
use Livewire\Component;

class Index extends Component
{
    public $selectedprodi = '';
    public $selectedSemester = '';

    public $search = '';

    public function updateStatus($id_konfirmasi, $x)
    {
        $konfirmasi = Konfirmasi_Pembayaran::find($id_konfirmasi);
        if (!$konfirmasi) {
            $this->dispatch('error', [
                'message' => 'Konfirmasi Pembayaran tidak ditemukan',
            ]);
            return;
        }

        $konfirmasi->status = $x;

        $konfirmasi->save();

        if ($x == 'Diterima') {
            $tagihan = Tagihan::find($konfirmasi->id_tagihan);
            if ($tagihan) {
                $tagihan->total_bayar = $konfirmasi->jumlah_pembayaran;

                if ($tagihan->total_bayar == $tagihan->total_tagihan) {
                    $tagihan->status_tagihan = 'Lunas';
                } else {
                    $tagihan->status_tagihan = 'Belum Lunas';
                }

                $tagihan->metode_pembayaran = 'Transfer Rek PPGI';

                $tagihan->no_kwitansi = rand();

                // Pastikan kwitansi unik
                while (Tagihan::where('no_kwitansi', $tagihan->no_kwitansi)->exists()) {
                    $tagihan->no_kwitansi = rand();
                }

                $tagihan->save();
            }
        }

        $this->dispatch('created', ['message' => 'Pembayaran Berhasil di Konfirmasi']);


    }

    public function render()
    {
        return view('livewire.staff.konfirmasi.index', [
           
        ]);
    }
}
