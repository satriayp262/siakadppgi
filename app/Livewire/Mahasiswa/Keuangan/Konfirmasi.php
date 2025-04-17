<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\Component;
use Livewire\WithFileUploads;

class Konfirmasi extends Component
{
    public $bukti;
    use WithFileUploads;
    public function render()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('nim', $user->nim_nidn)->first();

        $tagihan = Tagihan::with('semester')
            ->where('NIM', $mahasiswa->NIM)
            ->where('status_tagihan', '!=', 'Lunas')
            ->get();

        return view('livewire.mahasiswa.keuangan.konfirmasi', [
            'tagihan' => $tagihan,
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
