<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pendidikan_Terakhir;

class PendidikanTerakhirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikanList = [
            ['kode_pendidikan_terakhir' => 0, 'nama_pendidikan_terakhir' => 'Tidak sekolah'],
            ['kode_pendidikan_terakhir' => 1, 'nama_pendidikan_terakhir' => 'PAUD'],
            ['kode_pendidikan_terakhir' => 2, 'nama_pendidikan_terakhir' => 'TK / sederajat'],
            ['kode_pendidikan_terakhir' => 3, 'nama_pendidikan_terakhir' => 'Putus SD'],
            ['kode_pendidikan_terakhir' => 4, 'nama_pendidikan_terakhir' => 'SD / sederajat'],
            ['kode_pendidikan_terakhir' => 5, 'nama_pendidikan_terakhir' => 'SMP / sederajat'],
            ['kode_pendidikan_terakhir' => 6, 'nama_pendidikan_terakhir' => 'SMA / sederajat'],
            ['kode_pendidikan_terakhir' => 7, 'nama_pendidikan_terakhir' => 'Paket A'],
            ['kode_pendidikan_terakhir' => 8, 'nama_pendidikan_terakhir' => 'Paket B'],
            ['kode_pendidikan_terakhir' => 9, 'nama_pendidikan_terakhir' => 'Paket C'],
            ['kode_pendidikan_terakhir' => 20, 'nama_pendidikan_terakhir' => 'D1'],
            ['kode_pendidikan_terakhir' => 21, 'nama_pendidikan_terakhir' => 'D2'],
            ['kode_pendidikan_terakhir' => 22, 'nama_pendidikan_terakhir' => 'D3'],
            ['kode_pendidikan_terakhir' => 23, 'nama_pendidikan_terakhir' => 'D4'],
            ['kode_pendidikan_terakhir' => 30, 'nama_pendidikan_terakhir' => 'S1'],
            ['kode_pendidikan_terakhir' => 31, 'nama_pendidikan_terakhir' => 'Profesi'],
            ['kode_pendidikan_terakhir' => 32, 'nama_pendidikan_terakhir' => 'Sp-1'],
            ['kode_pendidikan_terakhir' => 35, 'nama_pendidikan_terakhir' => 'S2'],
            ['kode_pendidikan_terakhir' => 36, 'nama_pendidikan_terakhir' => 'S2 Terapan'],
            ['kode_pendidikan_terakhir' => 37, 'nama_pendidikan_terakhir' => 'Sp-2'],
            ['kode_pendidikan_terakhir' => 40, 'nama_pendidikan_terakhir' => 'S3'],
            ['kode_pendidikan_terakhir' => 41, 'nama_pendidikan_terakhir' => 'S3 Terapan'],
            ['kode_pendidikan_terakhir' => 90, 'nama_pendidikan_terakhir' => 'Non formal'],
            ['kode_pendidikan_terakhir' => 91, 'nama_pendidikan_terakhir' => 'Informal'],
            ['kode_pendidikan_terakhir' => 99, 'nama_pendidikan_terakhir' => 'Lainnya'],
        ];

        foreach ($pendidikanList as $pendidikan) {
            Pendidikan_Terakhir::create($pendidikan);
        }
    }
}
