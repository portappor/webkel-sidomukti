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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga');
            $table->string('singkatan')->nullable();
            $table->string('dasar_hukum')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('foto_logo')->nullable();
            $table->text('profil')->nullable();
            $table->text('visi_misi')->nullable();
            $table->text('tupoksi')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('institution_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembaga_id')->constrained('institutions')->onDelete('cascade');
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institution_members');
        Schema::dropIfExists('institutions');
    }
};
