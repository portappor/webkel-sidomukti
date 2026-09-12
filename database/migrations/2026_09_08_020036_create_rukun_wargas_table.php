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
        Schema::create('rukun_wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rw');
            $table->integer('jumlah_rt');
            $table->integer('estimasi_penduduk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rukun_wargas');
    }
};
