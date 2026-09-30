<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicGalleryController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'all');
        $categories = Category::where('module', 'galeri')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::where('status', 'aktif')->orderBy('name')->get();
        }

        $query = Album::withCount('photos')->latest();
        if ($selectedCategory !== 'all') {
            $cat = $categories->firstWhere('slug', $selectedCategory) ?? Category::where('slug', $selectedCategory)->first();
            if ($cat) {
                $query->where(function($q) use ($cat, $selectedCategory) {
                    $q->where('category', $cat->slug)
                      ->orWhere('category', $cat->name)
                      ->orWhere('category', $selectedCategory);
                });
            } else {
                $query->where('category', $selectedCategory);
            }
        }

        $albums = $query->paginate(12)->withQueryString();

        return view('galleries.index', compact('albums', 'categories', 'selectedCategory'));
    }

    public function show(Request $request, $slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->firstOrFail();
        
        $otherAlbums = Album::withCount('photos')
            ->where('id', '!=', $album->id)
            ->latest()
            ->get();

        return view('galleries.show', compact('album', 'otherAlbums'));
    }
}
