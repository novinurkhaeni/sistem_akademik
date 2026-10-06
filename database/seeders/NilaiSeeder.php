<?php

namespace Database\Seeders;

use App\Models\Nilai;
use App\Models\Penilaian;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $penilaian = Penilaian::with('dataMengajar.kelas')->get();

        foreach ($penilaian as $item) {
            $kelasId = $item->dataMengajar->kelas_id;

            $siswa = Siswa::where('kelas_id', $kelasId)->get();

            foreach ($siswa as $siswaItem) {
                Nilai::updateOrCreate(
                    [
                        'penilaian_id' => $item->id,
                        'siswa_id' => $siswaItem->id,
                    ],
                    [
                        'nilai' => fake()->numberBetween(70, 100),
                        'catatan' => null,
                    ]
                );
            }
        }
    }
}