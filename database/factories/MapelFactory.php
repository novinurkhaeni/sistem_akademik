<?php

namespace Database\Factories;

use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mapel>
 */
class MapelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_mapel' => strtoupper(fake()->unique()->bothify('MP###')),
            'nama_mapel' => fake()->unique()->words(2, true),
            'kelompok' => fake()->randomElement([
                'Umum',
                'Kejuruan',
                'Muatan Lokal',
            ]),
            'deskripsi' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
