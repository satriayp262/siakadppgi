<?php

namespace App\Livewire\Mahasiswa\KartuUjian;

use App\Models\KRS;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Tagihan;
use App\Models\ttd;
use Illuminate\Support\Facades\Auth;


class Index extends Component
{
    public function generatePdf()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth::user()->nim_nidn)->firstOrFail();
        $kelas  = KRS::where('NIM', Auth::user()->nim_nidn)->firstOrFail();
        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('sesi')
            ->get();

        $groupedJadwals = collect($jadwals)->groupBy('hari');

        $ujian = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })->first();

        $komponen = ttd::first();

        $c = "";
        $y = "";
        $z = "";

        if ($ujian) {
            $x = substr($ujian->id_semester, -1);
            $c = ($x % 2 != 0) ? "Ganjil" : "Genap";
            $y = substr($ujian->semester->nama_semester, 0, 4);
            $z = $ujian->jenis_ujian;
        }

        $data = [
            'jadwals' => $jadwals,
            'groupedJadwals' => $groupedJadwals,
            'kelas' => $kelas,
            'mahasiswa' => $mahasiswa,
            'ujian' => $ujian,
            'komponen' => $komponen,
            'c' => $c,
            'y' => $y,
            'z' => $z
        ];

        $pdf = PDF::loadView('livewire.mahasiswa.kartu-ujian.download', $data);
        $pdf->setPaper('A5', 'landscape');


        if ($z == "UTS") {
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, 'kartu ' . $z . ' Semester ' . $c . ' Tahun Ajaran ' . $y . '-' . $y + 1 . '.pdf');


        }else{
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, 'kartu ' . $z . ' Semester ' . $c . ' Tahun Ajaran ' . $y . '-' . $y + 1 . '.pdf');

        }
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

        $groupedJadwals = collect($jadwals)->groupBy('hari');

        // $ujian = jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
        //     $query->where('NIM', $mahasiswa->NIM);
        // })
        //     ->first();

        $ujian = Jadwal::where('jenis_ujian', '!=', null)->first();

        $c = "";
        $y = "";
        $z = "";

        if ($ujian) {
            $x = substr($ujian->id_semester, -1);
            if ($x % 2 != 0) {
                $c = "Ganjil";
            } else {
                $c = "Genap";
            }

            $y = substr($ujian->semester->nama_semester, 0, 4);


            $z = $ujian->jenis_ujian;

            $kelas = KRS::where('NIM', Auth::user()->nim_nidn)->firstOrFail();

            $komponen = ttd::first();
        }

        return view('livewire.mahasiswa.kartu-ujian.index',[
            'jadwals' => $jadwals,
            'mahasiswa' => $mahasiswa,
            'ujian' => $ujian,
            'c' => $c,
            'y' => $y,
            'z' => $z,
            'kelas' => $kelas,
            'groupedJadwals' => $groupedJadwals,
            'komponen' => $komponen
        ]);
    }
}
