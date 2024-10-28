<?php

namespace Database\Factories;

use App\Models\Dosen;
use App\Models\Matakuliah;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Prodi; // Pastikan model Prodi diimport

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matakuliah>
 */
class MatakuliahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil semua kode prodi dari tabel Prodi
        $kodeProdiList = Prodi::pluck('kode_prodi')->toArray();
        $nidnlist = Dosen::pluck('nidn')->toArray();

        // Tentukan jenis mata kuliah secara acak
        $jenisMataKuliah = $this->faker->randomElement(['A', 'W', 'B', 'C', 'S']);

        return [
            'kode_mata_kuliah' => strtoupper(Str::random(6)),  // Kode unik untuk mata kuliah
            'nama_mata_kuliah' => $this->faker->word(),        // Nama mata kuliah acak
            'jenis_mata_kuliah' => $jenisMataKuliah,  // Jenis acak
            // Jika jenis mata kuliah adalah 'Umum', kode_prodi akan null, jika tidak ambil dari $kodeProdiList
            'kode_prodi' => $this->faker->randomElement($kodeProdiList),
            'nidn' => $this->faker->randomElement($nidnlist), // NIDN dengan 10 digit angka
            'sks_tatap_muka' => $this->faker->numberBetween(1, 4),  // SKS tatap muka
            'sks_praktek' => $this->faker->numberBetween(0, 2),     // SKS praktek
            'sks_praktek_lapangan' => $this->faker->numberBetween(0, 2),  // SKS praktek lapangan
            'sks_simulasi' => $this->faker->numberBetween(0, 2),  // SKS simulasi
            'metode_pembelajaran' => $this->faker->randomElement(['Luring', 'Daring']), // Metode pembelajaran acak
            'tgl_mulai_efektif' => $this->faker->date(),   // Tanggal mulai efektif acak
            'tgl_akhir_efektif' => $this->faker->date(),   // Tanggal akhir efektif acak
        ];
    }
}
