<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil seluruh data permission yang sudah dibuat oleh PermissionSeeder.
        // Digunakan khusus untuk memberikan semua permission kepada Superadmin.
        $semuaPermission = Permission::all();

        // Menentukan daftar hak akses untuk masing-masing role.
        $akses = [

            // Superadmin mendapatkan seluruh permission yang tersedia.
            'superadmin' => $semuaPermission->pluck('id')->all(),

            // Admin TU mendapatkan permission yang berkaitan dengan
            // pengelolaan data administrasi sekolah.
            'admin_tu' => Permission::whereIn('nama_permission', [
                'kelola_siswa',             // Mengelola data siswa.
                'kelola_guru',              // Mengelola data guru.
                'kelola_karyawan',          // Mengelola data karyawan.
                'kelola_mapel',              // Mengelola data mata pelajaran.
                'kelola_kelas',              // Mengelola data kelas.
                'kelola_user',               // Mengelola akun pengguna.
                'upload_data',               // Mengunggah data.
                'lihat_riwayat_upload',     // Melihat riwayat proses upload.
            ])->pluck('id')->all(),

            // Guru mendapatkan permission yang berkaitan dengan
            // jadwal, penilaian, dan pengelolaan nilai.
            'guru' => Permission::whereIn('nama_permission', [
                'kelola_jadwal',              // Mengelola jadwal mengajar.
                'kelola_penilaian',           // Mengelola data penilaian.
                'input_nilai',                // Menginput nilai siswa.
                'lihat_nilai',                // Melihat nilai.
            ])->pluck('id')->all(),

            // Siswa hanya mendapatkan permission untuk melihat nilai.
            'siswa' => Permission::whereIn('nama_permission', [
                'lihat_nilai',                // Melihat nilai sendiri.
            ])->pluck('id')->all(),
        ];

        // Melakukan perulangan untuk setiap role dan daftar permission-nya.
        foreach ($akses as $namaRole => $permissionIds) {

            // Mencari role berdasarkan nama role.
            // firstOrFail() akan menghasilkan error jika role belum tersedia.
            $role = Role::where('nama_role', $namaRole)->firstOrFail();

            // Melakukan perulangan terhadap seluruh ID permission
            // yang harus diberikan kepada role tersebut.
            foreach ($permissionIds as $permissionId) {

                // Menambahkan permission ke role tanpa menghapus
                // permission yang sudah terhubung sebelumnya.
                $role->permissions()->syncWithoutDetaching([$permissionId]);
            }
        }
    }
}
