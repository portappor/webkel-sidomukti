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
        Schema::create('apbd_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apbd_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis', ['pendapatan', 'belanja', 'pembiayaan']);
            $table->string('kategori')->nullable();
            $table->string('uraian');
            $table->decimal('anggaran', 20, 2)->default(0);
            $table->decimal('realisasi', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apbd_items');
    }
};
