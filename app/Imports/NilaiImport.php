<?php

namespace App\Imports;

use App\Models\KRS;
use App\Models\Matakuliah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Aktifitas;

class NilaiImport implements ToModel, WithHeadingRow
{
    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $updatedRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = ['nim'];
    public $id_kelas,$nidn,$kode_mata_kuliah,$id_mata_kuliah;

    public function __construct($id_kelas,$kode_mata_kuliah)
    {
        $this->id_kelas = $id_kelas ?? null;
        $this->kode_mata_kuliah = $kode_mata_kuliah ?? null;
        $this->nidn = Auth()->user()->nim_nidn;
        $this->id_mata_kuliah = Matakuliah::where('nidn', $this->nidn)->where('kode_mata_kuliah', $this->kode_mata_kuliah)->first()->id_mata_kuliah;


    }
    public function model(array $row)
    {
        if (
            collect($row)->every(function ($value) {
                return is_null($value) || trim($value) === '';
            })
        ) {
            $this->rowNumber++;
            return null;
        }

        foreach ($this->requiredFields as $field) {
            if (is_null($row[$field]) || $row[$field] === '') {
                $this->incompleteRecords[] =
                    "Baris ke {$this->rowNumber} tidak lengkap, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }
        }

        if (!Mahasiswa::where('nim', $row['nim'])->exists()) {
            $this->incompleteRecords[] =
                "NIM {$row['nim']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }
        if(!KRS::where('NIM', $row['nim'])->where('id_mata_kuliah', $this->id_mata_kuliah)->exists()){
            $this->incompleteRecords[] =
                "Mahasiswa dengan NIM {$row['nim']} pada baris ke {$this->rowNumber} tidak terdaftar pada kelas ini <br>";
            $this->rowNumber++;
            return null;
        }


        foreach ($row as $column => $value) {
            if (isset($row['Nama']) && $row['Nama']) {
                continue; 
            }
        
            if ($column === 'nim' || is_null($value) || $value === '' || $column === 'nama') {
                continue;
            }
            if ($column === 'uts') {
                $formattedColumn = 'UTS';
            }elseif ($column === 'uas') {
                $formattedColumn = 'UAS';
            }else{
                $formattedColumn = ucwords(str_replace('_', ' ', $column));
            }
        
        
            $aktifitas = Aktifitas::firstOrCreate(
                [
                    'nama_aktifitas' => $formattedColumn,
                    'id_kelas' => $this->id_kelas, 
                    'id_mata_kuliah' => $this->id_mata_kuliah, 
                ],
                [
                    'catatan' => $formattedColumn, 
                ]
            );
        
            if (!$aktifitas->id_aktifitas) {
                $this->skippedRecords[] = "Aktifitas '{$formattedColumn}' tidak valid.";
                continue;
            }
        
            $existingRecord = Nilai::where('NIM', $row['nim'])->where('id_aktifitas', $aktifitas->id_aktifitas)->first();
        
            if ($existingRecord) {
                $existingRecord->update([
                    'nilai' => $value,
                ]);
                $this->updatedRecords[] = "Baris ke {$this->rowNumber} berhasil diperbarui.";
            } else {
                Nilai::create([
                    'NIM' => $row['nim'],
                    'id_aktifitas' => $aktifitas->id_aktifitas,
                    'id_kelas' => $this->id_kelas,
                    'nilai' => $value,
                ]);
                $this->createdRecords[] = "Baris ke {$this->rowNumber} berhasil disimpan.";
            }
        }
        

        $this->rowNumber++;
    }

    public function getSkippedRecords()
    {
        return $this->skippedRecords;
    }

    public function getCreatedRecords()
    {
        return $this->createdRecords;
    }

    public function getUpdatedRecords()
    {
        return $this->updatedRecords;
    }

    public function getIncompleteRecords()
    {
        return $this->incompleteRecords;
    }
}
