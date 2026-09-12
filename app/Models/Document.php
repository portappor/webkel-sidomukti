<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'published_date',
        'status',
        'organization',
    ];

    protected $casts = [
        'published_date' => 'date',
    ];

    public function getCategoryLabelAttribute()
    {
        return match ($this->category) {
            'musrenbang' => 'Musrenbang',
            'renstra_renja' => 'Renstra & Renja',
            'sk_kelembagaan' => 'SK Kelembagaan',
            default => ucfirst($this->category),
        };
    }

    public function getDownloadUrlAttribute()
    {
        if (Str::startsWith($this->file_path, ['http://', 'https://'])) {
            return $this->file_path;
        }
        return Storage::url($this->file_path);
    }
}
