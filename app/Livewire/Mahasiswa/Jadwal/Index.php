<?php

namespace App\Livewire\Mahasiswa\Jadwal;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\Semester;
use App\Models\Jadwal;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{
    public $mahasiswa;


    public function mount()
    {
        $this->mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();
    }

    public function generatePdf()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();
        $semester = semester::where('is_active', 1)->first();
        $krs = KRS::where('NIM', $mahasiswa->NIM)
            ->where('id_semester', $semester->id_semester)
            ->first();

        // dd($krs->grup_praktikum);

        $jadwals = Jadwal::whereHas('kelas.krs', function ($query) use ($mahasiswa, $krs) {
            $query->where('NIM', $mahasiswa->NIM)
                ->where(function ($q) use ($krs) {
                    $q->whereNull('grup') // Tampilkan semua jadwal tanpa grup
                        ->orWhere('grup', $krs->grup_praktikum); // Tampilkan yang cocok dengan grup
                });
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('sesi')
            ->get();

        $jadwal = $jadwals->first();

        $data = [
            'jadwals' => $jadwals,
            'jadwal' => $jadwal
        ];

        $pdf = PDF::loadView('livewire.mahasiswa.jadwal.download', $data);


        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Jadwal Perkulihan Semester ' . $jadwals[0]->semester->nama_semester . '.pdf');
    }

    public function render()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();
        $semester = semester::where('is_active', 1)->first();
        $krs = KRS::where('NIM', $mahasiswa->NIM)
                    ->where('id_semester', $semester->id_semester)
                    ->first();

                    // dd($krs->grup_praktikum);

        $jadwals = Jadwal::whereHas('kelas.krs', function ($query) use ($mahasiswa, $krs) {
            $query->where('NIM', $mahasiswa->NIM)
                ->where(function ($q) use ($krs) {
                    $q->whereNull('grup') // Tampilkan semua jadwal tanpa grup
                        ->orWhere('grup', $krs->grup_praktikum); // Tampilkan yang cocok dengan grup
                });
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('sesi')
            ->get();

        $jadwal = $jadwals->first();

        return view('livewire.mahasiswa.jadwal.index', [
            'jadwals' => $jadwals,
            'jadwal' => $jadwal
        ]);
    }
}
