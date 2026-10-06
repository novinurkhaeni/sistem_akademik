<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisPenilaianFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Kode jenis penilaian dibuat secara unik.
            // Contoh: JP001, JP002, JP003
            'kode' => fake()->unique()->bothify('JP###'),

            // Nama jenis penilaian dipilih secara acak
            'nama' => fake()->randomElement([
                'Ujian Tengah Semester',
                'Ujian Akhir Semester',
                'Ulangan Harian',
            ]),

            // Kategori penilaian dipilih secara acak.
            // 'ujian' digunakan untuk UTS/UAS,
            // sedangkan 'harian' digunakan untuk Ulangan Harian.
            'kategori' => fake()->randomElement([
                'ujian',
                'harian',
            ]),
        ];
    }
}
