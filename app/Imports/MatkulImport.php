<?php

namespace App\Imports;

use App\Models\Matakuliah;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\ToModel;

class MatkulImport implements ToModel
{
    public function model(array $row)
    {

        // dd($row);
        return new Matakuliah([
            'kode_mata_kuliah' => $row[0],
            'nama_mata_kuliah' => $row[1],
            'jenis_mata_kuliah' => $row[2],
            'kode_prodi' => $row[10],
            'sks_tatap_muka' => $row[3],
            'sks_praktek' => $row[4],
            'sks_praktek_lapangan' => $row[5],
            'sks_simulasi' => $row[6],
            'metode_pembelajaran' => $row[7],
            'tgl_mulai_efektif' => \Carbon\Carbon::createFromFormat('Y-m-d', $row[8]),
            'tgl_akhir_efektif' => \Carbon\Carbon::createFromFormat('Y-m-d', $row[9]),
        ]);
    }
}
