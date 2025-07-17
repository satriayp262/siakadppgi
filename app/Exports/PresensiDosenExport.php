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
            ->whereHas('tokens', function ($query) {
                if ($this->selectedSemester) {
                    $query->where('id_semester', $this->selectedSemester);
                }
                if ($this->selectedProdi) {
                    $query->where('kode_prodi', $this->selectedProdi);
                }
            })
            ->withCount(['tokens as tokens_count' => function ($query) {
                if ($this->selectedSemester) {
                    $query->where('id_semester', $this->selectedSemester);
                }
                if ($this->selectedProdi) {
                    $query->where('kode_prodi', $this->selectedProdi);
                }
            }])
            ->where(function ($query) {
                // Filter pencarian berdasarkan nama dosen, nidn, atau prodi
                $query->where('nama_dosen', 'like', '%' . $this->search . '%')
                    ->orWhere('nidn', 'like', '%' . $this->search . '%')
                    ->orWhereHas('prodi', function ($q) {
                        $q->where('nama_prodi', 'like', '%' . $this->search . '%');
                    });
            })
            ->get()
            ->map(function ($dosen) {
                // Menambahkan kolom total_jam berdasarkan jumlah token yang dihitung
                $dosen->total_jam = ($dosen->tokens_count ?? 0) * 1.5; // Asumsi 1 token = 1.5 jam
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
