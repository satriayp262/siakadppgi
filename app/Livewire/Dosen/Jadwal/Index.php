<?php

namespace App\Livewire\Dosen\Jadwal;

use App\Models\Dosen;
use App\Models\Jadwal;
use Livewire\Component;

class Index extends Component
{

    public $dosen;

    public function mount()
    {
        $this->dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();
    }

    public function render()
    {
        $dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($dosen) {
            $query->where('nidn', $dosen->nidn);
        })
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")  // Urutkan hari sesuai urutan minggu
            ->orderBy('sesi')  // Urutkan berdasarkan sesi
            ->get();

        return view('livewire.dosen.jadwal.index',[
            'jadwals' => $jadwals
        ]);
    }
}
