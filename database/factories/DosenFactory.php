<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

class DosenFactory extends Factory
{
    protected $model = Dosen::class;

    public function definition()
    {
        // Menggunakan Faker dengan locale bahasa Indonesia
        $faker = FakerFactory::create('id_ID');

        // Menentukan jenis kelamin terlebih dahulu
        $gender = $faker->randomElement(['laki-laki', 'perempuan']);

        // Menghasilkan nama berdasarkan jenis kelamin
        $nama_dosen = $gender === 'laki-laki' ? $faker->firstNameMale . ' ' . $faker->lastName : $faker->firstNameFemale . ' ' . $faker->lastName;

        return [
            'nama_dosen' => $nama_dosen,
            'nidn' => $faker->numerify('##########'), // NIDN dengan 10 digit angka
            'jenis_kelamin' => $gender,
            'jabatan_fungsional' => $faker->randomElement(['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar']),
            'kepangkatan' => $faker->randomElement(['Penata Muda', 'Penata', 'Penata Tingkat I', 'Pembina', 'Pembina Utama']),
            'kode_prodi' => Prodi::inRandomOrder()->first()->kode_prodi,
            'id' => '1',
        ];
    }
}
