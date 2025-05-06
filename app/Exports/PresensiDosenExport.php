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

    public function __construct($month, $year, $search, $selectedProdi, $selectedSemester)
    {
        $this->month = $month;
        $this->year = $year;
        $this->search = $search;
        $this->selectedProdi = $selectedProdi;
        $this->selectedSemester = $selectedSemester;
    }

    public function collection()
    {
        return Dosen::with(['prodi'])
            ->withCount(['tokens as tokens_count' => function ($query) {
                $query->where('id_semester', $this->selectedSemester);
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
                $dosen->total_jam = ($dosen->tokens_count ?? 0) * 1.5;
                return $dosen;
            });
    }

    public function headings(): array
    {
        return [
            'Nama Dosen',
            'NIDN',
            'Prodi',
            'Jumlah Token',
            'Jumlah Jam',
        ];
    }

    public function map($dosen): array
    {
        return [
            $dosen->nama_dosen,
            $dosen->nidn,
            $dosen->prodi->nama_prodi ?? '-',
            $dosen->tokens_count ?? 0,
            $dosen->total_jam ?? 0,
        ];
    }
}
