<?php

namespace Database\Factories;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Karyawan>
 */
class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('##########'),
            'nama' => fake()->name(),
            'jabatan' => fake()->randomElement([
                'Kepala Tata Usaha',
                'Staf Tata Usaha',
                'Operator Sekolah',
                'Petugas Administrasi',
            ]),
            'email' => fake()->unique()->safeEmail(),
            'no_hp' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'photo' => null,
            'status' => 'aktif',
        ];
    }
}
