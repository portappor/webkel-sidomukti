<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasFileCleanup;

class Service extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['file_path'];

    protected $fillable = [
        'title',
        'kategori_layanan_id',
        'slug',
        'icon',
        'url',
        'description',
        'requirements',
        'operating_hours',
        'processing_time',
        'cost',
        'file_path',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the category associated with this SOP / Service document.
     */
    public function kategoriLayanan()
    {
        return $this->belongsTo(KategoriLayanan::class, 'kategori_layanan_id');
    }
}
