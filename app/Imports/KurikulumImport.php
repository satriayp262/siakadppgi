<?php

namespace App\Imports;

use App\Models\Kurikulum;
use App\Models\Semester;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KurikulumImport implements ToModel, WithHeadingRow
{
    protected $validKodeProdi;
    protected $validSemester;
    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = ['nama_kurikulum', 'mulai_berlaku', 'jumlah_sks_wajib', 'jumlah_sks_pilihan', 'kode_prodi'];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function __construct()
    {
        $this->validKodeProdi = Prodi::pluck('kode_prodi')->toArray();
        $this->validSemester = Semester::pluck('id_semester')->toArray();
    }

    public function model(array $row)
    {
        foreach ($this->requiredFields as $field) {
            if (empty($row[$field])) {
                $this->incompleteRecords[] = "Baris ke {$this->rowNumber} tidak lengkap, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }

            if (!Prodi::where('kode_prodi', $row['kode_prodi'])->exists()) {
                $this->incompleteRecords[] = "kode_prodi {$row['kode_prodi']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
                $this->rowNumber++;
                return null;
            }

            if (!Semester::where('nama_semester', $row['mulai_berlaku'])->exists()) {
                $this->incompleteRecords[] = "semester {$row['mulai_berlaku']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
                $this->rowNumber++;
                return null;
            } else {
                $idSemester = Semester::where('nama_semester', $row['mulai_berlaku'])->first()->id_semester;
            }

            $this->createdRecords[] = "nama_kurikulum = {$row['nama_kurikulum']} ,";
            $this->rowNumber++;


            return new Kurikulum([
                'nama_kurikulum' => $row['nama_kurikulum'],
                'mulai_berlaku' => $idSemester,
                'jumlah_sks_wajib' => $row['jumlah_sks_wajib'],
                'jumlah_sks_pilihan' => $row['jumlah_sks_pilihan'],
                'kode_prodi' => $row['kode_prodi'],
            ]);
        }
    }
    public function getSkippedRecords()
    {
        return $this->skippedRecords;
    }
    public function getCreatedRecords()
    {
        return $this->createdRecords;
    }
    public function getIncompleteRecords()
    {
        return $this->incompleteRecords;
    }
}