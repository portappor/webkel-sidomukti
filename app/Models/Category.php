<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'module',
        'color',
        'order',
        'status',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public static function getModules()
    {
        return [
            'layanan' => 'SOP & Layanan',
            'dokumen' => 'Dokumen PDF',
            'berita' => 'Berita',
            'galeri' => 'Galeri Foto',
            'video' => 'Video Dokumentasi',
            'apbd' => 'Transparansi APBD',
        ];
    }

    public function getModuleLabelAttribute()
    {
        $modules = static::getModules();
        return $modules[$this->module] ?? ucfirst($this->module);
    }

    public function getModuleBadgeClassAttribute()
    {
        return match ($this->module) {
            'dokumen' => 'bg-amber-50 text-amber-600 border-amber-200/80',
            'berita' => 'bg-blue-50 text-blue-600 border-blue-200/80',
            'galeri' => 'bg-purple-50 text-purple-600 border-purple-200/80',
            'video' => 'bg-rose-50 text-rose-600 border-rose-200/80',
            'pengumuman' => 'bg-amber-50 text-amber-600 border-amber-200/80',
            'layanan' => 'bg-emerald-50 text-emerald-600 border-emerald-200/80',
            'lembaga' => 'bg-indigo-50 text-indigo-600 border-indigo-200/80',
            'transparansi' => 'bg-cyan-50 text-cyan-600 border-cyan-200/80',
            default => 'bg-slate-100 text-slate-600 border-slate-200',
        };
    }

    public function getColorDotClassAttribute()
    {
        return match ($this->color) {
            'blue' => 'bg-blue-500',
            'rose', 'red' => 'bg-rose-500',
            'amber', 'yellow' => 'bg-amber-500',
            'purple' => 'bg-purple-500',
            'indigo' => 'bg-indigo-500',
            'cyan' => 'bg-cyan-500',
            default => 'bg-emerald-500',
        };
    }

    public function isInUse()
    {
        return match ($this->module) {
            'berita' => \App\Models\Post::where('category_id', $this->id)->orWhere('category', $this->slug)->exists(),
            'dokumen' => \App\Models\Document::where('category', $this->slug)->orWhere('category', $this->name)->exists(),
            'galeri' => \App\Models\Album::where('category', $this->slug)->exists(),
            'video' => \App\Models\Video::where('category', $this->slug)->exists(),
            'layanan' => \App\Models\KategoriLayanan::where('slug', $this->slug)->whereHas('services')->exists(),
            'apbd' => \App\Models\AnggaranKelurahan::where('kategori', $this->slug)->orWhere('kategori', $this->name)->exists(),
            default => false,
        };
    }
}

