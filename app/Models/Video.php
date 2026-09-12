<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'youtube_url',
        'duration',
        'description',
    ];

    public function getYoutubeIdAttribute()
    {
        $url = $this->youtube_url;
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getEmbedUrlAttribute()
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube.com/embed/{$id}" : $this->youtube_url;
    }

    public function getThumbnailUrlAttribute()
    {
        $id = $this->youtube_id;
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop';
    }
}
