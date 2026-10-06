<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisPenilaianFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->bothify('JP###'),
            'nama' => fake()->randomElement([
                'Ujian Tengah Semester',
                'Ujian Akhir Semester',
                'Ulangan Harian',
            ]),
            'kategori' => fake()->randomElement([
                'ujian',
                'harian',
            ]),
        ];
    }
}