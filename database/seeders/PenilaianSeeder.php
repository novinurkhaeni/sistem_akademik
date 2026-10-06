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
        // Mengambil seluruh data mengajar dari tabel data_mengajar.
        //
        // Data mengajar berisi hubungan antara:
        // Guru + Mapel + Kelas + Tahun Ajaran.
        $dataMengajar = DataMengajar::all();

        // Mengambil seluruh jenis penilaian dari tabel jenis_penilaian.
        //
        // Contohnya:
        // - UTS Ganjil
        // - UAS Ganjil
        // - UTS Genap
        // - UAS Genap
        // - Ulangan Harian
        $jenisPenilaian = JenisPenilaian::all();

        // Melakukan perulangan untuk setiap data mengajar.
        foreach ($dataMengajar as $mengajar) {

            // Untuk setiap data mengajar, buat penilaian
            // berdasarkan seluruh jenis penilaian yang tersedia.
            foreach ($jenisPenilaian as $jenis) {

                // Membuat data penilaian jika belum tersedia.
                // Jika kombinasi data yang digunakan untuk pencarian
                // sudah ada, maka data tersebut akan diperbarui.
                Penilaian::updateOrCreate(

                    // Kolom yang digunakan untuk mencari data penilaian.
                    [
                        // ID data mengajar
                        'data_mengajar_id' => $mengajar->id,

                        // ID jenis penilaian
                        'jenis_penilaian_id' => $jenis->id,

                        // Nama penilaian mengikuti nama jenis penilaian
                        'nama_penilaian' => $jenis->nama,

                        // Seeder ini membuat penilaian untuk semester ganjil
                        'semester' => 'ganjil',
                    ],

                    // Nilai yang akan digunakan ketika data dibuat
                    // atau diperbarui.
                    [
                        // Materi belum ditentukan
                        'materi' => null,

                        // Tanggal pelaksanaan belum ditentukan
                        'tanggal' => null,

                        // Bobot awal penilaian adalah 0
                        'bobot' => 0,

                        // Penilaian belum dipublikasikan kepada siswa
                        'is_published' => false,
                    ]
                );
            }
        }
    }
}
