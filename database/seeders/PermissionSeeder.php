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
        // Daftar permission/hak akses yang tersedia
        // di dalam sistem akademik.
        //
        // Format:
        // 'nama_permission' => 'deskripsi permission'
        $permissions = [

            // Hak untuk mengelola akun pengguna
            'kelola_user' => 'Mengelola pengguna',

            // Hak untuk mengelola role dan hak akses
            'kelola_role' => 'Mengelola role dan hak akses',

            // Hak untuk mengelola data siswa
            'kelola_siswa' => 'Mengelola data siswa',

            // Hak untuk mengelola data guru
            'kelola_guru' => 'Mengelola data guru',

            // Hak untuk mengelola data karyawan
            'kelola_karyawan' => 'Mengelola data karyawan',

            // Hak untuk mengelola data mata pelajaran
            'kelola_mapel' => 'Mengelola mata pelajaran',

            // Hak untuk mengelola data kelas
            'kelola_kelas' => 'Mengelola kelas',

            // Hak untuk mengelola data mengajar
            'kelola_mengajar' => 'Mengelola data mengajar',

            // Hak untuk mengelola jadwal
            'kelola_jadwal' => 'Mengelola jadwal',

            // Hak untuk mengelola data penilaian
            'kelola_penilaian' => 'Mengelola penilaian',

            // Hak untuk melihat nilai siswa
            'lihat_nilai' => 'Melihat nilai',

            // Hak untuk memasukkan atau mengubah nilai
            'input_nilai' => 'Menginput nilai',

            // Hak untuk mengunggah data melalui file
            'upload_data' => 'Mengunggah data',

            // Hak untuk melihat riwayat proses upload
            'lihat_riwayat_upload' => 'Melihat riwayat upload',
        ];

        // Melakukan perulangan terhadap seluruh permission
        foreach ($permissions as $nama => $deskripsi) {

            // Membuat permission jika belum tersedia.
            //
            // Jika permission dengan nama yang sama sudah ada,
            // maka deskripsinya akan diperbarui.
            Permission::updateOrCreate(

                // Kondisi untuk mencari permission yang sudah ada
                [
                    'nama_permission' => $nama,
                ],

                // Data yang dibuat atau diperbarui
                [
                    'deskripsi' => $deskripsi,
                ]
            );
        }
    }
}
