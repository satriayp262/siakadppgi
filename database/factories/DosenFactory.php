<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosenFactory extends Factory
{
    protected $model = Dosen::class;

    public function definition()
    {
        return [
            'nama_dosen' => $this->faker->name(),
            'nidn' => $this->faker->numerify('##########'), // NIDN dengan 10 digit angka
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'jabatan_fungsional' => $this->faker->jobTitle(),
            'kepangkatan' => $this->faker->randomElement(['Guru Besar', 'Lektor', 'Asisten Ahli']),
            'kode_prodi' => Prodi::inRandomOrder()->first()->kode_prodi,
        ];
    }
}
