<?php

namespace Database\Factories;

use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ruangan>
 */
class RuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        static $prefix = 1;
        static $suffix = 1;

        $kodeRuangan = sprintf('R.%d.%d', $prefix, $suffix);

        if ($suffix < 9) {
            $suffix++;
        } else {
            $suffix = 1;
            $prefix++;
        }

        return [
            'kode_ruangan' => $kodeRuangan,
            'nama_ruangan' => fake()->words(3, true),
            'kapasitas' => fake()->numerify('##'),
        ];
    }

}
