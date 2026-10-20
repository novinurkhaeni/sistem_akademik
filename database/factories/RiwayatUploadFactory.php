<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatUploadFactory extends Factory
{
    public function definition(): array
    {
        // Menentukan jumlah seluruh data yang diproses
        // dalam satu proses upload secara acak antara 10-200 data.
        $jumlahData = fake()->numberBetween(10, 200);

        // Menentukan jumlah data yang gagal diproses.
        // Maksimal 5 data gagal.
        $jumlahGagal = fake()->numberBetween(0, 5);

        // Menghitung jumlah data yang berhasil.
        // Menggunakan max(0, ...) agar hasil tidak pernah negatif.
        $jumlahBerhasil = max(0, $jumlahData - $jumlahGagal);

        return [
            // Mengambil ID user secara acak dari tabel users.
            // Jika belum ada user, maka UserFactory akan membuat
            // satu user baru dan mengambil ID-nya.
            'user_id' => User::query()
                ->inRandomOrder()
                ->value('id')
                ?? User::factory()->create()->id,

            // Membuat nama file Excel secara acak.
            // Contoh: data-siswa.xlsx
            'nama_file' => fake()->word() . '.xlsx',

            // Menentukan jenis data yang di-upload secara acak
            'jenis_data' => fake()->randomElement([
                'siswa',
                'guru',
                'karyawan',
                'mapel',
                'nilai',
            ]),

            // Menyimpan jumlah seluruh data yang diproses
            'jumlah_data' => $jumlahData,

            // Menyimpan jumlah data yang berhasil diproses
            'jumlah_berhasil' => $jumlahBerhasil,

            // Menyimpan jumlah data yang gagal diproses
            'jumlah_gagal' => $jumlahGagal,

            // Status proses upload.
            // Karena ini data riwayat yang sudah selesai,
            // status dibuat "selesai".
            'status' => 'selesai',

            // Menentukan waktu upload secara acak
            // dalam rentang 6 bulan terakhir sampai sekarang.
            'uploaded_at' => fake()->dateTimeBetween(
                '-6 months',
                'now'
            ),
        ];
    }
}
