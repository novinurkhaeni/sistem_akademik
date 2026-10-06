<?php

namespace Database\Seeders;

use App\Models\DataMengajar;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class DataMengajarSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();

        foreach ($kelas as $kelasItem) {
            foreach ($mapel->take(3) as $index => $mapelItem) {
                if ($guru->isEmpty()) {
                    continue;
                }

                $guruItem = $guru[($index + $kelasItem->id - 1) % $guru->count()];

                DataMengajar::updateOrCreate(
                    [
                        'guru_id' => $guruItem->id,
                        'mapel_id' => $mapelItem->id,
                        'kelas_id' => $kelasItem->id,
                        'tahun_ajaran_id' => $kelasItem->tahun_ajaran_id,
                    ],
                    [
                        'jumlah_jam' => 4,
                    ]
                );
            }
        }
    }
}