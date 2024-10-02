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
    protected $existingRows = [];  // Array untuk menyimpan kode mata kuliah yang sudah ada
    protected $addedRows = [];      // Array untuk menyimpan kode mata kuliah yang berhasil ditambahkan
    protected $errors = [];
    private $rowNumber = 2;
    protected $requiredFields = ['kode_mata_kuliah', 'nama_mk', 'jenis_mk', 'kode_prodi', 'sks_tatap_muka', 'sks_praktek', 'sks_prak_lapangan', 'sks_simulasi', 'metode_pembelajaran', 'tgl_mulai_efektif', 'tgl_akhir_efektif'];

    public function model(array $row)
    {
        // Cek apakah data dengan 'kode_mata_kuliah' yang sama sudah ada
        $existingMatkul = Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->exists();

        foreach ($this->requiredFields as $field) {
            if (empty($row[$field])) {
                $this->errors[] = "Baris ke {$this->rowNumber}, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }
        }

        if ($existingMatkul) {
            $this->existingRows[] = "{$row['kode_mata_kuliah']} Kode Mata Kuliah sudah ada <br>"; // Simpan kode yang sudah ada
            $this->rowNumber++;
            return null;  // Skip row if it already exists
        }


        // Convert dates
        $tgl_mulai_efektif = $this->convertExcelDate($row['tgl_mulai_efektif']);
        $tgl_akhir_efektif = $this->convertExcelDate($row['tgl_akhir_efektif']);

        // Insert data baru
        $newMatkul = new Matakuliah([
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
        $this->addedRows[] = $row['kode_mata_kuliah']; // Simpan kode yang berhasil ditambahkan

        $this->rowNumber++;

        return $newMatkul;
    }

    // Fungsi untuk mengambil hasil
    public function getExistingRows()
    {
        return $this->existingRows;
    }

    public function getAddedRows()
    {
        return $this->addedRows;
    }

    public function geterrors()
    {
        return $this->errors;
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
