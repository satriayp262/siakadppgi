<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class MahasiswaPresensiExport implements FromCollection, WithHeadings
{
    protected $month;
    protected $year;
    protected $selectedProdi;

    // Constructor untuk menerima parameter filter
    public function __construct($month, $year, $selectedProdi)
    {
        $this->month = $month;
        $this->year = $year;
        $this->selectedProdi = $selectedProdi;
    }

    // Mengambil data mahasiswa yang sudah difilter
    public function collection()
    {
        // Ambil data mahasiswa dengan filter bulan, tahun, dan program studi
        $dataMahasiswa = Mahasiswa::withCount([
            'presensi as hadir_count' => function ($query) {
                $query->where('keterangan', 'Hadir')
                      ->whereMonth('created_at', $this->month)
                      ->whereYear('created_at', $this->year);
            },
            'presensi as ijin_count' => function ($query) {
                $query->where('keterangan', 'Ijin')
                      ->whereMonth('created_at', $this->month)
                      ->whereYear('created_at', $this->year);
            },
            'presensi as sakit_count' => function ($query) {
                $query->where('keterangan', 'Sakit')
                      ->whereMonth('created_at', $this->month)
                      ->whereYear('created_at', $this->year);
            },
        ])
        ->when($this->selectedProdi, function ($query) {
            $query->where('kode_prodi', $this->selectedProdi);
        })
        ->get();

        // Format data mahasiswa untuk di-export
        $formattedData = $dataMahasiswa->map(function ($mahasiswa) {
            return [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->NIM,
                'prodi' => $mahasiswa->prodi->nama_prodi,
                'hadir' => $mahasiswa->hadir_count,
                'ijin' => $mahasiswa->ijin_count,
                'sakit' => $mahasiswa->sakit_count,
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        return [
            'Nama Mahasiswa',
            'NIM',
            'Program Studi',
            'Hadir',
            'Ijin',
            'Sakit',
        ];
    }
}
