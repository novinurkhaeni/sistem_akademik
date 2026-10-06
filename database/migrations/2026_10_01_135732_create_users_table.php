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
        // membuat tabel users dengan kolom:
        // id sebagai primary key
        // role_id sebagai foreign key dari tabel roles, berdasarkan primary key dari tabel roles. Tolak penghapusan jika masih digunakan
        // guru_id sebagai foreign key dari tabel guru, berdasarkan primary key dari tabel guru. Boleh dikosongkan, bersifat unik, Tolak penghapusan jika masih digunakan
        // siswa_id sebagai foreign key dari tabel siswa, berdasarkan primary key dari tabel siswa. Boleh dikosongkan, bersifat unik, Tolak penghapusan jika masih digunakan
        // karyawan_id sebagai foreign key dari tabel karyawan, berdasarkan primary key dari tabel karyawan. Boleh dikosongkan, bersifat unik, Tolak penghapusan jika masih digunakan
        // username dengan tipe data string, panjang 50, bersifat unik
        // email dengan tipe data string, panjang 255, bersifat unik
        // email_verified_at dengan tipe data timestamp, boleh dikosongkan
        // password dengan tipe data string, panjang 255
        // is_active dengan tipe data boolean, default diisi true
        // remember token dengan tipe data string
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                ->constrained('roles')
                ->restrictOnDelete();

            $table->foreignId('guru_id')
                ->nullable()
                ->unique()
                ->constrained('guru')
                ->nullOnDelete();

            $table->foreignId('siswa_id')
                ->nullable()
                ->unique()
                ->constrained('siswa')
                ->nullOnDelete();

            $table->foreignId('karyawan_id')
                ->nullable()
                ->unique()
                ->constrained('karyawan')
                ->nullOnDelete();

            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
