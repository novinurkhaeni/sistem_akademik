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
        // membuat tabel siswa dengan kolom:
        // id sebagai primary key
        // nis dengan tipe data string, panjang 30, bersifat unik
        // nisn dengan tipe data string, panjang 20, bersifat unik, boleh dikosongkan
        // nama dengan tipe data string, panjang 100
        // jenis_kelamin dengan tipe data enum, boleh dikosongkan, pilihannya ada L dan P
        // tanggal_lahir dengan tipe data date, boleh dikosongkan
        // alamat dengan tipe data text, boleh dikosongkan
        // kelas_id sebagai foreign key dari tabel kelas, berdasarkan primary key dari tabel kelas. Boleh dikosongkan, Tolak penghapusan jika masih digunakan
        // photo dengan tipe data string, panjang 255, boleh dikosongkan
        // status dengan tipe data string, panjang 20, defaultnya berisi aktif
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 30)->unique();
            $table->string('nisn', 20)->nullable()->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();

            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->nullOnDelete();

            $table->string('photo', 255)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
