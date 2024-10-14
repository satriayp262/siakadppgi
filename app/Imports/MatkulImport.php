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
    protected $editedRows = [];     // Array untuk menyimpan kode mata kuliah yang diupdate
    protected $errors = [];
    private $rowNumber = 2;
    protected $requiredFields = ['kode_mata_kuliah', 'nama_mk', 'jenis_mk', 'kode_prodi', 'sks_tatap_muka', 'sks_praktek', 'sks_prak_lapangan', 'sks_simulasi', 'metode_pembelajaran', 'tgl_mulai_efektif', 'tgl_akhir_efektif'];

    public function model(array $row)
    {
        // Check if data with 'kode_mata_kuliah' already exists
        $existingMatkul = Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->first();

        // Check for required fields
        foreach ($this->requiredFields as $field) {
            if (empty($row[$field])) {
                $this->errors[] = "Baris ke {$this->rowNumber}, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }
        }

        // Convert dates
        $tgl_mulai_efektif = $this->convertExcelDate($row['tgl_mulai_efektif']);
        $tgl_akhir_efektif = $this->convertExcelDate($row['tgl_akhir_efektif']);

        // If the 'kode_mata_kuliah' exists, update if the data is different
        if ($existingMatkul) {
            // Compare each field to check for differences
            $differences = [];
            if ($existingMatkul->nama_mata_kuliah !== $row['nama_mk']) {
                $differences[] = 'Nama Mata Kuliah';
                $existingMatkul->nama_mata_kuliah = $row['nama_mk'];
            }
            if ($existingMatkul->jenis_mata_kuliah !== $row['jenis_mk']) {
                $differences[] = 'Jenis Mata Kuliah';
                $existingMatkul->jenis_mata_kuliah = $row['jenis_mk'];
            }
            if ($existingMatkul->kode_prodi !== $row['kode_prodi']) {
                $differences[] = 'Kode Prodi';
                $existingMatkul->kode_prodi = $row['kode_prodi'];
            }
            if ($existingMatkul->sks_tatap_muka != $row['sks_tatap_muka']) {
                $differences[] = 'SKS Tatap Muka';
                $existingMatkul->sks_tatap_muka = $row['sks_tatap_muka'];
            }
            if ($existingMatkul->sks_praktek != $row['sks_praktek']) {
                $differences[] = 'SKS Praktek';
                $existingMatkul->sks_praktek = $row['sks_praktek'];
            }
            if ($existingMatkul->sks_praktek_lapangan != $row['sks_prak_lapangan']) {
                $differences[] = 'SKS Praktek Lapangan';
                $existingMatkul->sks_praktek_lapangan = $row['sks_prak_lapangan'];
            }
            if ($existingMatkul->sks_simulasi != $row['sks_simulasi']) {
                $differences[] = 'SKS Simulasi';
                $existingMatkul->sks_simulasi = $row['sks_simulasi'];
            }
            if ($existingMatkul->metode_pembelajaran !== $row['metode_pembelajaran']) {
                $differences[] = 'Metode Pembelajaran';
                $existingMatkul->metode_pembelajaran = $row['metode_pembelajaran'];
            }
            if ($existingMatkul->tgl_mulai_efektif !== $tgl_mulai_efektif) {
                $differences[] = 'Tanggal Mulai Efektif';
                $existingMatkul->tgl_mulai_efektif = $tgl_mulai_efektif;
            }
            if ($existingMatkul->tgl_akhir_efektif !== $tgl_akhir_efektif) {
                $differences[] = 'Tanggal Akhir Efektif';
                $existingMatkul->tgl_akhir_efektif = $tgl_akhir_efektif;
            }

            // If there are differences, update the record and add to edited rows array
            if (!empty($differences)) {
                $existingMatkul->save();
                $this->editedRows[] = "Kode Mata Kuliah {$row['kode_mata_kuliah']} diupdate (kolom diubah: " . implode(', ', $differences) . ") <br>";
            }

            $this->rowNumber++;
            return null;  // Skip inserting new record
        }

        // Insert new data if 'kode_mata_kuliah' doesn't exist
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
        $this->addedRows[] = $row['kode_mata_kuliah']; // Save newly added rows
        $this->rowNumber++;

        return $newMatkul;
    }


    // Fungsi untuk mengambil hasil
    public function getExistingRows()
    {
        return $this->existingRows;
    }

    public function getEditedRows()
    {
        return $this->editedRows;
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
