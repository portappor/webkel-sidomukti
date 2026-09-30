<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApbdItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'apbd_id',
        'jenis',
        'kategori',
        'uraian',
        'anggaran',
        'realisasi',
    ];

    protected $casts = [
        'anggaran' => 'double',
        'realisasi' => 'double',
    ];

    public function apbd()
    {
        return $this->belongsTo(Apbd::class);
    }

    public function getSelisihAttribute(): float
    {
        if ($this->jenis === 'pendapatan' || ($this->jenis === 'pembiayaan' && str_contains(strtolower($this->kategori ?? ''), 'penerimaan'))) {
            return $this->realisasi - $this->anggaran;
        }
        return $this->anggaran - $this->realisasi;
    }
}
