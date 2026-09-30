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
        Schema::table('agendas', function (Blueprint $table) {
            if (!Schema::hasColumn('agendas', 'end_date')) {
                $table->date('end_date')->nullable()->after('date');
            }
            if (!Schema::hasColumn('agendas', 'end_time')) {
                $table->string('end_time')->nullable()->after('time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'end_time']);
        });
    }
};
