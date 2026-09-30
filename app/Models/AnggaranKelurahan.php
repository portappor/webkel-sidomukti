<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\HasFileCleanup;

class AnggaranKelurahan extends Model
{
    use HasFactory, HasFileCleanup;

    protected $table = 'anggaran_kelurahan';

    protected array $fileAttributes = ['berkas_laporan_pdf'];

    protected $fillable = [
        'tahun_anggaran',
        'jenis',
        'kategori',
        'uraian',
        'anggaran',
        'realisasi',
        'keterangan',
        'berkas_laporan_pdf',
        'is_published',
    ];

    protected $casts = [
        'tahun_anggaran' => 'integer',
        'anggaran' => 'double',
        'realisasi' => 'double',
        'is_published' => 'boolean',
    ];

    /**
     * Hitung persentase ketercapaian realisasi (%)
     */
    public function getPersentaseRealisasiAttribute(): float
    {
        if ($this->anggaran <= 0) {
            return 0;
        }
        return round(($this->realisasi / $this->anggaran) * 100, 2);
    }

    /**
     * Hitung sisa / selisih anggaran (Rp)
     */
    public function getSelisihAttribute(): float
    {
        return $this->anggaran - $this->realisasi;
    }

    /**
     * URL Berkas PDF Laporan
     */
    public function getPdfUrlAttribute(): ?string
    {
        if (empty($this->berkas_laporan_pdf)) {
            return null;
        }
        if (Str::startsWith($this->berkas_laporan_pdf, ['http://', 'https://'])) {
            return $this->berkas_laporan_pdf;
        }
        return Storage::url($this->berkas_laporan_pdf);
    }
}
