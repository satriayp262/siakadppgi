<?php

namespace App\Livewire\Mahasiswa\Jadwal;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Jadwal;

class Index extends Component
{
    public $mahasiswa;


    public function mount()
    {
        $this->mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();
    }
    public function render()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")  // Urutkan hari sesuai urutan minggu
            ->orderBy('sesi')  // Urutkan berdasarkan sesi
            ->get();

        $jadwal = $jadwals->first();

        return view('livewire.mahasiswa.jadwal.index',[
            'jadwals' => $jadwals,
            'jadwal' => $jadwal
        ]);
    }
}
