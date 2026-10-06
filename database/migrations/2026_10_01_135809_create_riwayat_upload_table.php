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
        Schema::create('riwayat_upload', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->string('nama_file', 255);
            $table->string('jenis_data', 50);
            $table->unsignedInteger('jumlah_data')->default(0);
            $table->unsignedInteger('jumlah_berhasil')->default(0);
            $table->unsignedInteger('jumlah_gagal')->default(0);
            $table->string('status', 30)->default('diproses');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            $table->index(['jenis_data', 'uploaded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_upload');
    }
};
