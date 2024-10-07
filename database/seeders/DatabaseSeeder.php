<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Semester;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Semester;
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
        Prodi::factory()->create([
            'kode_prodi' => 'AK-001',
            'nama_prodi' => 'AKuntansi',
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
        ]);

        Semester::factory()->create([
            'nama_semester' => '20202',
        ]);

        Semester::factory()->create([    
            'nama_semester' => '20211',
        ]);

        Semester::factory()->create([
            'nama_semester' => '20212',
        ]);

        Semester::factory()->create([
            'nama_semester' => '20221',
        ]);

        Semester::factory()->create([
            'nama_semester' => '20222',
        ]);


        Dosen::factory(10)->create();
        Matakuliah::factory(20)->create();
        Mahasiswa::factory(20)->create();


    }
}
