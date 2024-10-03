<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
class DosenExport implements FromArray, WithHeadings
{
    // Define headers untuk template Excel
    public function headings(): array
    {
        return [
            'NIDN',
            'Nama Dosen',
            'Jenis Kelamin',
            'Jabatan Fungsional',
            'Kepangkatan',
            'Kode Prodi'
        ];
    }

    // Return empty array karena ini template
    public function array(): array
    {
        return [];
    }
}
