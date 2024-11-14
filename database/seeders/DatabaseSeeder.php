<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Pendidikan_Terakhir;
use App\Models\Ruangan;
use App\Models\User;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Kelas;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => '123@gmail.com',
            'password' => '11111111',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'staff@gmail.com',
            'password' => '11111111',
            'role' => 'staff',
        ]);

        User::factory()->create([
            'name' => 'dosen',
            'email' => 'dosen@gmail.com',
            'password' => '11111111',
            'role' => 'dosen',
        ]);

        Prodi::factory()->create([
            'kode_prodi' => 'AK-001',
            'nama_prodi' => 'Akutansi',
            'jenjang' => 'D3',

        ]);
        Prodi::factory()->create([
            'kode_prodi' => 'MO-002',
            'nama_prodi' => 'Mesin Otomotif',
            'jenjang' => 'D3',

        ]);
        Prodi::factory()->create([
            'kode_prodi' => 'TE-003',
            'nama_prodi' => 'Teknik Elektro',
            'jenjang' => 'S1',

        ]);
        Prodi::factory()->create([
            'kode_prodi' => 'MSDM-004',
            'nama_prodi' => 'Manajemen SDM',
            'jenjang' => 'S1',
        ]);


        Semester::factory()->create([
            'nama_semester' => '20201',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20202',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20211',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20212',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20221',
            'is_active' => 0,
        ]);

        Semester::factory()->create([
            'nama_semester' => '20222',
            'is_active' => 1,
        ]);
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

        Dosen::factory(30)->create();
        
        $matakuliahData = [
            [
                'kode_mata_kuliah' => 'STATIS',
                'nama_mata_kuliah' => 'Statistika',
            ],
            [
                'kode_mata_kuliah' => 'PROWEB',
                'nama_mata_kuliah' => 'Pemrograman Web',
            ],
            [
                'kode_mata_kuliah' => 'BASDAT',
                'nama_mata_kuliah' => 'Basis Data',
            ],
            [
                'kode_mata_kuliah' => 'MOBILE',
                'nama_mata_kuliah' => 'Mobile Programming',
            ],
            [
                'kode_mata_kuliah' => 'SISTOP',
                'nama_mata_kuliah' => 'Sistem Operasi',
            ],
            [
                'kode_mata_kuliah' => 'ERPEEL',
                'nama_mata_kuliah' => 'RPL',
            ],
        ];

        // Create each Matakuliah using the predefined data
        foreach ($matakuliahData as $data) {
            Matakuliah::factory()->create([
                'kode_mata_kuliah' => $data['kode_mata_kuliah'],
                'nama_mata_kuliah' => $data['nama_mata_kuliah'],
            ]);
        }
        Kelas::factory(6)->create();

        Ruangan::factory(20)->create();
        

    }
}
