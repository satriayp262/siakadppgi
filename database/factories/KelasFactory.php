<?php

namespace Database\Factories;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Matakuliah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    protected static int $courseCounter = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mataKuliahMapping = [
            'STATIS' => 'Stati',
            'PROWEB' => 'Pemro',
            'BASDAT' => 'Basis',
            'MOBILE' => 'Mobil',
            'SISTOP' => 'Siste',
            'ERPEEL' => 'RPL'
        ];

        // Array of keys for easy indexing
        $kodeMataKuliahKeys = array_keys($mataKuliahMapping);

        if (self::$courseCounter < count($kodeMataKuliahKeys)) {
            // Use the predefined kode_mata_kuliah and nama_kelas
            $kodeMataKuliah = $kodeMataKuliahKeys[self::$courseCounter];
            $namaKelas = $mataKuliahMapping[$kodeMataKuliah];

            // Retrieve id_mata_kuliah from MataKuliah model
            $idMataKuliah = MataKuliah::where('kode_mata_kuliah', $kodeMataKuliah)->value('id_mata_kuliah');

            // Increment counter
            self::$courseCounter++;
        } else {
            // Generate random kode_mata_kuliah and nama_kelas after predefined ones are used
            $kodeMataKuliah = strtoupper($this->faker->lexify('??????')); // random 6 letters
            $namaKelas = $this->faker->words(2, true); // generate a random name
            $idMataKuliah = MataKuliah::create([
                'kode_mata_kuliah' => $kodeMataKuliah,
                'nama' => $namaKelas
            ])->id_mata_kuliah;
        }
        $idSemester = Semester::where('nama_semester', '20222')->first()->id_semester;

        return [
            'semester' => $idSemester,
            'nama_kelas' => $namaKelas,
            'kode_prodi' => 'AK-001',
            'lingkup_kelas' => $this->faker->randomElement([1, 2, 3]),
            'id_mata_kuliah' => $idMataKuliah,
            'bahasan' => $this->faker->sentence(),
            'mode_kuliah' => $this->faker->randomElement(['O', 'F', 'M']),
        ];
    }
}
