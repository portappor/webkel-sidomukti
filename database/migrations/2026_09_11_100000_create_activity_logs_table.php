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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('user_name')->default('Sistem');
            $table->string('user_role')->default('guest');
            $table->string('action'); // LOGIN, LOGOUT, CREATE, UPDATE, DELETE, UPDATE_STATUS, etc.
            $table->string('module'); // Pengguna, Berita, Pengumuman, Dokumen, Agenda, Layanan, Galeri, Pengaduan, Pengaturan, Data RT/RW, Lembaga, Kategori, Transparansi
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
