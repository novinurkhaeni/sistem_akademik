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
            // NIP karyawan dibuat berupa 10 digit angka dan harus unik
            'nip' => fake()->unique()->numerify('##########'),

            // Nama karyawan dibuat secara acak menggunakan Faker
            'nama' => fake()->name(),

            // Jabatan karyawan dipilih secara acak dari daftar yang tersedia
            'jabatan' => fake()->randomElement([
                'Kepala Tata Usaha',
                'Staf Tata Usaha',
                'Operator Sekolah',
                'Petugas Administrasi',
            ]),

            // Email dibuat secara acak dan dijamin unik
            'email' => fake()->unique()->safeEmail(),

            // Nomor HP diawali dengan 08 dan dilanjutkan angka acak
            'no_hp' => fake()->numerify('08##########'),

            // Alamat karyawan dibuat secara acak
            'alamat' => fake()->address(),

            // Foto dikosongkan karena factory tidak membuat file foto
            'photo' => null,

            // Status awal karyawan dibuat aktif
            'status' => 'aktif',
        ];
    }
}
