<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PresensiDosenExport implements FromCollection, WithHeadings, WithMapping
{
    public $month;
    public $year;
    public $search;
    public $selectedProdi;
    public $selectedSemester;

    // Konstruktor untuk menerima parameter
    public function __construct($month, $year, $search, $selectedProdi, $selectedSemester)
    {
        $this->month = $month;
        $this->year = $year;
        $this->search = $search;
        $this->selectedProdi = $selectedProdi;
        $this->selectedSemester = $selectedSemester; // Semester parameter
    }

    // Mendapatkan data koleksi yang akan diekspor
    public function collection()
    {
        return Dosen::withCount(['tokens' => function ($query) {
            // Filter berdasarkan bulan, tahun, dan semester
            $query->whereMonth('token.created_at', $this->month)
                  ->whereYear('token.created_at', $this->year)
                  ->when($this->selectedSemester, function ($query) {
                      // Filter berdasarkan semester jika ada
                      $query->whereHas('semester', function ($query) {
                          $query->where('id_semester', $this->selectedSemester);
                      });
                  });
        }])
        ->where(function ($query) {
            // Pencarian dosen berdasarkan nama, nidn, atau nama prodi
            $query->where('nama_dosen', 'like', '%' . $this->search . '%')
                  ->orWhere('nidn', 'like', '%' . $this->search . '%')
                  ->orWhereHas('prodi', function ($q) {
                      $q->where('nama_prodi', 'like', '%' . $this->search . '%');
                  });
        })
        ->when($this->selectedProdi, function ($query) {
            // Filter berdasarkan kode prodi
            $query->whereHas('prodi', function ($q) {
                $q->where('kode_prodi', $this->selectedProdi);
            });
        })
        ->get()
        ->map(function ($dosen) {
            // Menambahkan total jam berdasarkan jumlah token yang ada
            $dosen->total_jam = $dosen->tokens_count * 1.5;
            return $dosen;
        });
    }

    // Menentukan judul kolom di file Excel
    public function headings(): array
    {
        return [
            'Nama Dosen',
            'NIDN',
            'Prodi',
            'Jumlah Token',
            'Jumlah Jam'
        ];
    }

    // Menentukan data yang akan diekspor per baris
    public function map($dosen): array
    {
        return [
            $dosen->nama_dosen,
            $dosen->nidn,
            $dosen->prodi->nama_prodi,
            $dosen->tokens_count ?? '-',
            $dosen->total_jam ?? '-',
        ];
    }
}
