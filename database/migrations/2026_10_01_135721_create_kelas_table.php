<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // membuat tabel kelas dengan kolom:
        // id sebagai primary key
        // nama_kelas dengan tipe data string, panjang 50
        // tingkat dengan tipe data string, panjang 20
        // jurusan dengan tipe data string, panjang 100, boleh dikosongkan
        // tahun_ajaran_id sebagai foreign key dari tabel tahun_ajaran, berdasarkan primary key dari tabel tahun_ajaran. Tolak penghapusan jika masih digunakan
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50);
            $table->string('tingkat', 20);
            $table->string('jurusan', 100)->nullable();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->restrictOnDelete();

            $table->timestamps();

            // Membuat kombinasi nama kelas dan tahun ajaran harus unik.
            // Artinya, nama kelas yang sama boleh digunakan pada tahun ajaran berbeda,
            // tetapi tidak boleh ada dua kelas dengan nama dan tahun ajaran yang sama.
            $table->unique(
                ['nama_kelas', 'tahun_ajaran_id'],
                'kelas_nama_tahun_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
