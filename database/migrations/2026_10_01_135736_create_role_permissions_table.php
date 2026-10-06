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
        // membuat tabel role_permissions dengan kolom:
        // id sebagai primary key
        // role_id sebagai foreign key dari tabel roles, berdasarkan primary key dari tabel roles. Tolak penghapusan jika masih digunakan
        // permission_id sebagai foreign key dari tabel permissions, berdasarkan primary key dari tabel permissions. Tolak penghapusan jika masih digunakan
        // timestamps untuk membuat kolom created_at dan updated_at
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();

            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->cascadeOnDelete();

            $table->timestamps();

            // Membuat kombinasi role_id dan permission_id harus unik.
            // Artinya, role_id yang sama boleh digunakan pada permission_id berbeda,
            // tetapi tidak boleh ada dua role dengan role_id dan permission_id yang sama.
            $table->unique(
                ['role_id', 'permission_id'],
                'role_permission_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
