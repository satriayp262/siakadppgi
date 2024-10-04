<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class MatkulExport implements FromArray, WithHeadings
{
    // Define headers untuk template Excel
    public function headings(): array
    {
        return [
            'ID Mata Kuliah',
            'Kode Mata Kuliah',
            'Nama Mata Kuliah',
            'Jenis Mata Kuliah',
            'Kode Prodi',
            'SKS Tatap Muka',
            'SKS Praktek',
            'SKS Praktek Lapangan',
            'SKS Simulasi',
            'Metode Pembelajaran',
            'Tanggal Mulai Efektif',
            'Tanggal Akhir Efektif',
        ];
    }

    // Return empty array karena ini template
    public function array(): array
    {
        return [
            [
                '', // ID Mata Kuliah
                '', // Kode Mata Kuliah
                '', // Nama Mata Kuliah
                '', // Jenis Mata Kuliah
                '', // Kode Prodi
                '', // SKS Tatap Muka
                '', // SKS Praktek
                '', // SKS Praktek Lapangan
                '', // SKS Simulasi
                '', // Metode Pembelajaran
                '', // Tanggal Mulai Efektif
                '', // Tanggal Akhir Efektif
            ],
        ];
    }
}
