<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('categoryRelation')->latest()->get();
        $categories = Category::where('module', 'berita')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::orderBy('name')->get();
        }
        return view('dashboard.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('module', 'berita')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::orderBy('name')->get();
        }
        return view('dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'author' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'thumbnail_url' => 'nullable|url',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'created_at' => 'nullable|date',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
        } elseif ($request->filled('thumbnail_url')) {
            $thumbnailPath = trim($request->thumbnail_url);
        }

        $categoryName = null;
        if ($request->filled('category_id')) {
            $cat = Category::find($request->category_id);
            $categoryName = $cat?->name;
        }

        $customDate = $request->filled('created_at') ? \Carbon\Carbon::parse($request->created_at) : now();

        $post = new Post([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'category' => $categoryName,
            'author' => $request->author,
            'excerpt' => \Illuminate\Support\Str::limit(strip_tags($request->content), 200),
            'thumbnail' => $thumbnailPath,
            'content' => $request->content,
            'published_at' => $request->status === 'published' ? $customDate : null,
        ]);
        $post->created_at = $customDate;
        $post->save();

        ActivityLogger::log('CREATE', 'Berita', "Menambahkan berita baru: {$post->title}", [
            'post_id' => $post->id,
            'status' => $request->status
        ]);

        return redirect()->route('dashboard.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        $categories = Category::where('module', 'berita')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::orderBy('name')->get();
        }
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'author' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'thumbnail_url' => 'nullable|url',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'created_at' => 'nullable|date',
        ]);

        $thumbnailPath = $post->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('posts', 'public');
        } elseif ($request->filled('thumbnail_url')) {
            $thumbnailPath = trim($request->thumbnail_url);
        }

        $categoryName = $post->category;
        if ($request->filled('category_id')) {
            $cat = Category::find($request->category_id);
            $categoryName = $cat?->name;
        } elseif ($request->has('category_id') && is_null($request->category_id)) {
            $categoryName = null;
        }

        $customDate = $request->filled('created_at') ? \Carbon\Carbon::parse($request->created_at) : $post->created_at;

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'category' => $categoryName,
            'author' => $request->author,
            'excerpt' => \Illuminate\Support\Str::limit(strip_tags($request->content), 200),
            'thumbnail' => $thumbnailPath,
            'content' => $request->content,
            'published_at' => $request->status === 'published' ? ($post->published_at ?? $customDate) : null,
        ]);

        if ($request->filled('created_at')) {
            $post->created_at = $customDate;
            if ($post->published_at) {
                $post->published_at = $customDate;
            }
            $post->save();
        }

        ActivityLogger::log('UPDATE', 'Berita', "Mengubah berita: {$post->title}", [
            'post_id' => $post->id,
            'status' => $request->status
        ]);

        return redirect()->route('dashboard.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function updateDate(Request $request, Post $post)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $newDate = \Carbon\Carbon::parse($request->date);
        $post->created_at = $newDate;
        if ($post->published_at) {
            $post->published_at = $newDate;
        }
        $post->save();

        ActivityLogger::log('UPDATE', 'Berita', "Mengubah tanggal berita: {$post->title}", [
            'post_id' => $post->id,
            'new_date' => $newDate->toDateTimeString()
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tanggal berita berhasil diperbarui.',
                'formatted_date' => $newDate->format('d M Y, H:i'),
                'raw_date' => $newDate->format('Y-m-d\TH:i')
            ]);
        }

        return redirect()->back()->with('success', 'Tanggal berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $postTitle = $post->title;
        
        // Hapus model data (Otomatis memicu event model deleting & pembersihan file fisik di storage)
        $post->delete();

        return redirect()->route('dashboard.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}
