<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Matakuliah;
use Livewire\Component;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $date;
    public $kode_mata_kuliah; // Untuk menyimpan kode mata kuliah yang dipilih
    public $search;
    public $tokens = []; // Untuk menyimpan semua token
    public $matkul = []; // Untuk menyimpan mata kuliah yang relevan

    public function mount()
    {
        // Ambil token dan mata kuliah yang relevan saat komponen di-mount
        $this->getRelevantMatkul();
    }

    #[On('tokenCreated')]
    public function handletokenCreated($token)
    {
        session()->flash('message', 'Token berhasil dibuat!');
        session()->flash('message_type', 'success');
    }

    protected function getRelevantMatkul()
    {
        // Ambil user yang login
        $user = Auth::user();

        // Ambil token yang dibuat oleh user
        $tokens = Token::where('id', $user->id)->get();

        // Ambil mata kuliah berdasarkan token
        $this->matkul = Matakuliah::whereIn('kode_mata_kuliah', $tokens->pluck('kode_mata_kuliah'))->get();
    }

    public function render()
    {
        // Ambil user yang login
        $user = Auth::user();

        // Query untuk mendapatkan tokens
        $this->tokens = Token::where('id', $user->id)->get(); // Simpan token ke dalam property

        // Filter berdasarkan search jika diisi
        $tokens = Token::query()
            ->where('id', $user->id) // Filter berdasarkan user yang login
            ->whereHas('matkul', function ($query) {
                $query->where('nama_mata_kuliah', 'like', '%' . $this->search . '%')
                      ->orWhere('kode_mata_kuliah', 'like', '%' . $this->search . '%');
            })
            ->orWhere('valid_until', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(8); // Pastikan paginate dipanggil di sini

        return view('livewire.dosen.presensi.index', [
            'tokens' => $tokens, // Ganti 'Tokens' dengan 'tokens' untuk konsistensi
        ]);
    }
}
