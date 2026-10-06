<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $primaryKey = 'id';

    protected $fillable = [
        'data_mengajar_id',
        'jenis_penilaian_id',
        'nama_penilaian',
        'semester',
        'materi',
        'tanggal',
        'bobot',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'bobot' => 'decimal:2',
            'is_published' => 'boolean',
        ];
    }

    public function dataMengajar()
    {
        return $this->belongsTo(
            DataMengajar::class,
            'data_mengajar_id'
        );
    }

    public function jenisPenilaian()
    {
        return $this->belongsTo(
            JenisPenilaian::class,
            'jenis_penilaian_id'
        );
    }

    public function nilai()
    {
        return $this->hasMany(
            Nilai::class,
            'penilaian_id'
        );
    }
}
