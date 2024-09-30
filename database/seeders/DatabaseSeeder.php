<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
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
            'password' => '12345678',
        ]);
        Prodi::factory(10)->create();
        Dosen::factory(10)->create();
        Matakuliah::factory(20)->create();
        Mahasiswa::factory(20)->create();


    }
}
