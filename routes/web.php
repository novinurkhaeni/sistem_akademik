<?php

// Mengimpor seluruh controller yang menangani request pada aplikasi SIAKAD.
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

// Mengimpor Route untuk mendefinisikan URL, HTTP method,
// middleware, nama route, dan controller tujuan.
use Illuminate\Support\Facades\Route;


// ======================================================
// HALAMAN PUBLIK
// ======================================================

// Menampilkan halaman welcome pada URL root (/).
// Route ini tidak memerlukan login sehingga dapat diakses
// oleh pengunjung maupun pengguna yang sudah login.
// www.marsa.com/
Route::get('/', function () {
    return view('welcome');
})->name('home');


// ======================================================
// AUTENTIKASI
// ======================================================

// Mengelompokkan route autentikasi yang hanya dapat diakses
// oleh pengunjung yang BELUM login.
//
// Middleware guest mencegah pengguna yang sudah login
// membuka kembali halaman login.
Route::middleware('guest')->group(function () {

    // Menampilkan formulir login.
    // URL  : /auth/login
    // Nama : auth.login
    // www.marsa.com/auth/login
    Route::get('/auth/login', [AuthController::class, 'showLoginForm'])
        ->name('auth.login');

    // Memproses data login yang dikirim melalui formulir.
    // AuthController@login bertugas memvalidasi kredensial
    // dan menjalankan proses autentikasi.
    // URL  : /auth/login
    // HTTP : POST
    // Nama : auth.login.submit
    // www.marsa.com/auth/login
    Route::post('/auth/login', [AuthController::class, 'login'])
        ->name('auth.login.submit');
});


// Route logout hanya dapat diakses oleh pengguna yang sudah login.
// HTTP POST digunakan untuk menjalankan proses logout,
// bukan GET, karena logout mengubah status autentikasi.
// www.marsa.com/auth/logout
Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');


// ======================================================
// SEMUA ROUTE DI BAWAH WAJIB LOGIN
// ======================================================

