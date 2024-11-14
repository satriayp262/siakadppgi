<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\Semester;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $validKodeProdi;
    protected $validSemester;
    protected $validMatkul;
    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = ['semester', 'id_mata_kuliah', 'nama_kelas', 'bahasan', 'lingkup_kelas', 'mode_kuliah', 'kode_prodi'];
    public function __construct()
    {
        $this->validKodeProdi = Prodi::pluck('kode_prodi')->toArray();
        $this->validSemester = Semester::pluck('id_semester')->toArray();
        $this->validMatkul = Matakuliah::pluck('id_mata_kuliah')->toArray();
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

            if (!Semester::where('nama_semester', $row['semester'])->exists()) {
                $this->incompleteRecords[] = "semester {$row['semester']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
                $this->rowNumber++;
                return null;
            } else {
                $idSemester = Semester::where('nama_semester', $row['semester'])->first()->id_semester;
            }

            if (!Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->exists()) {
                $this->incompleteRecords[] = "kode_mata_kuliah {$row['kode_mata_kuliah']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
                $this->rowNumber++;
                return null;
            } else {
                $idMatkul = Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->first()->id_mata_kuliah;
            }

            $this->createdRecords[] = "nama_kelas = {$row['nama_kelas']} ,";
            $this->rowNumber++;



            return new Kelas([
                'id' => $row['id'] ?? null,
                'semester' => $idSemester,
                'id_mata_kuliah' => $idMatkul,
                'nama_kelas' => $row['nama_kelas'],
                'bahasan' => $row['bahasan'],
                'lingkup_kelas' => $row['lingkup_kelas'],
                'mode_kuliah' => $row['mode_kuliah'],
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