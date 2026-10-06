<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMengajar extends Model
{
    // Mengaktifkan fitur HasFactory agar model dapat digunakan
    // untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model.
    // Secara default Laravel akan mencari tabel "data_mengajars",
    // sehingga perlu ditentukan secara manual karena nama tabelnya "data_mengajar".
    protected $table = 'data_mengajar';

    // Menentukan primary key tabel.
    // Secara default Laravel menggunakan kolom "id",
    // sehingga sebenarnya bagian ini boleh dihilangkan jika primary key memang "id".
    protected $primaryKey = 'id';

    // Menentukan kolom-kolom yang boleh diisi menggunakan
    // mass assignment, misalnya melalui Model::create().
    protected $fillable = [
        'guru_id',          
        'mapel_id',         
        'kelas_id',         
        'tahun_ajaran_id',  
        'jumlah_jam',       
    ];


    // Relasi ke model Guru.
    // Satu data mengajar dimiliki oleh satu guru.
    public function guru()
    {
        return $this->belongsTo(
            Guru::class,     // Model tujuan relasi
            'guru_id'        // Foreign key pada tabel data_mengajar
        );
    }


    // Relasi ke model Mapel.
    // Satu data mengajar memiliki satu mata pelajaran.
    public function mapel()
    {
        return $this->belongsTo(
            Mapel::class,     // Model tujuan relasi
            'mapel_id'        // Foreign key pada tabel data_mengajar
        );
    }


    // Relasi ke model Kelas.
    // Satu data mengajar digunakan untuk satu kelas.
    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,     // Model tujuan relasi
            'kelas_id'        // Foreign key pada tabel data_mengajar
        );
    }


    // Relasi ke model TahunAjaran.
    // Satu data mengajar berada pada satu tahun ajaran.
    public function tahunAjaran()
    {
        return $this->belongsTo(
            TahunAjaran::class,  // Model tujuan relasi
            'tahun_ajaran_id'   // Foreign key pada tabel data_mengajar
        );
    }


    // Relasi ke model Penilaian.
    // Satu data mengajar dapat memiliki banyak data penilaian.
    // Contoh: penilaian UTS, UAS, atau ulangan harian.
    public function penilaian()
    {
        return $this->hasMany(
            Penilaian::class,   // Model tujuan relasi
            'data_mengajar_id'  // Foreign key pada tabel penilaian
        );
    }


    // Relasi ke model Jadwal.
    // Satu data mengajar dapat memiliki beberapa jadwal,
    // misalnya jadwal pada hari dan jam yang berbeda.
    public function jadwal()
    {
        return $this->hasMany(
            Jadwal::class,      // Model tujuan relasi
            'data_mengajar_id'  // Foreign key pada tabel jadwal
        );
    }
}
