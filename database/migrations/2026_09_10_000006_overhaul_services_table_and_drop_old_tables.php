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
        // Drop old unnecessary tables if they exist
        Schema::dropIfExists('service_requests');
        Schema::dropIfExists('complaints');

        // Update services table to serve as SOP and Standar Pelayanan repository
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
            if (!Schema::hasColumn('services', 'file_path')) {
                $table->string('file_path')->nullable()->after('description');
            }
            if (!Schema::hasColumn('services', 'order')) {
                $table->integer('order')->default(0)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['slug', 'file_path', 'order']);
        });
    }
};
