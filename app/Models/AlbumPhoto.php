<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'image_path',
        'caption',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getImageUrlAttribute()
    {
        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }
        return Storage::url($this->image_path);
    }
}
