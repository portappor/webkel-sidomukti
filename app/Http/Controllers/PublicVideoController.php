<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicVideoController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category', 'all');
        $categories = Category::where('module', 'video')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::where('status', 'aktif')->orderBy('name')->get();
        }

        $query = Video::latest();
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

        $videos = $query->paginate(12)->withQueryString();

        return view('videos.index', compact('videos', 'categories', 'selectedCategory'));
    }
}



