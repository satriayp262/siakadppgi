<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Konfirmasi_Pembayaran;

class Histori extends Component
{
    public function render()
    {
        $user = auth()->user();
        $konfirmasi = Konfirmasi_Pembayaran::where('NIM', $user->nim_nidn)
            ->with(['tagihan', 'tagihan.semester'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.mahasiswa.keuangan.histori', [
            'konfirmasi' => $konfirmasi,
        ]);
    }
}
