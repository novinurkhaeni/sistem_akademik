<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model RolePermission menggunakan tabel "role_permissions".
    protected $table = 'role_permissions';


    // Menentukan primary key tabel.
    // Primary key pada tabel role_permissions adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini digunakan untuk menghubungkan role
    // dengan permission.
    protected $fillable = [
        'role_id',
        'permission_id',
    ];
}
