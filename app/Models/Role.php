<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model Role menggunakan tabel "roles".
    protected $table = 'roles';


    // Menentukan primary key tabel.
    // Primary key pada tabel roles adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'nama_role',  // Nama role/peran pengguna
        'deskripsi',  // Penjelasan mengenai role dan hak aksesnya
    ];


    // Relasi many-to-many dengan model Permission.
    // Satu role dapat memiliki banyak permission,
    // dan satu permission dapat dimiliki oleh banyak role.
    //
    // Contoh:
    // Role Guru dapat memiliki permission:
    // - Melihat nilai
    // - Input nilai
    // - Edit nilai
    // - Publish nilai
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,  // Model tujuan relasi
            'role_permissions', // Nama tabel pivot
            'role_id',          // Foreign key role pada tabel pivot
            'permission_id'     // Foreign key permission pada tabel pivot
        );
    }


    // Relasi one-to-many dengan model User.
    // Satu role dapat digunakan oleh banyak user.
    //
    // Contoh:
    // Role "Guru" dapat dimiliki oleh banyak akun guru,
    // sedangkan setiap user hanya memiliki satu role.
    public function users()
    {
        return $this->hasMany(
            User::class, // Model tujuan relasi
            'role_id'    // Foreign key pada tabel users
        );
    }
}
