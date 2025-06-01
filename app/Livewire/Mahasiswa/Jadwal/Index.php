<?php

namespace App\Livewire\Mahasiswa\Jadwal;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\Kelas;
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
        $kelas = Kelas::whereHas('krs', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })->first();
        $krs = KRS::where('NIM', $mahasiswa->NIM)
                    ->where('id_semester', $kelas->id_semester)
                    ->first();

        $jadwals = Jadwal::whereHas('kelas.krs', function ($query) use ($mahasiswa, $krs) {
            $query->where('NIM', $mahasiswa->NIM)
                ->where(function ($q) use ($krs) {
                    $q->whereNull('grup') // Tampilkan semua jadwal tanpa grup
                        ->orWhere('grup', $krs->grup_praktikum); // Tampilkan yang cocok dengan grup
                });
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('sesi')
            ->get();

        $jadwal = $jadwals->first();

        return view('livewire.mahasiswa.jadwal.index', [
            'jadwals' => $jadwals,
            'jadwal' => $jadwal
        ]);
    }
}
