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
        Schema::create('anggaran_kelurahan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_anggaran')->index();
            $table->enum('jenis', ['pendapatan', 'belanja', 'pembiayaan'])->default('pendapatan')->index();
            $table->string('kategori'); // contoh: Pendapatan Transfer, Belanja Operasional, Belanja Modal
            $table->string('uraian'); // rincian nama pos / kegiatan
            $table->decimal('anggaran', 15, 2)->default(0); // target nominal Rp
            $table->decimal('realisasi', 15, 2)->default(0); // realisasi nominal Rp
            $table->text('keterangan')->nullable();
            $table->string('berkas_laporan_pdf')->nullable(); // path upload PDF
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_kelurahan');
    }
};
