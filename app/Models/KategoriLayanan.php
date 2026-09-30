<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLayanan extends Model
{
    use HasFactory;

    protected $table = 'kategori_layanan';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
    ];

    /**
     * Get all SOP / Service documents associated with this category.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'kategori_layanan_id');
    }
}
