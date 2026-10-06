<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        // Menentukan daftar tahun ajaran yang akan dimasukkan
        // ke dalam tabel tahun_ajaran.
        $tahunAjaran = [

            // Tahun ajaran 2024/2025.
            // Tidak menjadi tahun ajaran aktif.
            [
                'nama' => '2024/2025',
                'tanggal_mulai' => '2024-07-01',
                'tanggal_selesai' => '2025-06-30',
                'is_active' => false,
            ],

            // Tahun ajaran 2025/2026.
            // Tidak menjadi tahun ajaran aktif.
            [
                'nama' => '2025/2026',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2026-06-30',
                'is_active' => false,
            ],

            // Tahun ajaran 2026/2027.
            // Ditandai sebagai tahun ajaran yang sedang aktif.
            [
                'nama' => '2026/2027',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2027-06-30',
                'is_active' => true,
            ],
        ];

        // Melakukan perulangan untuk setiap data tahun ajaran.
        foreach ($tahunAjaran as $data) {

            // Mencari tahun ajaran berdasarkan nama.
            // Jika belum ada, Laravel akan membuat data baru.
            // Jika sudah ada, Laravel akan memperbarui datanya.
            TahunAjaran::updateOrCreate(

                // Kondisi untuk mencari data tahun ajaran.
                ['nama' => $data['nama']],

                // Data yang akan dibuat atau diperbarui.
                $data
            );
        }
    }
}
