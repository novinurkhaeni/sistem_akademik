<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = [
            [
                'nama' => '2024/2025',
                'tanggal_mulai' => '2024-07-01',
                'tanggal_selesai' => '2025-06-30',
                'is_active' => false,
            ],
            [
                'nama' => '2025/2026',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2026-06-30',
                'is_active' => false,
            ],
            [
                'nama' => '2026/2027',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2027-06-30',
                'is_active' => true,
            ],
        ];

        foreach ($tahunAjaran as $data) {
            TahunAjaran::updateOrCreate(
                ['nama' => $data['nama']],
                $data
            );
        }
    }
}
