<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guru>
 */
class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // NIP guru berupa 10 digit angka yang dibuat secara unik
            'nip' => fake()->unique()->numerify('##########'),

            // Nama guru dibuat secara acak menggunakan Faker
            'nama' => fake()->name(),

            // Jenis kelamin: L = Laki-laki, P = Perempuan
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),

            // Email dibuat secara acak dan dijamin unik
            'email' => fake()->unique()->safeEmail(),

            // Nomor HP diawali 08 dan dilanjutkan 10 digit angka acak
            'no_hp' => fake()->numerify('08##########'),

            // Alamat guru dibuat secara acak
            'alamat' => fake()->address(),

            // Foto dikosongkan karena factory tidak mengunggah file foto
            'photo' => null,

            // Status awal guru dibuat aktif
            'status' => 'aktif',
        ];
    }
}
