<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Matakuliah;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Presensi;
use App\Models\Matkul;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $date;
    public $kode_mata_kuliah;
    public $matkulId;
    public $search;

    #[On('tokenCreated')]
    public function handletokenCreated($token)
    {
        session()->flash('message', 'Token berhasil dibuat: ' . $token);
        session()->flash('message_type', 'success');
    }

    public function render()
    {
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

        return view('livewire.dosen.presensi.index', compact('presensi', 'matkul'));
    }
}
