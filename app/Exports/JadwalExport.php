<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class JadwalExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    public function headings(): array
    {
        return [
            'Hari',
            'sesi',
            'Kelas',
            'Dosen',
            
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
