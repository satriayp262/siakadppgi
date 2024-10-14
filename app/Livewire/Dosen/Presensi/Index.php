<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Matakuliah;
use Livewire\Component;
use App\Models\Presensi;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Index extends Component
{
    public $date;
    public $kode_mata_kuliah; // Untuk menyimpan kode mata kuliah yang dipilih
    public $search;
    public $tokens = []; // Untuk menyimpan semua token
    public $matkul = []; // Untuk menyimpan mata kuliah yang relevan

    public function mount()
    {
        // Ambil token dan mata kuliah yang relevan saat komponen di-mount
        $this->getTokensByUser();
        $this->getRelevantMatkul();
    }

    #[On('tokenCreated')]
    public function handleTokenCreated($token)
    {
        session()->flash('message', 'Token berhasil dibuat!');
        session()->flash('message_type', 'success');
    }

    protected function getTokensByUser()
    {
        // Ambil user yang login
        $user = Auth::user();
        // Ambil semua token yang dibuat oleh user ini
        $this->tokens = Token::where('id', $user->id)->latest()->get(); // Pastikan Anda menggunakan kolom yang tepat untuk ID pengguna
    }

    protected function getRelevantMatkul()
    {
        // Ambil user yang login
        $user = Auth::user();
        // Ambil token yang dibuat oleh user
        $tokens = Token::where('id', $user->id)->get(); // Pastikan menggunakan kolom yang tepat

        // Ambil mata kuliah berdasarkan token
        $this->matkul = Matakuliah::whereIn('kode_mata_kuliah', $tokens->pluck('kode_mata_kuliah'))->get();
    }

    public function render()
    {
        return view('livewire.dosen.presensi.index', [
            'tokens' => $this->tokens,
            'matkul' => $this->matkul,
        ]);
    }
}
