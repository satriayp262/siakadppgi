<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Token;
use Livewire\Component;

class DetailPresensi extends Component
{
    public $token;
    public $matkul;

    public function back()
    {
        // Redirect ke halaman sebelumnya atau halaman tertentu
        return redirect()->route('dosen.presensi');
    }

    public function mount($token)
    {
        // Ambil token berdasarkan token yang diterima
        $this->token = Token::with('matkul')->where('token', $token)->first();

        // Jika token ditemukan, ambil mata kuliah terkait
        if ($this->token && $this->token->matkul) {
            $this->matkul = $this->token->matkul->nama_mata_kuliah;
        } else {
            $this->matkul = 'Mata kuliah tidak ditemukan';
        }
    }

    public function render()
    {
        $presensi = collect(); // Default nilai presensi adalah koleksi kosong

        // Cek apakah $this->token tidak null sebelum mengambil presensi
        if ($this->token) {
            // Ambil presensi berdasarkan token
            $presensi = Presensi::with(['mahasiswa'])
                ->where('token', $this->token->token) // Filter berdasarkan token
                ->get();
        }

        return view('livewire.dosen.presensi.detail_presensi', compact('presensi'));
    }
}