// Middleware auth memastikan pengguna sudah terautentikasi
// sebelum mengakses dashboard maupun halaman berdasarkan role.
//
// Di dalam grup ini terdapat route untuk:
// 1. Dashboard umum.
// 2. Superadmin.
// 3. Admin TU.
// 4. Guru.
// 5. Siswa.
Route::middleware('auth')->group(function () {

    // --------------------------------------------------
    // DASHBOARD UMUM
    // --------------------------------------------------

    // Menampilkan dashboard berdasarkan logika pada DashboardController.
    // URL  : /dashboard
    // Nama : dashboard
    //
    // Catatan: pembatasan role khusus perlu dilakukan di controller
    // atau diarahkan ke dashboard masing-masing role setelah login.
    // www.marsa.com/dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');


    // ==================================================
    // SUPERADMIN
    // ==================================================

    // Seluruh route dalam grup ini:
    // - Memiliki awalan URL /superadmin.
    // - Memiliki awalan nama route superadmin.
    // - Hanya dapat diakses oleh pengguna dengan role superadmin.
    //
    // Contoh:
    // URL  : /superadmin/siswa
    // Nama : superadmin.siswa.index
    Route::prefix('superadmin')
        ->name('superadmin.')
        ->middleware('role:superadmin')
        ->group(function () {

            // CRUD data siswa:
            // index, create, store, show, edit, update, destroy.
            Route::resource('siswa', SiswaController::class);

            // CRUD data guru.
            Route::resource('guru', GuruController::class);

            // CRUD data karyawan.
            Route::resource('karyawan', KaryawanController::class);

            // CRUD mata pelajaran.
            Route::resource('mapel', MapelController::class);

            // CRUD data kelas.
            Route::resource('kelas', KelasController::class);

            // CRUD penugasan mengajar, misalnya hubungan guru,
            // mata pelajaran, kelas, tahun ajaran, dan jumlah jam.
            Route::resource('data-mengajar', DataMengajarController::class);

            // CRUD jadwal pembelajaran.
            Route::resource('jadwal', JadwalController::class);

            // CRUD jenis penilaian, misalnya UTS, UAS,
            // atau ulangan harian.
            Route::resource('jenis-penilaian', JenisPenilaianController::class);

            // CRUD data penilaian.
            Route::resource('penilaian', PenilaianController::class);

            // CRUD nilai siswa.
            Route::resource('nilai', NilaiController::class);

            // CRUD akun pengguna aplikasi.
            // Pengelolaan akun dilakukan oleh superadmin.
            Route::resource('users', UserController::class);


            // ------------------------------------------
            // RIWAYAT UPLOAD SUPERADMIN
            // ------------------------------------------

            // Menampilkan daftar riwayat upload.
            // URL  : /superadmin/riwayat-upload
            // Nama : superadmin.riwayat-upload.index
            // www.marsa.com/riwayat-upload
            Route::get('/riwayat-upload', [
                RiwayatUploadController::class,
                'index'
            ])->name('riwayat-upload.index');

            // Menampilkan detail satu riwayat upload.
            // Parameter {riwayat_upload} digunakan untuk
            // mengidentifikasi data riwayat yang akan ditampilkan.
            // URL  : /superadmin/riwayat-upload/{riwayat_upload}
            // Nama : superadmin.riwayat-upload.show
            Route::get('/riwayat-upload/{riwayat_upload}', [
                RiwayatUploadController::class,
                'show'
            ])->name('riwayat-upload.show');
        });


    // ==================================================
    // ADMIN TU
    // ==================================================

    // Seluruh route dalam grup ini:
    // - Memiliki awalan URL /admin-tu.
    // - Memiliki awalan nama route admin-tu.
    // - Hanya dapat diakses oleh pengguna dengan role admin_tu.
    //
    // Hak akses Admin TU pada konfigurasi ini dibatasi untuk
    // pengelolaan karyawan, melihat data siswa dan guru,
    // serta melihat riwayat upload.
    Route::prefix('admin-tu')
        ->name('admin-tu.')
        ->middleware('role:admin_tu')
        ->group(function () {

            // ------------------------------------------
            // KELOLA DATA KARYAWAN
            // ------------------------------------------

            // Menampilkan daftar karyawan.
            Route::get('/karyawan', [KaryawanController::class, 'index'])
                ->name('karyawan.index');

            // Menampilkan formulir tambah karyawan.
            Route::get('/karyawan/create', [KaryawanController::class, 'create'])
                ->name('karyawan.create');

            // Menyimpan data karyawan baru.
            Route::post('/karyawan', [KaryawanController::class, 'store'])
                ->name('karyawan.store');

            // Menampilkan detail seorang karyawan.
            Route::get('/karyawan/{karyawan}', [KaryawanController::class, 'show'])
                ->name('karyawan.show');

            // Menampilkan formulir edit karyawan.
            Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])
                ->name('karyawan.edit');

            // Memperbarui data karyawan yang dipilih.
            Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])
                ->name('karyawan.update');


            // ------------------------------------------
            // MELIHAT DATA SISWA DAN GURU
            // ------------------------------------------

            // Admin TU hanya dapat melihat daftar siswa.
            // Tidak disediakan route tambah, edit, atau hapus siswa.
            Route::get('/siswa', [SiswaController::class, 'index'])
                ->name('siswa.index');

            // Melihat detail siswa tertentu.
            Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])
                ->name('siswa.show');

            // Melihat daftar guru.
            Route::get('/guru', [GuruController::class, 'index'])
                ->name('guru.index');

            // Melihat detail guru tertentu.
            Route::get('/guru/{guru}', [GuruController::class, 'show'])
                ->name('guru.show');


            // ------------------------------------------
            // RIWAYAT UPLOAD ADMIN TU
            // ------------------------------------------

            // Menampilkan daftar riwayat upload.
            // Admin TU tidak diberi route show khusus pada konfigurasi ini.
            // URL  : /admin-tu/riwayat-upload
            // Nama : admin-tu.riwayat-upload.index
            Route::get('/riwayat-upload', [
                RiwayatUploadController::class,
                'index'
            ])->name('riwayat-upload.index');
        });


    // ==================================================
    // GURU
    // ==================================================

    // Seluruh route dalam grup ini:
    // - Memiliki awalan URL /guru.
    // - Memiliki awalan nama route guru.
    // - Hanya dapat diakses oleh pengguna dengan role guru.
    Route::prefix('guru')
        ->name('guru.')
        ->middleware('role:guru')
        ->group(function () {

            // Menampilkan dashboard khusus guru.
            Route::get('/dashboard', [DashboardController::class, 'guru'])
                ->name('dashboard');


            // ------------------------------------------
            // DATA MENGAJAR GURU
            // ------------------------------------------

            // Menampilkan penugasan mengajar milik guru yang login.
            // Controller harus memfilter data berdasarkan identitas
            // guru yang terhubung dengan akun pengguna saat ini.
            Route::get('/data-mengajar', [
                DataMengajarController::class,
                'indexGuru'
            ])->name('data-mengajar.index');


            // ------------------------------------------
            // PENILAIAN GURU
            // ------------------------------------------

            // Membuat route resource untuk penilaian, kecuali destroy.
            // Guru dapat menggunakan route index, create, store,
            // show, edit, dan update.
            // Route destroy tidak dibuat agar guru tidak dapat
            // menghapus data penilaian melalui resource ini.
            Route::resource('penilaian', PenilaianController::class)
                ->except(['destroy']);


            // ------------------------------------------
            // NILAI GURU
            // ------------------------------------------

            // Membuat route resource nilai tanpa route destroy.
            // Guru dapat melihat, menambahkan, dan memperbarui nilai
            // sesuai dengan aturan bisnis di controller.
            Route::resource('nilai', NilaiController::class)
                ->except(['destroy']);
        });


    // ==================================================
    // SISWA
    // ==================================================

    // Seluruh route dalam grup ini:
    // - Memiliki awalan URL /siswa.
    // - Memiliki awalan nama route siswa.
    // - Hanya dapat diakses oleh pengguna dengan role siswa.
    Route::prefix('siswa')
        ->name('siswa.')
        ->middleware('role:siswa')
        ->group(function () {

            // Menampilkan dashboard khusus siswa.
            Route::get('/dashboard', [DashboardController::class, 'siswa'])
                ->name('dashboard');


            // ------------------------------------------
            // MELIHAT NILAI SISWA
            // ------------------------------------------

            // Menampilkan nilai siswa yang sedang login.
            // URL  : /siswa/nilai
            // Nama : siswa.nilai.index
            //
            // Controller wajib memastikan siswa hanya dapat
            // melihat nilai miliknya sendiri, bukan nilai siswa lain.
            Route::get('/nilai', [NilaiController::class, 'nilaiSiswa'])
                ->name('nilai.index');
        });
});
