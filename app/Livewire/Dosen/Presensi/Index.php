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
    public $kode_mata_kuliah;
    public $matkulId;
    public $search;
    public $tokenTerbaru; // Deklarasikan variabel

    public function mount()
    {
        // Ambil token terbaru saat komponen di-mount
        $this->getTokenTerbaru();
    }

    #[On('tokenCreated')]
    public function handletokenCreated($token)
    {
        session()->flash('message', 'Token berhasil dibuat!');
        session()->flash('message_type', 'success');
    }


    protected function getTokenTerbaru()
    {
        // Ambil user yang login
        $user = Auth::user();
        // Ambil token terbaru berdasarkan user yang login
        $this->tokenTerbaru = Token::where('id', $user->id)
            ->latest()
            ->first();
    }

    public function render()
    {
        // Ambil token terbaru setiap kali render dipanggil
        $this->getTokenTerbaru();

        $matkul = Matakuliah::all(); // Mengambil semua mata kuliah

        $presensi = Presensi::with(['mahasiswa', 'matkul'])
            ->when($this->date, function ($query) {
                $query->whereDate('submitted_at', $this->date);
            })
            ->when($this->matkulId, function ($query) {
                $query->whereHas('matkul', function ($query) {
                    $query->where('kode_mata_kuliah', $this->matkulId);
                });
            })
            ->get();

        // Kembalikan view dengan data yang dibutuhkan
        return view('livewire.dosen.presensi.index', compact('presensi', 'matkul'));
    }
}
