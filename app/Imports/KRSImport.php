<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\KRS;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Kelas;

class KRSImport implements ToModel, WithHeadingRow
{
    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = [
        'nim',
        'semester',
        'kode_mata_kuliah',
        'nama_kelas',
        'kode_prodi',
    ];


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

        if (!Prodi::where('kode_prodi', $row['kode_prodi'])->exists()) {
            $this->incompleteRecords[] =
                "kode_prodi {$row['kode_prodi']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        } else {
            if ($row['nama_prodi'] != null) {
                $idProdi = Prodi::where('kode_prodi', $row['kode_prodi'])
                    ->where('nama_prodi', $row['nama_prodi'])
                    ->first()->id_prodi;
            } else {
                $idProdi = Prodi::where('kode_prodi', $row['kode_prodi'])->first()->id_prodi;
            }
        }

        if (!Semester::where('nama_semester', $row['semester'])->exists()) {
            $this->incompleteRecords[] =
                "semester {$row['semester']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        } else {
            $idSemester = Semester::where('nama_semester', $row['semester'])->first()->id_semester;
        }

        if (!mahasiswa::where('NIM', $row['nim'])->exists()) {
            $this->incompleteRecords[] =
                "NIM {$row['nim']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }

        if (!matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->exists()) {
            $this->incompleteRecords[] =
                "Kode matakuliah {$row['kode_mata_kuliah']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        } else {
            if ($row['nama_mata_kuliah'] != null) {
                $idmata_kuliah = matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])
                    ->where('nama_mata_kuliah', $row['nama_mata_kuliah'])
                    ->first()->id_mata_kuliah;
            } else {
                $idmata_kuliah = matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->first()->id_mata_kuliah;
            }
        }

        if (!kelas::where('nama_kelas', $row['nama_kelas'])->exists()) {
            $this->incompleteRecords[] =
                "Nama Kelas {$row['nama_kelas']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        } else {
            $idkelas = kelas::where('nama_kelas', $row['nama_kelas'])->first()->id_kelas;
        }
        if (kelas::where('nama_kelas', $row['nama_kelas'])->first()->matkul->kode_mata_kuliah != $row['kode_mata_kuliah']) {
            $this->incompleteRecords[] =
                "Kelas {$row['nama_kelas']} pada baris ke {$this->rowNumber} tidak sesuai dengan mata kuliah pada baris ke {$this->rowNumber} <br>";
            $this->rowNumber++;
            return null;
            
        }
        if (kelas::where('nama_kelas', $row['nama_kelas'])->first()->prodi->kode_prodi != $row['kode_prodi']) {
            $this->incompleteRecords[] =
                "Kelas {$row['nama_kelas']} pada baris ke {$this->rowNumber} tidak ditemukan pada prodi {$row['kode_prodi']} <br>";
            $this->rowNumber++;
            return null;
            
        }

        if (krs::where('NIM', $row['nim'])->where('id_mata_kuliah', $idmata_kuliah)->where('id_semester', $idSemester)->where('id_prodi', $idProdi)->where('id_kelas', $idkelas)->exists()) {
            $this->incompleteRecords[] =
            "Baris ke {$this->rowNumber} tidak disimpan karena terdapat data yang sama <br>";
            $this->skippedRecords++;
            $this->rowNumber++;
            return null;
        }


        $krs = KRS::create([
            'NIM' => $row['nim'],
            'id_semester' => $idSemester,
            'id_mata_kuliah' => $idmata_kuliah,
            'id_kelas' => $idkelas,
            'id_prodi' => $idProdi,
            'nilai_huruf' => $row['nilai_huruf'] ?? null,
            'nilai_index' => $row['nilai_indeks'] ?? null,
            'nilai_angka' => $row['nilai_angka'] ?? null,

        ]);

        $this->createdRecords[] = "{$this->rowNumber} Berhasil";
        $this->rowNumber++;

        return $krs;
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
