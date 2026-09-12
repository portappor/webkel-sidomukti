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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unique();
            $table->decimal('pendapatan', 15, 2)->default(0);
            $table->decimal('realisasi_pendapatan', 15, 2)->default(0);
            $table->decimal('belanja', 15, 2)->default(0);
            $table->decimal('realisasi_belanja', 15, 2)->default(0);
            $table->decimal('pembiayaan', 15, 2)->default(0);
            $table->decimal('realisasi_pembiayaan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
