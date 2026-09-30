<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasFileCleanup;

class Album extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['cover_image'];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'cover_image',
        'event_date',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class);
    }

    public function getCoverUrlAttribute()
    {
        if (Str::startsWith($this->cover_image, ['http://', 'https://'])) {
            return $this->cover_image;
        }
        return Storage::url($this->cover_image);
    }
}
