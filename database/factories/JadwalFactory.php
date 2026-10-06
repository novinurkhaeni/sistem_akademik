<?php

namespace Database\Factories;

use App\Models\DataMengajar;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    public function definition(): array
    {
        $jamMulai = fake()->randomElement([
            '07:00:00',
            '08:30:00',
            '10:00:00',
            '13:00:00',
            '14:30:00',
        ]);

        $durasi = 90;

        return [
            'data_mengajar_id' => DataMengajar::query()
                ->inRandomOrder()
                ->value('id') ?? DataMengajar::factory()->create()->id,
            'hari' => fake()->randomElement([
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu',
            ]),
            'jam_mulai' => $jamMulai,
            'jam_selesai' => date(
                'H:i:s',
                strtotime($jamMulai) + ($durasi * 60)
            ),
            'ruang' => fake()->randomElement([
                'RPL 1',
                'RPL 2',
                'Lab Komputer 1',
                'Lab Komputer 2',
            ]),
        ];
    }
}
