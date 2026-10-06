<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model Permission menggunakan tabel "permissions".
    protected $table = 'permissions';


    // Menentukan primary key tabel.
    // Primary key pada tabel permissions adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'nama_permission', // Nama permission/hak akses
        'deskripsi',       // Penjelasan mengenai fungsi permission
    ];


    // Relasi many-to-many dengan model Role.
    // Satu permission dapat dimiliki oleh banyak role,
    // dan satu role dapat memiliki banyak permission.
    //
    // Contoh:
    // Role "Guru" memiliki permission:
    // - Melihat nilai
    // - Menginput nilai
    // - Mengubah nilai
    //
    // Role "Admin TU" dapat memiliki permission yang berbeda.
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,       // Model tujuan relasi
            'role_permissions', // Nama tabel pivot
            'permission_id',    // Foreign key permission pada tabel pivot
            'role_id'           // Foreign key role pada tabel pivot
        );
    }
}
