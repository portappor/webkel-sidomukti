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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'module')) {
                $table->string('module')->default('berita')->after('slug');
            }
            if (!Schema::hasColumn('categories', 'color')) {
                $table->string('color')->default('emerald')->after('module');
            }
            if (!Schema::hasColumn('categories', 'order')) {
                $table->integer('order')->default(1)->after('color');
            }
            if (!Schema::hasColumn('categories', 'status')) {
                $table->string('status')->default('aktif')->after('order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['module', 'color', 'order', 'status']);
        });
    }
};
