<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model TahunAjaran menggunakan tabel "tahun_ajaran".
    protected $table = 'tahun_ajaran';


    // Menentukan primary key tabel.
    // Primary key pada tabel tahun_ajaran adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'nama',            // Nama tahun ajaran, misalnya 2026/2027
        'tanggal_mulai',   // Tanggal dimulainya tahun ajaran
        'tanggal_selesai', // Tanggal berakhirnya tahun ajaran
        'is_active',       // Status apakah tahun ajaran sedang aktif
    ];


    // Menentukan tipe data untuk atribut tertentu.
    // Laravel akan otomatis mengubah nilai dari database
    // sesuai dengan tipe data yang telah ditentukan.
    protected function casts(): array
    {
        return [

            // Mengubah tanggal_mulai menjadi objek date/Carbon.
            'tanggal_mulai' => 'date',

            // Mengubah tanggal_selesai menjadi objek date/Carbon.
            'tanggal_selesai' => 'date',

            // Mengubah is_active menjadi boolean.
            // Nilai 1 menjadi true dan nilai 0 menjadi false.
            'is_active' => 'boolean',
        ];
    }
}
