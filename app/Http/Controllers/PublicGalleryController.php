<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class PublicGalleryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        
        $query = Album::withCount('photos')->latest();
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $albums = $query->paginate(12);

        return view('galleries.index', compact('albums', 'category'));
    }

    public function show($slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->firstOrFail();
        
        $relatedAlbums = Album::where('id', '!=', $album->id)
            ->where('category', $album->category)
            ->latest()
            ->take(4)
            ->get();

        return view('galleries.show', compact('album', 'relatedAlbums'));
    }
}
