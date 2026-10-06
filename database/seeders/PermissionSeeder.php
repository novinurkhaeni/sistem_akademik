<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'kelola_user' => 'Mengelola pengguna',
            'kelola_role' => 'Mengelola role dan hak akses',
            'kelola_siswa' => 'Mengelola data siswa',
            'kelola_guru' => 'Mengelola data guru',
            'kelola_karyawan' => 'Mengelola data karyawan',
            'kelola_mapel' => 'Mengelola mata pelajaran',
            'kelola_kelas' => 'Mengelola kelas',
            'kelola_mengajar' => 'Mengelola data mengajar',
            'kelola_jadwal' => 'Mengelola jadwal',
            'kelola_penilaian' => 'Mengelola penilaian',
            'lihat_nilai' => 'Melihat nilai',
            'input_nilai' => 'Menginput nilai',
            'upload_data' => 'Mengunggah data',
            'lihat_riwayat_upload' => 'Melihat riwayat upload',
        ];

        foreach ($permissions as $nama => $deskripsi) {
            Permission::updateOrCreate(
                ['nama_permission' => $nama],
                ['deskripsi' => $deskripsi]
            );
        }
    }
}
