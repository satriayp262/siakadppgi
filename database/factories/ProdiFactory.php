<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prodi>
 */
class ProdiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_prodi' => $this->faker->unique()->numerify('PROD#'), 
            'nama_prodi' => $this->faker->words(3, true), // Generate nama prodi acak
            'jenjang' => $this->faker->randomElement(['D3', 'S1']), // Pilihan jenjang acak
        ];
    }
}
