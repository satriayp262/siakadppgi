<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class MahasiswaExport implements FromArray, WithHeadings
{
    // Define headers untuk template Excel
    public function headings(): array
    {
        return [
            'ID Mahasiswa',
            'ID Orang Tua/Wali',
            'NIM',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'NIK',
            'Agama',
            'Alamat',
            'Jalur Pendaftaran',
            'Kewarganegaraan',
            'Jenis Pendaftaran',
            'Tanggal Masuk Kuliah',
            'Mulai Semester',
            'Jenis Tempat Tinggal',
            'Telp Rumah',
            'No HP',
            'Email',
            'Terima KPS',
            'No KPS',
            'Jenis Transportasi',
            'Kode Prodi',
            'SKS Diakui',
            'Kode PT Asal',
            'Nama PT Asal',
            'Kode Prodi Asal',
            'Nama Prodi Asal',
            'Jenis Pembiayaan',
            'Jumlah Biaya Masuk',
            'ID User',
        ];
    }

    // Return empty array karena ini template
    public function array(): array
    {
        return [
            [
                '', // ID Mahasiswa
                '', // ID Orang Tua/Wali
                '', // NIM
                '', // Nama
                '', // Tempat Lahir
                '', // Tanggal Lahir
                '', // Jenis Kelamin
                '', // NIK
                '', // Agama
                '', // Alamat
                '', // Jalur Pendaftaran
                '', // Kewarganegaraan
                '', // Jenis Pendaftaran
                '', // Tanggal Masuk Kuliah
                '', // Mulai Semester
                '', // Jenis Tempat Tinggal
                '', // Telp Rumah
                '', // No HP
                '', // Email
                '', // Terima KPS
                '', // No KPS
                '', // Jenis Transportasi
                '', // Kode Prodi
                '', // SKS Diakui
                '', // Kode PT Asal
                '', // Nama PT Asal
                '', // Kode Prodi Asal
                '', // Nama Prodi Asal
                '', // Jenis Pembiayaan
                '', // Jumlah Biaya Masuk
                '', // ID User
            ],
        ];
    }
}
