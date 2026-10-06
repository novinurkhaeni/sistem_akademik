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
        // Mengambil seluruh data guru dari tabel guru
        $guru = Guru::all();

        // Mengambil seluruh data mata pelajaran dari tabel mapel
        $mapel = Mapel::all();

        // Mengambil seluruh data kelas dari tabel kelas
        $kelas = Kelas::all();

        // Melakukan perulangan untuk setiap kelas
        foreach ($kelas as $kelasItem) {

            // Mengambil maksimal 3 mata pelajaran pertama
            // dari data mata pelajaran yang tersedia.
            //
            // Artinya, setiap kelas akan mendapatkan
            // maksimal 3 data mengajar.
            foreach ($mapel->take(3) as $index => $mapelItem) {

                // Jika belum ada data guru,
                // proses untuk kombinasi ini dilewati.
                if ($guru->isEmpty()) {
                    continue;
                }

                // Menentukan guru secara bergantian berdasarkan:
                // - index mata pelajaran
                // - ID kelas
                //
                // Operator % digunakan agar index tidak melebihi
                // jumlah guru yang tersedia.
                $guruItem = $guru[($index + $kelasItem->id - 1) % $guru->count()];

                // Membuat atau memperbarui data mengajar.
                //
                // Jika kombinasi guru + mapel + kelas + tahun ajaran
                // sudah ada, maka data tidak dibuat ulang.
                //
                // Jika belum ada, maka data baru akan dibuat.
                DataMengajar::updateOrCreate(

                    // Kolom yang digunakan untuk mencari data yang sudah ada
                    [
                        'guru_id' => $guruItem->id,
                        'mapel_id' => $mapelItem->id,
                        'kelas_id' => $kelasItem->id,
                        'tahun_ajaran_id' => $kelasItem->tahun_ajaran_id,
                    ],

                    // Data yang akan disimpan jika record baru dibuat
                    // atau diperbarui.
                    [
                        'jumlah_jam' => 4,
                    ]
                );
            }
        }
    }
}
