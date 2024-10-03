<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_mahasiswa' => $this->faker->uuid,
            'id_orangtua_wali' => $this->faker->uuid,
            'NIM' => strtoupper($this->faker->bothify('??########')),
            'nama' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'NIK' => $this->faker->numerify('#################'),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'alamat' => $this->faker->address,
            'jalur_pendaftaran' => $this->faker->randomElement(['Reguler', 'Undangan', 'Prestasi']),
            'kewarganegaraan' => 'Indonesia',
            'jenis_pendaftaran' => $this->faker->randomElement(['Mandiri', 'Beasiswa']),
            'tanggal_masuk_kuliah' => $this->faker->date,
            'mulai_semester' => '1',
            'jenis_tempat_tinggal' => $this->faker->randomElement(['Kost', 'Asrama', 'Rumah']),
            'telp_rumah' => $this->faker->phoneNumber,
            'no_hp' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'terima_kps' => $this->faker->randomElement(['Ya', 'Tidak']),
            'no_kps' => $this->faker->optional()->numerify('############'),
            'jenis_transportasi' => $this->faker->randomElement(['Sepeda Motor', 'Mobil', 'Jalan Kaki']),
            'kode_prodi' => \App\Models\Prodi::inRandomOrder()->first()->kode_prodi,
            'SKS_diakui' => $this->faker->numberBetween(0, 144),
            'kode_pt_asal' => $this->faker->optional()->bothify('PT####'),
            'nama_pt_asal' => $this->faker->optional()->company,
            'kode_prodi_asal' => $this->faker->optional()->bothify('??###'),
            'nama_prodi_asal' => $this->faker->optional()->word,
            'jenis_pembiayaan' => $this->faker->randomElement(['Mandiri', 'Beasiswa']),
            'jumlah_biaya_masuk' => $this->faker->numberBetween(1000000, 50000000),
            'id_user' => '1',
        ];
    }
}
