<?php

namespace App\Imports;

use App\Models\KRS;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;

class KRSImport implements ToModel, WithHeadingRow, WithEvents
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
        'nidn',
        'kode_prodi',
    ];

    protected static $krsGroupedByClass = [];
    // [id_kelas => [id_krs, id_krs, ...]]

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
                $this->incompleteRecords[] = "Baris ke {$this->rowNumber} tidak lengkap, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }
        }

        if (!Prodi::where('kode_prodi', $row['kode_prodi'])->exists()) {
            $this->incompleteRecords[] = "kode_prodi {$row['kode_prodi']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }
        $idProdi = Prodi::where('kode_prodi', $row['kode_prodi'])->first()->id_prodi;

        if (!Semester::where('nama_semester', $row['semester'])->exists()) {
            $this->incompleteRecords[] = "semester {$row['semester']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }
        $idSemester = Semester::where('nama_semester', $row['semester'])->first()->id_semester;

        if (!Mahasiswa::where('NIM', $row['nim'])->exists()) {
            $this->incompleteRecords[] = "NIM {$row['nim']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }

        if ($row['nidn']) {
            if (!Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->where('nidn', $row['nidn'])->exists()) {
                $this->incompleteRecords[] = "Kode matakuliah {$row['kode_mata_kuliah']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
                $this->rowNumber++;
                return null;
            }
            $idmata_kuliah = Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->where('nidn', $row['nidn'])->first()->id_mata_kuliah;
        } else {
            if (!Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->exists()) {
                $this->incompleteRecords[] = "Kode matakuliah {$row['kode_mata_kuliah']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
                $this->rowNumber++;
                return null;
            }
            $idmata_kuliah = Matakuliah::where('kode_mata_kuliah', $row['kode_mata_kuliah'])->first()->id_mata_kuliah;
        }

        if (!Kelas::where('nama_kelas', $row['nama_kelas'])->exists()) {
            $this->incompleteRecords[] = "Kelas {$row['nama_kelas']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }
        $id_kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first()->id_kelas;

        if (KRS::where('NIM', $row['nim'])->where('id_mata_kuliah', $idmata_kuliah)->where('id_semester', $idSemester)->where('id_prodi', $idProdi)->exists()) {
            $this->incompleteRecords[] = "Baris ke {$this->rowNumber} tidak disimpan karena terdapat data yang sama <br>";
            $this->skippedRecords++;
            $this->rowNumber++;
            return null;
        }

        $krs = KRS::create([
            'NIM' => $row['nim'],
            'id_semester' => $idSemester,
            'id_mata_kuliah' => $idmata_kuliah,
            'id_kelas' => $id_kelas,
            'nidn' => $row['nidn'],
            'id_prodi' => $idProdi,
            'grup_praktikum' => null, // Di-set nanti setelah import selesai
        ]);

        self::$krsGroupedByClass[$id_kelas][] = $krs->id_krs;
        $this->createdRecords[] = "{$this->rowNumber} Berhasil";
        $this->rowNumber++;

        return $krs;
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function (AfterImport $event) {
                foreach (self::$krsGroupedByClass as $idKelas => $krsIds) {
                    $total = count($krsIds);
                    $half = ceil($total / 2);

                    foreach ($krsIds as $index => $idKrs) {
                        $grup = ($index < $half) ? 'A' : 'B';
                        KRS::where('id_krs', $idKrs)->update(['grup_praktikum' => $grup]);
                    }
                }
            },
        ];
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
