<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\ToModel;


class MahasiswaImport implements ToModel
{
    public function model(array $row)
    {

        // dd($row);
        return new Mahasiswa([
            'id_mahasiswa' => $row[0],
            'id_orangtua_wali' => $row[1],
            'id' => $row[2],
            'NIM' => $row[3],
            'nama' => $row[4],
            'tempat_lahir' => $row[5],
            'tanggal_lahir' => \Carbon\Carbon::createFromFormat('Y-m-d', $row[6]),
            'jenis_kelamin' => $row[7],
            'NIK' => $row[8],
            'agama' => $row[9],
            'alamat' => $row[10],
            'jalur_pendaftaran' => $row[11],
            'kewarganegaraan' => $row[12],
            'jenis_pendaftaran' => $row[13],
            'tanggal_masuk_kuliah' => \Carbon\Carbon::createFromFormat('Y-m-d', $row[14]),
            'mulai_semester' => $row[15],
            'jenis_tempat_tinggal' => $row[16],
            'telp_rumah' => $row[17],
            'no_hp' => $row[18],
            'email' => $row[19],
            'terima_kps' => $row[20],
            'no_kps' => $row[21],
            'jenis_transportasi' => $row[22],
            'kode_prodi' => $row[23],
            'SKS_diakui' => $row[24],
            'kode_pt_asal' => $row[25],
            'nama_pt_asal' => $row[26],
            'kode_prodi_asal' => $row[27],
            'nama_prodi_asal' => $row[28],
            'jenis_pembiayaan' => $row[29],
            'jumlah_biaya_masuk' => $row[30],
        ]);
    }
}
