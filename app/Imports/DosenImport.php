<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Prodi; // Pastikan untuk mengimport model Prodi
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    protected $validKodeProdi;

    public function __construct()
    {
        // Ambil semua kode_prodi dari tabel prodi
        $this->validKodeProdi = Prodi::pluck('kode_prodi')->toArray();
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Validasi kode_prodi
            if (in_array($row['kode_prodi'], $this->validKodeProdi)) {
                Dosen::updateOrCreate(
                    [
                        'id' => $row['id'] ?? null,
                        'nidn' => $row['nidn'],
                        'nama_dosen' => $row['nama_dosen'],
                        'jenis_kelamin' => $row['jenis_kelamin'],
                        'jabatan_fungsional' => $row['jabatan_fungsional'],
                        'kepangkatan' => $row['kepangkatan'],
                        'kode_prodi' => $row['kode_prodi'],
                    ]
                );
            } else {
                // Tangani jika kode_prodi tidak valid (misalnya log atau simpan ke array untuk ditampilkan kemudian)
                \Log::warning("Kode prodi tidak valid: " . $row['kode_prodi']);
            }
        }
    }
}
