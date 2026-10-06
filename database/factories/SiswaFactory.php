<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake()->unique()->numerify('########'),
            'nisn' => fake()->unique()->numerify('############'),
            'nama' => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tanggal_lahir' => fake()->dateTimeBetween(
                '-18 years',
                '-15 years'
            )->format('Y-m-d'),
            'alamat' => fake()->address(),
            'kelas_id' => Kelas::query()
                ->inRandomOrder()
                ->value('id') ?? Kelas::factory()->create()->id,
            'photo' => null,
            'status' => 'aktif',
        ];
    }
}
