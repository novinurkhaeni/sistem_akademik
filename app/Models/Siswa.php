<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model Siswa menggunakan tabel "siswa".
    protected $table = 'siswa';


    // Menentukan primary key tabel.
    // Primary key pada tabel siswa adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'nis',           // Nomor Induk Siswa
        'nisn',          // Nomor Induk Siswa Nasional
        'nama',          // Nama lengkap siswa
        'jenis_kelamin', // Jenis kelamin siswa
        'tanggal_lahir', // Tanggal lahir siswa
        'alamat',        // Alamat tempat tinggal siswa
        'kelas_id',      // ID kelas yang ditempati siswa
        'photo',         // Nama/path file foto siswa
        'status',        // Status siswa, misalnya aktif atau tidak aktif
    ];


    // Menentukan tipe data untuk atribut tertentu.
    // Laravel akan otomatis mengubah nilai tanggal_lahir
    // menjadi objek Carbon ketika data diambil dari database.
    protected function casts(): array
    {
        return [
            // Mengubah tanggal_lahir menjadi objek date/Carbon.
            // Memudahkan proses format dan manipulasi tanggal.
            'tanggal_lahir' => 'date',
        ];
    }
}
