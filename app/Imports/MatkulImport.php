<?php

namespace App\Imports;

use App\Models\Matakuliah;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class MatkulImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $tgl_mulai_efektif = $this->convertExcelDate($row['tgl_mulai_efektif']);
        $tgl_akhir_efektif = $this->convertExcelDate($row['tgl_akhir_efektif']);
        // dd($tgl_mulai_efektif, $tgl_akhir_efektif);
        return new Matakuliah([
            'kode_mata_kuliah' => $row['kode_mata_kuliah'],
            'nama_mata_kuliah' => $row['nama_mk'],
            'jenis_mata_kuliah' => $row['jenis_mk'],
            'kode_prodi' => $row['kode_prodi'],
            'sks_tatap_muka' => $row['sks_tatap_muka'],
            'sks_praktek' => $row['sks_praktek'],
            'sks_praktek_lapangan' => $row['sks_prak_lapangan'],
            'sks_simulasi' => $row['sks_simulasi'],
            'metode_pembelajaran' => $row['metode_pembelajaran'],
            'tgl_mulai_efektif' => $tgl_mulai_efektif,
            'tgl_akhir_efektif' => $tgl_akhir_efektif,
        ]);
    }

    protected function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // If the date is numeric, it's likely an Excel date
            $dateTime = Date::excelToDateTimeObject($excelDate);
            return Carbon::instance($dateTime)->format('Y-m-d');
        }
        
        // If it's a string, try parsing it directly
        try {
            return Carbon::createFromFormat('Y-m-d', trim($excelDate))->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::error('Date conversion error: ' . $e->getMessage());
            return null; // or set a default date
        }
    }
}

