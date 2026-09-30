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
        Schema::table('navigation_menus', function (Blueprint $table) {
            if (!Schema::hasColumn('navigation_menus', 'show_on_homepage')) {
                $table->boolean('show_on_homepage')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('navigation_menus', 'description')) {
                $table->text('description')->nullable()->after('show_on_homepage');
            }
            if (!Schema::hasColumn('navigation_menus', 'icon')) {
                $table->string('icon', 100)->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navigation_menus', function (Blueprint $table) {
            $table->dropColumn(['show_on_homepage', 'description', 'icon']);
        });
    }
};
