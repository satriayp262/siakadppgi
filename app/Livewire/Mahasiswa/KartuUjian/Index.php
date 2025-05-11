<?php

namespace App\Livewire\Mahasiswa\KartuUjian;

use App\Models\KRS;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\Tagihan;
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

        $ujian = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })->first();

        $c = "";
        $y = "";
        $z = "";

        if ($ujian) {
            $x = substr($ujian->id_semester, -1);
            $c = ($x % 2 != 0) ? "GANJIL" : "GENAP";
            $y = substr($ujian->semester->nama_semester, 0, 4);
            $z = $ujian->jenis_ujian;
        }

        $data = [
            'jadwals' => $jadwals,
            'kelas' => $kelas,
            'mahasiswa' => $mahasiswa,
            'ujian' => $ujian,
            'c' => $c,
            'y' => $y,
            'z' => $z
        ];

        $pdf = PDF::loadView('livewire.mahasiswa.kartu-ujian.download', $data);
        $pdf->setPaper('A5', 'landscape');

        $pembayaran = Tagihan::where('NIM', Auth::user()->nim_nidn)->firstOrFail();
        $w = $pembayaran->total_bayar;
        $s = $pembayaran->total_tagihan;
        $a = $s/2;

        if ($z == "UTS") {
            if ($w < $a) {
                $this->dispatch('warning', ['message' => 'Lunasi Pembayaran dari bulan A sampai bulan D terlebih dahulu']);
            }else{
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, 'kartu ' . $z . ' Semester ' . $c . ' Tahun Ajaran ' . $y . '-' . $y + 1 . '.pdf');
            }

        }else{
            if ($w < $s) {
                $this->dispatch('warning', ['message' => 'Lunasi Semua Pembayaran terlebih dahulu']);
            }else{
                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, 'kartu ' . $z . ' Semester ' . $c . ' Tahun Ajaran ' . $y . '-' . $y + 1 . '.pdf');
            }
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

        // $ujian = jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
        //     $query->where('NIM', $mahasiswa->NIM);
        // })
        //     ->first();

        $ujian = Jadwal::where('jenis_ujian', '!=', null)->first();

        $c = "";
        $y = "";
        $z = "";
        $w = "";
        $a = "";
        $s = "";
        $pembayaran = "";

        if ($ujian) {
            $x = substr($ujian->id_semester, -1);
            if ($x % 2 != 0) {
                $c = "GANJIL";
            } else {
                $c = "GENAP";
            }

            $y = substr($ujian->semester->nama_semester, 0, 4);


            $z = $ujian->jenis_ujian;

            $pembayaran = Tagihan::where('NIM', Auth::user()->nim_nidn)->first();
            if ($pembayaran != null) {
                $w = $pembayaran->total_bayar;
                $s = $pembayaran->total_tagihan;
                $a = $s / 2;
            }
        }

        return view('livewire.mahasiswa.kartu-ujian.index',[
            'jadwals' => $jadwals,
            'mahasiswa' => $mahasiswa,
            'pembayaran' => $pembayaran,
            'ujian' => $ujian,
            'c' => $c,
            'y' => $y,
            'z' => $z,
            'w' => $w,
            'a' => $a,
            's' => $s
        ]);
    }
}
