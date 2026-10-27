<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // if (! $user || ! $user->is_active) {
        //     abort(403, 'Akun tidak aktif atau tidak memiliki akses.');
        // }

        $role = $user->role?->nama_role;

        $views = [
            'superadmin' => 'dashboard.superadmin',
            'admin_tu'   => 'dashboard.admin_tu',
            'guru'       => 'dashboard.guru',
            'siswa'      => 'dashboard.siswa',
        ];

        if (! isset($views[$role])) {
            abort(403, 'Role pengguna tidak dikenali.');
        }

        return view($views[$role], ['user' => $user]);
    }
}
