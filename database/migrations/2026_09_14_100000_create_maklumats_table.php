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
        Schema::create('maklumats', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Maklumat Pelayanan Kelurahan Sidomukti');
            $table->string('subtitle')->nullable()->default('Komitmen Penyelenggaraan Pelayanan Publik Prima');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('signer_name')->nullable()->default('H. Ahmad Syarif, S.STP, M.Si');
            $table->string('signer_title')->nullable()->default('Kepala Kelurahan Sidomukti');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maklumats');
    }
};
