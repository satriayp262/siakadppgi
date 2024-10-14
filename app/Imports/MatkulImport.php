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
        $existingRows = Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->first();

        if ($existingRows) {
            $this->existingRows[] = "Kode Mata Kuliah {$row['kode_mata_kuliah']} sudah ada <br>";
        }

        // Check for required fields
        $error = [];  // Initialize error array outside the loop
        foreach ($this->requiredFields as $field) {
            if (empty($row[$field])) {
                // Add field to the error array based on which one is missing
                if ($field === 'kode_mata_kuliah')
                    $error[] = 'Kode Mata Kuliah';
                if ($field === 'nama_mk')
                    $error[] = 'Nama Mata Kuliah';
                if ($field === 'jenis_mk')
                    $error[] = 'Jenis Mata Kuliah';
                if ($field === 'kode_prodi')
                    $error[] = 'Kode Prodi';
                if ($field === 'sks_tatap_muka')
                    $error[] = 'SKS Tatap Muka';
                if ($field === 'sks_praktek')
                    $error[] = 'SKS Praktek';
                if ($field === 'sks_prak_lapangan')
                    $error[] = 'SKS Praktek Lapangan';
                if ($field === 'sks_simulasi')
                    $error[] = 'SKS Simulasi';
                if ($field === 'metode_pembelajaran')
                    $error[] = 'Metode Pembelajaran';
                if ($field === 'tgl_mulai_efektif')
                    $error[] = 'Tanggal Mulai Efektif';
                if ($field === 'tgl_akhir_efektif')
                    $error[] = 'Tanggal Akhir Efektif';
            }
        }

        if (!empty($error)) {
            // After all fields are checked, generate the error message
            $this->errors[] = "Baris ke {$this->rowNumber}, Kolom " . implode(', ', $error) . " tidak boleh kosong <br>";
            $this->rowNumber++;  // Increment the row number for the next iteration
            return null;  // Exit after logging all errors for this row
        }

            // Convert dates
            $tgl_mulai_efektif = $this->convertExcelDate($row['tgl_mulai_efektif']);
            $tgl_akhir_efektif = $this->convertExcelDate($row['tgl_akhir_efektif']);

            // If the 'kode_mata_kuliah' exists, update if the data is different
            if ($existingRows) {
                // Compare each field to check for differences
                $differences = [];
                if ($existingRows->nama_mata_kuliah !== $row['nama_mk']) {
                    $differences[] = 'Nama Mata Kuliah';
                }
                if ($existingRows->jenis_mata_kuliah !== $row['jenis_mk']) {
                    $differences[] = 'Jenis Mata Kuliah';
                }
                if ($existingRows->kode_prodi !== $row['kode_prodi']) {
                    $differences[] = 'Kode Prodi';
                }
                if ($existingRows->sks_tatap_muka != $row['sks_tatap_muka']) {
                    $differences[] = 'SKS Tatap Muka';
                }
                if ($existingRows->sks_praktek != $row['sks_praktek']) {
                    $differences[] = 'SKS Praktek';
                }
                if ($existingRows->sks_praktek_lapangan != $row['sks_prak_lapangan']) {
                    $differences[] = 'SKS Praktek Lapangan';
                }
                if ($existingRows->sks_simulasi != $row['sks_simulasi']) {
                    $differences[] = 'SKS Simulasi';
                }
                if ($existingRows->metode_pembelajaran !== $row['metode_pembelajaran']) {
                    $differences[] = 'Metode Pembelajaran';
                }
                if ($existingRows->tgl_mulai_efektif !== $tgl_mulai_efektif) {
                    $differences[] = 'Tanggal Mulai Efektif';
                }
                if ($existingRows->tgl_akhir_efektif !== $tgl_akhir_efektif) {
                    $differences[] = 'Tanggal Akhir Efektif';
                }

                // If there are differences, update the record and add to edited rows array
                if (!empty($differences)) {
                    $existingRows->save();
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
            $this->addedRows[] = "Kode Mata Kuliah {$row['kode_mata_kuliah']} berhasil ditambahkan <br>";
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
