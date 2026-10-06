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
            // NIS siswa dibuat berupa 8 digit angka dan harus unik.
            // Contoh: 24001234
            'nis' => fake()->unique()->numerify('########'),

            // NISN siswa dibuat berupa 12 digit angka dan harus unik.
            // Contoh: 001234567890
            'nisn' => fake()->unique()->numerify('############'),

            // Nama siswa dibuat secara acak menggunakan Faker.
            'nama' => fake()->name(),

            // Jenis kelamin dipilih secara acak:
            // L = Laki-laki
            // P = Perempuan
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),

            // Membuat tanggal lahir siswa secara acak
            // antara usia 15 sampai 18 tahun.
            //
            // Hasil akhirnya diubah ke format YYYY-MM-DD
            // agar sesuai dengan tipe kolom date pada database.
            'tanggal_lahir' => fake()->dateTimeBetween(
                '-18 years',
                '-15 years'
            )->format('Y-m-d'),

            // Alamat siswa dibuat secara acak.
            'alamat' => fake()->address(),

            // Mengambil ID kelas secara acak dari tabel kelas.
            //
            // Jika tabel kelas sudah memiliki data,
            // maka salah satu ID kelas akan digunakan.
            //
            // Jika tabel kelas masih kosong,
            // maka KelasFactory akan membuat satu kelas baru.
            'kelas_id' => Kelas::query()
                ->inRandomOrder()
                ->value('id')
                ?? Kelas::factory()->create()->id,

            // Foto dikosongkan karena factory tidak melakukan
            // proses upload file gambar.
            'photo' => null,

            // Status awal siswa dibuat aktif.
            'status' => 'aktif',
        ];
    }
}
