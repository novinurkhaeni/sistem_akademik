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
        $roles = [
            ['nama_role' => 'superadmin', 'deskripsi' => 'Pengelola seluruh sistem'],
            ['nama_role' => 'admin_tu', 'deskripsi' => 'Admin tata usaha'],
            ['nama_role' => 'guru', 'deskripsi' => 'Pengguna dengan hak akses guru'],
            ['nama_role' => 'siswa', 'deskripsi' => 'Pengguna dengan hak akses siswa'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['nama_role' => $role['nama_role']],
                $role
            );
        }
    }
}
