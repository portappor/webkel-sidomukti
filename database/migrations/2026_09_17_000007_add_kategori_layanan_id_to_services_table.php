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
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'kategori_layanan_id')) {
                $table->foreignId('kategori_layanan_id')
                      ->nullable()
                      ->after('title')
                      ->constrained('kategori_layanan')
                      ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'kategori_layanan_id')) {
                $table->dropForeign(['kategori_layanan_id']);
                $table->dropColumn('kategori_layanan_id');
            }
        });
    }
};
