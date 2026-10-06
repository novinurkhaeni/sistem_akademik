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
        // membuat tabel data_mengajar dengan kolom:
        // id sebagai primary key
        // guru_id sebagai foreign key dari tabel guru, berdasarkan primary key dari tabel guru. Tolak penghapusan jika masih digunakan
        // mapel_id sebagai foreign key dari tabel mapel, berdasarkan primary key dari tabel mapel. Tolak penghapusan jika masih digunakan
        // kelas_id sebagai foreign key dari tabel kelas, berdasarkan primary key dari tabel kelas. Tolak penghapusan jika masih digunakan
        // tahun_ajaran_id sebagai foreign key dari tabel tahun_ajaran, berdasarkan primary key dari tabel tahun_ajaran. Tolak penghapusan jika masih digunakan
        // jumlah_jam dengan tipe data Tiny Integer tanpa nilai negatif, default diisi 0
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('data_mengajar', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('guru')
                ->restrictOnDelete();

            $table->foreignId('mapel_id')
                ->constrained('mapel')
                ->restrictOnDelete();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('jumlah_jam')->default(0);
            $table->timestamps();

            // Memastikan kombinasi guru, mata pelajaran, kelas,
            // dan tahun ajaran tidak boleh terdaftar lebih dari satu kali.
            $table->unique(
                ['guru_id', 'mapel_id', 'kelas_id', 'tahun_ajaran_id'],
                'data_mengajar_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mengajar');
    }
};
