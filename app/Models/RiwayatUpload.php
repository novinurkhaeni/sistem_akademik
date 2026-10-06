<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatUpload extends Model
{
    // Mengaktifkan fitur HasFactory.
    // Digunakan untuk membuat data dummy menggunakan Laravel Factory.
    use HasFactory;


    // Menentukan nama tabel yang digunakan oleh model.
    // Model RiwayatUpload menggunakan tabel "riwayat_upload".
    protected $table = 'riwayat_upload';


    // Menentukan primary key tabel.
    // Primary key pada tabel riwayat_upload adalah kolom "id".
    protected $primaryKey = 'id';


    // Menentukan kolom yang boleh diisi melalui mass assignment.
    // Kolom-kolom ini dapat digunakan ketika membuat atau memperbarui
    // data menggunakan Model::create(), update(), atau fill().
    protected $fillable = [
        'user_id',         // ID pengguna yang melakukan proses upload
        'nama_file',       // Nama file yang diupload
        'jenis_data',      // Jenis data yang diupload
        'jumlah_data',     // Jumlah seluruh data dalam file
        'jumlah_berhasil', // Jumlah data yang berhasil diproses
        'jumlah_gagal',    // Jumlah data yang gagal diproses
        'status',          // Status proses upload
        'uploaded_at',     // Waktu ketika file diupload
    ];


    // Laravel akan otomatis mengubah nilai dari database
    // menjadi tipe data yang telah ditentukan ketika data diakses.
    protected function casts(): array
    {
        return [
            // Mengubah uploaded_at menjadi objek Carbon/datetime.
            // Memudahkan pengolahan tanggal dan waktu upload.
            'uploaded_at' => 'datetime',
        ];
    }
}
