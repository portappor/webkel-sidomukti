<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFileCleanup;

class Partnership extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['logo'];

    protected $fillable = [
        'name',
        'category',
        'logo',
        'description',
        'website',
        'contact_person',
        'phone',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
