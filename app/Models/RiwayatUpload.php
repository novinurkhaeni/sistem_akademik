<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatUpload extends Model
{
    use HasFactory;

    protected $table = 'riwayat_upload';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'nama_file',
        'jenis_data',
        'jumlah_data',
        'jumlah_berhasil',
        'jumlah_gagal',
        'status',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }
}
