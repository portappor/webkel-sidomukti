<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFileCleanup;

class Post extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['thumbnail'];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'category',
        'author',
        'thumbnail',
        'excerpt',
        'content',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->categoryRelation->name ?? $this->category ?? 'Umum';
    }

    public function getThumbnailUrlAttribute()
    {
        if (empty($this->thumbnail)) {
            return 'https://images.unsplash.com/photo-1544396821-4dd40b938ad3?q=80&w=600&auto=format&fit=crop';
        }
        if (\Illuminate\Support\Str::startsWith($this->thumbnail, ['http://', 'https://'])) {
            return $this->thumbnail;
        }
        return \Illuminate\Support\Facades\Storage::url($this->thumbnail);
    }
}
