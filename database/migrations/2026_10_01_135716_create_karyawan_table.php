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
        // membuat tabel karyawan dengan kolom:
        // id sebagai primary key
        // nip dengan tipe data string, panjang 30, boleh dikosongkan dan bersifat unik
        // nama dengan tipe data string, panjang 100
        // jabatan dengan tipe data string, panjang 100, boleh dikosongkan
        // email dengan tipe data string, dan boleh dikosongkan. panjang kolom dikosongkan berarti otomatis menggunakan panjang maksimal string yaitu 255
        // no_hp dengan tipe data string, panjang 20, dan boleh dikosongkan
        // alamat dengan tipe data text, boleh dikosongkan
        // photo dengan tipe data string, panjang 255, boleh dikosongkan
        // status dengan tipe data string, panjang 20, defaultnya berisi aktif
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 30)->nullable()->unique();
            $table->string('nama', 100);
            $table->string('jabatan', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
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
        Schema::dropIfExists('karyawan');
    }
};
