<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil tahun ajaran yang sedang berstatus aktif.
        // Contoh: 2026/2027.
        $tahunAjaran = TahunAjaran::where('is_active', true)->first();

        // Jika tidak ditemukan tahun ajaran yang aktif,
        // ambil tahun ajaran pertama yang tersedia di database.
        //
        // firstOrFail() akan menghasilkan error jika tabel
        // tahun_ajaran benar-benar masih kosong.
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::firstOrFail();
        }

        // Daftar kelas yang akan dibuat.
        //
        // tingkat:
        // 10 = kelas X
        // 11 = kelas XI
        // 12 = kelas XII
        //
        // jurusan menggunakan kode PPLG
        // (Pengembangan Perangkat Lunak dan Gim).
        $daftarKelas = [
            [
                'nama_kelas' => 'X PPLG 1',
                'tingkat' => 10,
                'jurusan' => 'PPLG',
            ],
            [
                'nama_kelas' => 'X PPLG 2',
                'tingkat' => 10,
                'jurusan' => 'PPLG',
            ],
            [
                'nama_kelas' => 'XI PPLG 1',
                'tingkat' => 11,
                'jurusan' => 'PPLG',
            ],
            [
                'nama_kelas' => 'XI PPLG 2',
                'tingkat' => 11,
                'jurusan' => 'PPLG',
            ],
            [
                'nama_kelas' => 'XII PPLG 1',
                'tingkat' => 12,
                'jurusan' => 'PPLG',
            ],
            [
                'nama_kelas' => 'XII PPLG 2',
                'tingkat' => 12,
                'jurusan' => 'PPLG',
            ],
        ];

        // Melakukan perulangan untuk setiap kelas
        // yang terdapat dalam daftar kelas.
        foreach ($daftarKelas as $kelas) {

            // Membuat data kelas jika belum ada.
            // Jika kombinasi nama kelas dan tahun ajaran
            // sudah ada, maka data tersebut akan diperbarui.
            Kelas::updateOrCreate(

                // Kondisi untuk mencari data yang sudah ada.
                [
                    'nama_kelas' => $kelas['nama_kelas'],
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ],

                // Data yang akan dibuat atau diperbarui.
                //
                // array_merge() menggabungkan data kelas
                // dengan ID tahun ajaran aktif.
                array_merge($kelas, [
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ])
            );
        }
    }
}
