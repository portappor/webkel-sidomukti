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
        Schema::create('lembagas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('leader_title')->nullable(); // e.g. "Ketua LPMK", "Babinsa & Bhabinkamtibmas"
            $table->string('leader_name')->nullable();  // e.g. "Bapak H. Sugeng Riyadi"
            $table->string('icon')->default('building'); // building, user-female, user-male, shield
            $table->string('color_theme')->default('emerald'); // emerald, rose, blue, amber
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembagas');
    }
};
