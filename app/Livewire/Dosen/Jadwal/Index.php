<?php

namespace App\Livewire\Dosen\Jadwal;

use App\Models\Dosen;
use App\Models\Jadwal;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{

    public $dosen;

    public function mount()
    {
        $this->dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();
    }

    public function generatePdf()
    {
        $dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($dosen) {
            $query->where('nidn', $dosen->nidn);
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('sesi')  // Urutkan berdasarkan sesi
            ->get();

        $x = $jadwals->first();

        $data = [
            'jadwals' => $jadwals,
            'x' => $x
        ];

        $pdf = PDF::loadView('livewire.dosen.jadwal.download', $data);


        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Jadwal Mengajar Dosen ' . $dosen->nama_dosen . ' Semester ' . $jadwals[0]->semester->nama_semester . '.pdf');
    }

    public function render()
    {
        $dosen = Dosen::where('nidn', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($dosen) {
            $query->where('nidn', $dosen->nidn);
        })
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('sesi')  // Urutkan berdasarkan sesi
            ->get();

        return view('livewire.dosen.jadwal.index',[
            'jadwals' => $jadwals
        ]);
    }
}
