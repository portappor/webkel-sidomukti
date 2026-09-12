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
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('name');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            $table->string('agama')->nullable()->after('jenis_kelamin');
            $table->string('pekerjaan')->nullable()->after('agama');
            $table->text('alamat')->nullable()->after('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'pekerjaan',
                'alamat'
            ]);
        });
    }
};
