<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Pastikan pengguna sudah login
        if (! $user) {
            return redirect()->route('auth.login');
        }

        // Pastikan akun aktif
        if (! $user->is_active) {
            abort(403, 'Akun Anda tidak aktif.');
        }

        // Periksa role dari relasi User -> Role
        $namaRole = $user->role?->nama_role;

        if (! $namaRole || ! in_array($namaRole, $roles, true)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
