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

    // Konstruktor untuk menerima parameter
    public function __construct($month, $year, $search, $selectedProdi)
    {
        $this->month = $month;
        $this->year = $year;
        $this->search = $search;
        $this->selectedProdi = $selectedProdi;
    }

    // Mendapatkan data koleksi yang akan diekspor
    public function collection()
    {
        return Dosen::withCount(['tokens' => function ($query) {
            $query->whereMonth('token.created_at', $this->month)
                ->whereYear('token.created_at', $this->year);
        }])
            ->where(function ($query) {
                $query->where('nama_dosen', 'like', '%' . $this->search . '%')
                    ->orWhere('nidn', 'like', '%' . $this->search . '%')
                    ->orWhereHas('prodi', function ($q) {
                        $q->where('nama_prodi', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->selectedProdi, function ($query) {
                $query->whereHas('prodi', function ($q) {
                    $q->where('kode_prodi', $this->selectedProdi);
                });
            })
            ->get()
            ->map(function ($dosen) {
                $dosen->total_jam = $dosen->tokens_count * 1.5;
                return $dosen;
            });
    }

    // Menentukan judul kolom
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
