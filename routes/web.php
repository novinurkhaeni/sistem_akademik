<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DataMengajarController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisPenilaianController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RiwayatUploadController;
use Illuminate\Support\Facades\Route;

// ==========================================
// HALAMAN PUBLIK
// ==========================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==========================================
// AUTENTIKASI
// ==========================================

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'showLoginForm'])
        ->name('auth.login');

    Route::post('/auth/login', [AuthController::class, 'login'])
        ->name('auth.login.submit');

    Route::get('/auth/register', [AuthController::class, 'showRegistrationForm'])
        ->name('auth.register');

    Route::post('/auth/register', [AuthController::class, 'register'])
        ->name('auth.register.submit');
});

Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

// ==========================================
// SEMUA ROUTE DI BAWAH WAJIB LOGIN
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ======================================
    // SUPERADMIN
    // ======================================

    Route::prefix('superadmin')
        ->name('superadmin.')
        ->middleware('role:superadmin')
        ->group(function () {

            Route::resource('siswa', SiswaController::class);
            Route::resource('guru', GuruController::class);
            Route::resource('karyawan', KaryawanController::class);
            Route::resource('mapel', MapelController::class);
            Route::resource('kelas', KelasController::class);
            Route::resource('data-mengajar', DataMengajarController::class);
            Route::resource('jadwal', JadwalController::class);
            Route::resource('jenis-penilaian', JenisPenilaianController::class);
            Route::resource('penilaian', PenilaianController::class);
            Route::resource('nilai', NilaiController::class);
            Route::resource('users', UserController::class);

            Route::get('/riwayat-upload', [
                RiwayatUploadController::class, 'index'
            ])->name('riwayat-upload.index');

            Route::get('/riwayat-upload/{riwayat_upload}', [
                RiwayatUploadController::class, 'show'
            ])->name('riwayat-upload.show');
        });

    // ======================================
    // ADMIN TU
    // ======================================

    Route::prefix('admin-tu')
        ->name('admin-tu.')
        ->middleware('role:admin_tu')
        ->group(function () {

            // Kelola data karyawan
            Route::get('/karyawan', [KaryawanController::class, 'index'])
                ->name('karyawan.index');

            Route::get('/karyawan/create', [KaryawanController::class, 'create'])
                ->name('karyawan.create');

            Route::post('/karyawan', [KaryawanController::class, 'store'])
                ->name('karyawan.store');

            Route::get('/karyawan/{karyawan}', [KaryawanController::class, 'show'])
                ->name('karyawan.show');

            Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])
                ->name('karyawan.edit');

            Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])
                ->name('karyawan.update');

            // Melihat data siswa dan guru
            Route::get('/siswa', [SiswaController::class, 'index'])
                ->name('siswa.index');

            Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])
                ->name('siswa.show');

            Route::get('/guru', [GuruController::class, 'index'])
                ->name('guru.index');

            Route::get('/guru/{guru}', [GuruController::class, 'show'])
                ->name('guru.show');

            // Melihat riwayat upload
            Route::get('/riwayat-upload', [
                RiwayatUploadController::class, 'index'
            ])->name('riwayat-upload.index');
        });

    // ======================================
    // GURU
    // ======================================

    Route::prefix('guru')
        ->name('guru.')
        ->middleware('role:guru')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'guru'])
                ->name('dashboard');

            // Penugasan guru yang sedang login
            Route::get('/data-mengajar', [
                DataMengajarController::class, 'indexGuru'
            ])->name('data-mengajar.index');

            // Penilaian: tanpa menghapus penilaian
            Route::resource('penilaian', PenilaianController::class)
                ->except(['destroy']);

            // Nilai: tanpa menghapus nilai
            Route::resource('nilai', NilaiController::class)
                ->except(['destroy']);
        });

    // ======================================
    // SISWA
    // ======================================

    Route::prefix('siswa')
        ->name('siswa.')
        ->middleware('role:siswa')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'siswa'])
                ->name('dashboard');

            Route::get('/nilai', [NilaiController::class, 'nilaiSiswa'])
                ->name('nilai');
        });
});