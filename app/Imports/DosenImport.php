<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class DosenImport implements ToModel, WithHeadingRow
{
    protected $validKodeProdi;
    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = ['nidn', 'nama_dosen', 'jenis_kelamin', 'jabatan_fungsional', 'kepangkatan', 'kode_prodi'];

    public function __construct()
    {
        // Ambil semua kode_prodi dari tabel prodi
        $this->validKodeProdi = Prodi::pluck('kode_prodi')->toArray();
    }

    public function model(array $row)
    {
        foreach ($this->requiredFields as $field) {
            if (empty($row[$field])) {
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
        if ($this->isDuplicate($row['nidn'], $row['nama_dosen'])) {
            $this->skippedRecords++;
            $this->rowNumber++;
            return null;
        } else {
            $this->createdRecords[] = "nidn = {$row['nidn']} ,";
            $this->rowNumber++;
        }
        return new Dosen([
            'id' => $row['id'] ?? null,
            'nidn' => $row['nidn'],
            'nama_dosen' => $row['nama_dosen'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'jabatan_fungsional' => $row['jabatan_fungsional'],
            'kepangkatan' => $row['kepangkatan'],
            'kode_prodi' => $row['kode_prodi'],
        ]);
    }

    protected function isDuplicate($nidn, $nama_dosen)
    {
        return Dosen::where('nidn', $nidn)->exists() || Dosen::where('nama_dosen', $nama_dosen)->exists();
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
