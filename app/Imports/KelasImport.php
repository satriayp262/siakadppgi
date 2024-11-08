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
    protected $requiredFields = ['nama_kelas', 'bahasan', 'lingkup_kelas', 'mode_kelas', 'id_mata_kuliah', 'semester', 'kode_prodi'];
    public function __construct()
    {
        $this->validKodeProdi = Prodi::pluck('kode_prodi')->toArray();
        $this->validSemester = Semester::pluck('semester')->toArray();
        $this->validMatkul = Matakuliah::pluck('id_mata_kuliah')->toArray();

    }

    public function model(array $row)
    {

        return new Kelas([
            'id' => $row['id'] ?? null,
            'nama_kelas' => $row['nama_kelas'],
            'semester' => $row['semester'],
            'lingkup_kelas' => $row['lingkup_kelas'],
            'mode_kelas' => $row['mode_kelas'],
            'id_mata_kuliah' => $row['id_mata_kuliah'],
            'kode_prodi' => $row['kode_prodi'],
        ]);
    }

}
