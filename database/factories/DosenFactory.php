<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class DosenFactory extends Factory
{
    protected $model = Dosen::class;
    private static $currentNidn = 1111111111;

    public function definition()
    {
        $faker = FakerFactory::create('id_ID');
        $gender = $faker->randomElement(['laki-laki', 'perempuan']);
        $nama_dosen = $gender === 'laki-laki' ? $faker->firstNameMale . ' ' . $faker->lastName : $faker->firstNameFemale . ' ' . $faker->lastName;
        $nidn = self::$currentNidn++;
        return [
            'nama_dosen' => $nama_dosen,
            'nidn' => $nidn, 
            'jenis_kelamin' => $gender,
            'jabatan_fungsional' => $faker->randomElement(['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar']),
            'kepangkatan' => $faker->randomElement(['Penata Muda', 'Penata', 'Penata Tingkat I', 'Pembina', 'Pembina Utama']),
            'kode_prodi' => Prodi::inRandomOrder()->first()->kode_prodi,
        ];
    }
}
