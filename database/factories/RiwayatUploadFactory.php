<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatUploadFactory extends Factory
{
    public function definition(): array
    {
        $jumlahData = fake()->numberBetween(10, 200);
        $jumlahGagal = fake()->numberBetween(0, 5);
        $jumlahBerhasil = max(0, $jumlahData - $jumlahGagal);

        return [
            'user_id' => User::query()
                ->inRandomOrder()
                ->value('id') ?? User::factory()->create()->id,
            'nama_file' => fake()->word() . '.xlsx',
            'jenis_data' => fake()->randomElement([
                'siswa',
                'guru',
                'karyawan',
                'mapel',
                'nilai',
            ]),
            'jumlah_data' => $jumlahData,
            'jumlah_berhasil' => $jumlahBerhasil,
            'jumlah_gagal' => $jumlahGagal,
            'status' => 'selesai',
            'uploaded_at' => fake()->dateTimeBetween(
                '-6 months',
                'now'
            ),
        ];
    }
}
