<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Model Mapel menggunakan tabel "mapel".
    protected $table = 'mapel';

    // Menentukan primary key tabel.
    // Primary key pada tabel mapel adalah kolom "id".
    protected $primaryKey = 'id';

    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kelompok',
        'deskripsi',
        'is_active',
    ];

    // Method casts() digunakan agar nilai dari database
    // otomatis dikonversi ke tipe data yang sesuai.
    protected function casts(): array
    {
        // Mengubah nilai is_active menjadi boolean.
        // Nilai database 1 akan dibaca sebagai true,
        // sedangkan nilai 0 akan dibaca sebagai false.
        return [
            'is_active' => 'boolean',
        ];
    }
}
