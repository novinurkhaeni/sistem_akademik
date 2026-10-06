<?php

namespace Database\Seeders;

use App\Models\DataMengajar;
use App\Models\JenisPenilaian;
use App\Models\Penilaian;
use Illuminate\Database\Seeder;

class PenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $dataMengajar = DataMengajar::all();
        $jenisPenilaian = JenisPenilaian::all();

        foreach ($dataMengajar as $mengajar) {
            foreach ($jenisPenilaian as $jenis) {
                Penilaian::updateOrCreate(
                    [
                        'data_mengajar_id' => $mengajar->id,
                        'jenis_penilaian_id' => $jenis->id,
                        'nama_penilaian' => $jenis->nama,
                        'semester' => 'ganjil',
                    ],
                    [
                        'materi' => null,
                        'tanggal' => null,
                        'bobot' => 0,
                        'is_published' => false,
                    ]
                );
            }
        }
    }
}