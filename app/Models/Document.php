<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasFileCleanup;

class Document extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['file_path'];

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
        $categoryValue = $this->category;
        $variants = [
            $categoryValue,
            Str::slug($categoryValue),
            str_replace('-', '_', Str::slug($categoryValue)),
            'dokumen-' . Str::slug($categoryValue),
            str_replace('dokumen-', '', $categoryValue),
            str_replace('_', '-', str_replace('dokumen-', '', $categoryValue)),
        ];

        $categoryModel = \App\Models\Category::where('module', 'dokumen')
            ->where(function ($q) use ($variants) {
                $q->whereIn('slug', $variants)->orWhereIn('name', $variants);
            })->first();

        if ($categoryModel) {
            return $categoryModel->name;
        }

        return match ($categoryValue) {
            'musrenbang' => 'Musrenbang',
            'renstra_renja', 'renstra-renja' => 'Renstra & Renja',
            'sk_kelembagaan', 'sk-kelembagaan' => 'SK Kelembagaan',
            default => ucfirst(str_replace(['dokumen-', '_', '-'], [' ', ' ', ' '], $categoryValue)),
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
