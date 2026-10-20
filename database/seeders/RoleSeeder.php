<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menentukan daftar role yang akan digunakan dalam sistem.
        // Setiap role memiliki nama dan deskripsi.
        $roles = [

            // Role dengan akses paling tinggi dan dapat mengelola seluruh sistem.
            [
                'nama_role' => 'superadmin',
                'deskripsi' => 'Pengelola seluruh sistem',
            ],

            // Role untuk petugas administrasi/tata usaha sekolah.
            [
                'nama_role' => 'admin_tu',
                'deskripsi' => 'Admin tata usaha',
            ],

            // Role untuk pengguna yang merupakan guru.
            [
                'nama_role' => 'guru',
                'deskripsi' => 'Pengguna dengan hak akses guru',
            ],

            // Role untuk pengguna yang merupakan siswa.
            [
                'nama_role' => 'siswa',
                'deskripsi' => 'Pengguna dengan hak akses siswa',
            ],
        ];

        // Melakukan perulangan untuk setiap role.
        foreach ($roles as $role) {

            // Membuat data role jika belum ada.
            // Jika role dengan nama yang sama sudah ada,
            // maka data tersebut akan diperbarui.
            Role::updateOrCreate(

                // Kondisi untuk mencari role yang sudah ada.
                ['nama_role' => $role['nama_role']],

                // Data yang akan dibuat atau diperbarui.
                $role
            );
        }
    }
}
