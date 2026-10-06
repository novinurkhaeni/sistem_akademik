<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Model Kelas menggunakan tabel "kelas".
    protected $table = 'kelas';

    // Menentukan primary key tabel.
    // Primary key pada tabel kelas adalah kolom "id".
    protected $primaryKey = 'id';

    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'tahun_ajaran_id',
    ];
}
