<?php

namespace App\Http\Middleware;

// Mengimpor Closure untuk menerima dan menjalankan middleware berikutnya.
use Closure;

// Mengimpor Request untuk mengakses informasi HTTP dan pengguna yang login.
use Illuminate\Http\Request;

// Mengimpor Response sebagai tipe nilai kembalian dari method handle().
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk membatasi akses halaman berdasarkan role pengguna.
 *
 * Middleware ini bertugas untuk:
 * 1. Memastikan pengguna sudah login.
 * 2. Memastikan akun pengguna masih aktif.
 * 3. Memastikan role pengguna sesuai dengan role yang diizinkan.
 * 4. Meneruskan request jika seluruh pemeriksaan berhasil.
 *
 * Middleware dapat digunakan pada route dengan menyertakan satu atau
 * beberapa role yang diperbolehkan, misalnya:
 *
 * ->middleware('role:superadmin')
 * ->middleware('role:admin_tu')
 * ->middleware('role:superadmin,admin_tu')
 */
class RoleMiddleware
{
    /**
     * Memeriksa autentikasi, status akun, dan hak akses pengguna.
     *
     * @param Request $request Objek request HTTP yang sedang diproses.
     * @param Closure $next Fungsi untuk meneruskan request ke middleware
     *                      berikutnya atau ke controller.
     * @param string ...$roles Daftar role yang diizinkan mengakses route, didapat dari file route.
     *
     * @return Response Respons HTTP yang dihasilkan oleh proses berikutnya.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Mengambil pengguna yang sedang login berdasarkan guard autentikasi
        // yang digunakan oleh request saat ini.
        // Jika belum login, nilai $user adalah null.
        $user = $request->user();

        // PEMERIKSAAN 1: AUTENTIKASI
        // Memastikan request berasal dari pengguna yang sudah login.
        // Jika belum login, arahkan pengguna ke halaman login.
        if (! $user) {
            return redirect()->route('auth.login');
        }

        // PEMERIKSAAN 2: STATUS AKUN
        // Memastikan akun pengguna masih aktif.
        // Nilai is_active diasumsikan berupa boolean atau nilai yang
        // dapat dievaluasi sebagai true/false.
        // Jika akun tidak aktif, hentikan request dengan HTTP 403 Forbidden.
        if (! $user->is_active) {
            abort(403, 'Akun Anda tidak aktif.');
        }

        // PEMERIKSAAN 3: HAK AKSES BERDASARKAN ROLE
        // Mengambil nama role melalui relasi User -> Role.
        // Operator null-safe (?->) mencegah error jika pengguna belum
        // memiliki data role yang terhubung.
        // Contoh nilai namaRole: superadmin, admin_tu, guru, atau siswa.
        $namaRole = $user->role?->nama_role;

        // Memastikan role pengguna tersedia dan termasuk dalam daftar
        // role yang diizinkan pada route.
        //
        // Parameter ...$roles menerima daftar role dari middleware.
        // Contoh: role:superadmin,admin_tu
        // akan menghasilkan daftar ['superadmin', 'admin_tu'].
        //
        // Parameter true pada in_array() mengaktifkan perbandingan ketat
        // agar pencocokan nilai dan tipe data harus sesuai.
        //
        // Jika role tidak tersedia atau tidak diizinkan, hentikan request
        // dengan HTTP 403 Forbidden.
        // jika $namaRole kosong atau $namaRole tidak berada di daftar maka abort 403
        if (! $namaRole || ! in_array($namaRole, $roles, true)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // PEMERIKSAAN BERHASIL
        // Pengguna sudah login, akunnya aktif, dan role-nya diizinkan.
        // Teruskan request ke middleware berikutnya atau controller tujuan.
        return $next($request);
    }
}
