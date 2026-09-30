<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\HasFileCleanup;

class Apbd extends Model
{
    use HasFactory, HasFileCleanup;

    protected $fileAttributes = ['thumbnail', 'document'];

    protected $fillable = [
        'title',
        'year',
        'date',
        'description',
        'thumbnail',
        'document',
        'is_published',
    ];

    protected $casts = [
        'year' => 'integer',
        'date' => 'date',
        'is_published' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(ApbdItem::class);
    }
}
