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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik', 16)->nullable();
            $table->string('phone', 30);
            $table->string('category');
            $table->string('title');
            $table->string('location');
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->enum('status', ['pending', 'processing', 'resolved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
