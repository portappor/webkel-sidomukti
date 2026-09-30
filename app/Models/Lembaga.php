<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lembaga extends Model
{
    use HasFactory;

    protected $table = 'institutions';

    protected $fillable = [
        'nama_lembaga',
        'singkatan',
        'dasar_hukum',
        'alamat_kantor',
        'foto_logo',
        'profil',
        'visi_misi',
        'tupoksi',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function members()
    {
        return $this->hasMany(LembagaMember::class, 'lembaga_id')->orderBy('urutan');
    }

    public function getFotoLogoUrlAttribute()
    {
        if ($this->foto_logo) {
            return Storage::url($this->foto_logo);
        }
        return null;
    }
}
