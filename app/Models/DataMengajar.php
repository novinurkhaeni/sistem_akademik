<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMengajar extends Model
{
    use HasFactory;

    protected $table = 'data_mengajar';

    protected $primaryKey = 'id';

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'tahun_ajaran_id',
        'jumlah_jam',
    ];

    public function guru()
    {
        return $this->belongsTo(
            Guru::class,
            'guru_id'
        );
    }

    public function mapel()
    {
        return $this->belongsTo(
            Mapel::class,
            'mapel_id'
        );
    }

    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,
            'kelas_id'
        );
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(
            TahunAjaran::class,
            'tahun_ajaran_id'
        );
    }

    public function penilaian()
    {
        return $this->hasMany(
            Penilaian::class,
            'data_mengajar_id'
        );
    }

    public function jadwal()
    {
        return $this->hasMany(
            Jadwal::class,
            'data_mengajar_id'
        );
    }
}