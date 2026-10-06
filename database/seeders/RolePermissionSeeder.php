<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $semuaPermission = Permission::all();

        $akses = [
            'superadmin' => $semuaPermission->pluck('id')->all(),

            'admin_tu' => Permission::whereIn('nama_permission', [
                'kelola_siswa',
                'kelola_guru',
                'kelola_karyawan',
                'kelola_mapel',
                'kelola_kelas',
                'kelola_user',
                'upload_data',
                'lihat_riwayat_upload',
            ])->pluck('id')->all(),

            'guru' => Permission::whereIn('nama_permission', [
                'kelola_jadwal',
                'kelola_penilaian',
                'input_nilai',
                'lihat_nilai',
            ])->pluck('id')->all(),

            'siswa' => Permission::whereIn('nama_permission', [
                'lihat_nilai',
            ])->pluck('id')->all(),
        ];

        foreach ($akses as $namaRole => $permissionIds) {
            $role = Role::where('nama_role', $namaRole)->firstOrFail();

            foreach ($permissionIds as $permissionId) {
                $role->permissions()->syncWithoutDetaching([$permissionId]);
            }
        }
    }
}
