<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Mengambil ID role secara acak dari tabel roles.
            //
            // Jika tabel roles masih kosong, maka RoleFactory
            // akan membuat satu role baru dan mengambil ID-nya.
            'role_id' => Role::query()
                ->inRandomOrder()
                ->value('id')
                ?? Role::factory()->create()->id,

            // Akun belum dihubungkan dengan data guru.
            // Dapat diisi jika user merupakan akun guru.
            'guru_id' => null,

            // Akun belum dihubungkan dengan data siswa.
            // Dapat diisi jika user merupakan akun siswa.
            'siswa_id' => null,

            // Akun belum dihubungkan dengan data karyawan.
            // Dapat diisi jika user merupakan akun karyawan/TU.
            'karyawan_id' => null,

            // Membuat username secara acak dan unik.
            'username' => fake()->unique()->userName(),

            // Membuat email secara acak dan unik.
            'email' => fake()->unique()->safeEmail(),

            // Menandai email sebagai sudah diverifikasi.
            'email_verified_at' => now(),

            // Membuat password dengan nilai awal "password".
            //
            // Password di-hash menggunakan Hash::make()
            // sebelum disimpan ke database.
            'password' => Hash::make('password'),

            // Akun dibuat dalam kondisi aktif.
            'is_active' => true,

            // Membuat remember token secara acak.
            // Token ini digunakan Laravel untuk fitur
            // "Remember Me" pada proses login.
            'remember_token' => Str::random(10),
        ];
    }
}
