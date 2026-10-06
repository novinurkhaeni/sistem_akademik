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
