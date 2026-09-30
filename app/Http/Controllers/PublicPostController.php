<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = null;
        $query = Post::with('categoryRelation')->whereNotNull('published_at');

        if ($request->filled('kategori')) {
            $categorySlug = $request->kategori;
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $selectedCategory = $category;
                $query->where(function ($q) use ($category) {
                    $q->where('category_id', $category->id)
                      ->orWhere('category', $category->name);
                });
            }
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(12)->withQueryString();
        $categories = Category::where('module', 'berita')->withCount(['posts' => function ($q) {
            $q->whereNotNull('published_at');
        }])->get();

        return view('posts.index', compact('posts', 'categories', 'selectedCategory'));
    }

    public function show($slug)
    {
        $post = Post::with('categoryRelation')
                    ->where('slug', $slug)
                    ->whereNotNull('published_at')
                    ->firstOrFail();

        // Ambil berita terbaru lainnya untuk sidebar/rekomendasi
        $recentPosts = Post::with('categoryRelation')
                           ->whereNotNull('published_at')
                           ->where('id', '!=', $post->id)
                           ->latest('published_at')
                           ->take(5)
                           ->get();

        return view('posts.show', compact('post', 'recentPosts'));
    }
}
