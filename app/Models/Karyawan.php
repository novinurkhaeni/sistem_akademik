<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Model Karyawan menggunakan tabel "karyawan".
    protected $table = 'karyawan';

    // Menentukan primary key tabel.
    // Primary key pada tabel karyawan adalah kolom "id".
    protected $primaryKey = 'id';

    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'email',
        'no_hp',
        'alamat',
        'photo',
        'status',
    ];
}
