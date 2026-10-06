<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Model Jadwal menggunakan tabel "jadwal".
    protected $table = 'jadwal';

    // Menentukan primary key tabel.
    // Primary key pada tabel jadwal adalah kolom "id".
    protected $primaryKey = 'id';

    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'data_mengajar_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruang',
    ];
}
