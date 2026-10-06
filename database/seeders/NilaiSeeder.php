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
    // Mengambil seluruh data penilaian sekaligus memuat
    // relasi dataMengajar dan kelas.
    //
    // Eager loading digunakan agar Laravel tidak perlu
    // melakukan query berulang kali ketika mengakses
    // $item->dataMengajar.
    $penilaian = Penilaian::with('dataMengajar.kelas')->get();

    // Melakukan perulangan untuk setiap data penilaian
    foreach ($penilaian as $item) {

        // Mengambil ID kelas dari data mengajar
        // yang terkait dengan penilaian tersebut.
        $kelasId = $item->dataMengajar->kelas_id;

        // Mengambil seluruh siswa yang berada
        // di kelas tersebut.
        $siswa = Siswa::where('kelas_id', $kelasId)->get();

        // Membuat nilai untuk setiap siswa di kelas
        foreach ($siswa as $siswaItem) {

            // Membuat data nilai jika belum ada.
            // Jika kombinasi penilaian + siswa sudah ada,
            // maka data nilai akan diperbarui.
            Nilai::updateOrCreate(

                // Kondisi untuk mencari data nilai yang sudah ada.
                [
                    'penilaian_id' => $item->id,
                    'siswa_id' => $siswaItem->id,
                ],

                // Data yang akan dibuat atau diperbarui.
                [
                    // Nilai siswa dibuat secara acak antara 70-100.
                    'nilai' => fake()->numberBetween(70, 100),

                    // Catatan dikosongkan.
                    'catatan' => null,
                ]
            );
        }
    }
}
}