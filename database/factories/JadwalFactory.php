<?php

namespace Database\Factories;

use App\Models\DataMengajar;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    public function definition(): array
    {
        // Menentukan jam mulai secara acak
        $jamMulai = fake()->randomElement([
            '07:00:00',
            '08:30:00',
            '10:00:00',
            '13:00:00',
            '14:30:00',
        ]);

        // Durasi setiap jadwal adalah 90 menit
        $durasi = 90;

        return [
            // Mengambil ID data mengajar secara acak dari database.
            // Jika belum ada data mengajar, maka dibuat 1 data baru
            // menggunakan DataMengajarFactory.
            'data_mengajar_id' => DataMengajar::query()
                ->inRandomOrder()
                ->value('id')
                ?? DataMengajar::factory()->create()->id,

            // Menentukan hari secara acak
            'hari' => fake()->randomElement([
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ]),

            // Menyimpan jam mulai yang telah ditentukan sebelumnya
            'jam_mulai' => $jamMulai,

            // Menghitung jam selesai berdasarkan jam mulai + durasi.
            // Contoh: 07:00 + 90 menit = 08:30
            'jam_selesai' => date(
                'H:i:s',
                strtotime($jamMulai) + ($durasi * 60)
            ),

            // Menentukan ruang kelas/laboratorium secara acak
            'ruang' => fake()->randomElement([
                'RPL 1',
                'RPL 2',
                'Lab Komputer 1',
                'Lab Komputer 2',
            ]),
        ];
    }
}
