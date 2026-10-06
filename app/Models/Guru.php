<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Laravel secara default akan menebak nama tabel dari nama model,
    // tetapi di sini ditentukan secara eksplisit menggunakan tabel "guru".
    protected $table = 'guru';

    // Menentukan primary key tabel.
    // Kolom primary key pada tabel guru adalah "id".
    protected $primaryKey = 'id';

    // Menentukan kolom yang boleh diisi menggunakan mass assignment.
    // Kolom-kolom ini dapat diisi melalui Model::create()
    // atau $model->fill().
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'email',
        'no_hp',
        'alamat',
        'photo',
        'status',
    ];
}
