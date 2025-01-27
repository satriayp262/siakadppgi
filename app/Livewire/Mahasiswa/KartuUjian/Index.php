<?php

namespace App\Livewire\Mahasiswa\KartuUjian;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Jadwal;


class Index extends Component
{

    public function render()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();

        $jadwals = Jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")  // Urutkan hari sesuai urutan minggu
            ->orderBy('sesi')  // Urutkan berdasarkan sesi
            ->get();

        $ujian = jadwal::whereHas('kelas.krs.mahasiswa', function ($query) use ($mahasiswa) {
            $query->where('NIM', $mahasiswa->NIM);
        })
            ->first();

        $c = "";
        $y = "";
        $z = "";

        if ($ujian) {
            $x = substr($ujian->id_semester, -1);
            if ($x % 2 != 0) {
                $c = "GANJIL";
            } else {
                $c = "GENAP";
            }

            $y = substr($ujian->semester->nama_semester, 0, 4);

            $z = $ujian->jenis_ujian;
        }

        return view('livewire.mahasiswa.kartu-ujian.index',[
            'jadwals' => $jadwals,
            'mahasiswa' => $mahasiswa,
            'ujian' => $ujian,
            'c' => $c,
            'y' => $y,
            'z' => $z
        ]);
    }
}
