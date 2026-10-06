<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model Penilaian menggunakan tabel "penilaian".
    protected $table = 'penilaian';


    // Menentukan primary key tabel.
    // Primary key pada tabel penilaian adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'data_mengajar_id',    // ID data mengajar yang memiliki penilaian
        'jenis_penilaian_id',  // ID jenis penilaian, misalnya UTS, UAS, atau UH
        'nama_penilaian',      // Nama penilaian
        'semester',            // Semester penilaian, misalnya ganjil atau genap
        'materi',              // Materi yang diujikan atau dinilai
        'tanggal',             // Tanggal pelaksanaan penilaian
        'bobot',               // Bobot penilaian dalam perhitungan nilai
        'is_published',        // Status apakah penilaian sudah dipublikasikan
    ];


    // Menentukan tipe data untuk beberapa atribut model.
    // Laravel akan otomatis mengubah nilai database ke tipe data
    // yang telah ditentukan ketika data diakses melalui model.
    protected function casts(): array
    {
        return [

            // Mengubah kolom tanggal menjadi objek tanggal (Carbon).
            // Memudahkan pengolahan dan pemformatan tanggal.
            'tanggal' => 'date',

            // Mengubah bobot menjadi angka desimal dengan 2 angka
            // di belakang koma.
            // Contoh: 25 menjadi 25.00.
            'bobot' => 'decimal:2',

            // Mengubah nilai is_published menjadi boolean.
            // Nilai 1 menjadi true dan nilai 0 menjadi false.
            'is_published' => 'boolean',
        ];
    }


    // Relasi ke model DataMengajar.
    // Setiap penilaian berasal dari satu data mengajar.
    // Melalui DataMengajar dapat diketahui guru, mapel, kelas,
    // dan tahun ajaran yang terkait dengan penilaian.
    public function dataMengajar()
    {
        return $this->belongsTo(
            DataMengajar::class,
            'data_mengajar_id'
        );
    }


    // Relasi ke model JenisPenilaian.
    // Setiap penilaian memiliki satu jenis penilaian,
    // misalnya UTS Ganjil, UAS Ganjil, UTS Genap,
    // UAS Genap, atau Ulangan Harian.
    public function jenisPenilaian()
    {
        return $this->belongsTo(
            JenisPenilaian::class,
            'jenis_penilaian_id'
        );
    }


    // Relasi ke model Nilai.
    // Satu penilaian dapat memiliki banyak nilai,
    // karena satu penilaian diikuti oleh banyak siswa.
    public function nilai()
    {
        return $this->hasMany(
            Nilai::class,
            'penilaian_id'
        );
    }
}
