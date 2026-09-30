<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFileCleanup;

class Gallery extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['image_path'];

    protected $fillable = ['title', 'image_path'];
}
