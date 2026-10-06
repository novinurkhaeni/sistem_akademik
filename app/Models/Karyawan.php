<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id';

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
