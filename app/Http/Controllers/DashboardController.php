<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Karyawan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->role?->nama_role;
        $tahun_ajaran = TahunAjaran::where('is_active', 1)->first();
        $statistik = [];
        $diagram_siswa = [];

        $data_role = $user->role()->with('permissions')->first();
        $menus = $data_role?->permissions
            ->map(function ($permission) use ($role) {

                // Mengambil konfigurasi berdasarkan permission.
                $menu = config(
                    'menu.' . $permission->nama_permission
                );

                if (!$menu) {
                    return null;
                }

                // Mengambil route sesuai role pengguna.
                $route = $menu['routes'][$role] ?? null;

                // Memastikan route tersedia.
                if (!$route || !\Illuminate\Support\Facades\Route::has($route)) {
                    return null;
                }

                return array_merge($menu, [
                    'route' => $route,
                    'deskripsi' => $permission->deskripsi,
                ]);
            })
            ->filter()
            ->values();

        $views = [
            'superadmin' => 'dashboard.superadmin',
            'admin_tu'   => 'dashboard.admin_tu',
            'guru'       => 'dashboard.guru',
            'siswa'      => 'dashboard.siswa',
        ];

        if (! isset($views[$role])) {
            abort(403, 'Role pengguna tidak dikenali.');
        }

        if ($role == 'superadmin') {
            $statistik = [
                'totalSiswa'      => Siswa::count(),
                'totalGuru'       => Guru::count(),
                'totalKaryawan'   => Karyawan::count(),
                'totalMapel'      => Mapel::count(),
                'totalKelas'      => Kelas::count(),
                'totalUserAktif'  => User::where('is_active', true)->count(),
            ];

            $diagram_siswa = Siswa::with('kelas')
                ->get()
                ->groupBy('kelas.jurusan')
                ->map(function ($siswa) {
                    return $siswa->count();
                });
        }

        return view($views[$role], [
            'user' => $user,
            'statistik' => $statistik,
            'tahun_ajaran' => $tahun_ajaran,
            'diagram_siswa' => $diagram_siswa,
            'menus' => $menus
        ]);
    }
}
