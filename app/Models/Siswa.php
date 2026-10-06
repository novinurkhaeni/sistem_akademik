<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'kelas_id',
        'photo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }
}
