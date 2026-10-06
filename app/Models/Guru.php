<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'id';

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
