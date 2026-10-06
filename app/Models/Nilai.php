<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Model Nilai menggunakan tabel "nilai".
    protected $table = 'nilai';

    // Menentukan primary key tabel.
    // Primary key pada tabel nilai adalah kolom "id".
    protected $primaryKey = 'id';

    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'penilaian_id',
        'siswa_id',
        'nilai',
        'catatan',
    ];

    // Method casts() digunakan untuk mengubah nilai database
    // menjadi tipe data yang sesuai ketika diakses melalui model.
    protected function casts(): array
    {
        return [
            // Mengubah nilai menjadi angka desimal dengan 2 angka di belakang koma.
            // Contoh: 85 akan menjadi 85.00 dan 87.5 menjadi 87.50.
            'nilai' => 'decimal:2',
        ];
    }
}
