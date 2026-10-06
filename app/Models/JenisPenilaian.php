<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPenilaian extends Model
{
    use HasFactory;

    protected $table = 'jenis_penilaian';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode',
        'nama',
        'kategori',
    ];
}
