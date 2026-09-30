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
        Schema::table('lembagas', function (Blueprint $table) {
            $table->string('abbreviation')->nullable()->after('name');
            $table->integer('members_count')->default(0)->after('leader_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lembagas', function (Blueprint $table) {
            $table->dropColumn(['abbreviation', 'members_count']);
        });
    }
};
