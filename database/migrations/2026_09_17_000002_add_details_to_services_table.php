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
            if (!Schema::hasColumn('services', 'operating_hours')) {
                $table->string('operating_hours')->nullable()->default('Senin - Jumat')->after('requirements');
            }
            if (!Schema::hasColumn('services', 'processing_time')) {
                $table->string('processing_time')->nullable()->default('Tergantung Layanan')->after('operating_hours');
            }
            if (!Schema::hasColumn('services', 'cost')) {
                $table->string('cost')->nullable()->default('GRATIS')->after('processing_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['operating_hours', 'processing_time', 'cost']);
        });
    }
};
