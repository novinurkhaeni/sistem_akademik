<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Data referensi
            RoleSeeder::class,
            PermissionSeeder::class,

            // Data utama
            TahunAjaranSeeder::class,
            MapelSeeder::class,
            GuruSeeder::class,
            KaryawanSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,

            // Akun dan hak akses
            UserSeeder::class,
            RolePermissionSeeder::class,

            // Kegiatan pembelajaran
            DataMengajarSeeder::class,
            JenisPenilaianSeeder::class,
            JadwalSeeder::class,
            PenilaianSeeder::class,
            NilaiSeeder::class,

            // Riwayat aktivitas
            RiwayatUploadSeeder::class,
        ]);
    }
}