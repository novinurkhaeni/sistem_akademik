<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Mengaktifkan fitur HasFactory untuk membuat data dummy
    // menggunakan Laravel Factory.
    //
    // Notifiable digunakan agar User dapat menerima notifikasi Laravel,
    // misalnya notifikasi melalui email atau database.
    use HasFactory, Notifiable;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model User menggunakan tabel "users".
    protected $table = 'users';


    // Menentukan primary key tabel.
    // Primary key pada tabel users adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'role_id',      // ID role/hak akses pengguna
        'guru_id',      // ID guru jika akun dimiliki oleh seorang guru
        'siswa_id',     // ID siswa jika akun dimiliki oleh seorang siswa
        'karyawan_id',  // ID karyawan jika akun dimiliki oleh seorang karyawan
        'username',     // Username untuk login
        'email',        // Email pengguna
        'password',     // Password pengguna
        'is_active',    // Status akun: aktif atau tidak aktif
    ];


    // Menentukan atribut yang tidak boleh ditampilkan ketika model
    // dikonversi menjadi array atau JSON.
    // Password dan remember_token tidak boleh dikirim ke frontend
    // atau ditampilkan dalam response API.
    protected $hidden = [
        'password',       // Password pengguna
        'remember_token', // Token untuk fitur "Remember Me"
    ];


    // Menentukan tipe data beberapa atribut model.
    // Laravel akan otomatis mengubah nilai database sesuai
    // dengan tipe data yang telah ditentukan.
    protected function casts(): array
    {
        return [

            // Mengubah email_verified_at menjadi objek datetime/Carbon.
            // Digunakan untuk mengetahui kapan email pengguna diverifikasi.
            'email_verified_at' => 'datetime',

            // Secara otomatis melakukan hashing terhadap password
            // ketika password diisi atau diubah melalui model.
            'password' => 'hashed',

            // Mengubah is_active menjadi boolean.
            // Nilai 1 menjadi true dan nilai 0 menjadi false.
            'is_active' => 'boolean',
        ];
    }
}
