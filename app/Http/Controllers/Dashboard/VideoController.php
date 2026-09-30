<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(12);
        $categories = Category::where('module', 'video')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::where('status', 'aktif')->orderBy('name')->get();
        }
        return view('dashboard.videos.index', compact('videos', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('module', 'video')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::where('status', 'aktif')->orderBy('name')->get();
        }
        return view('dashboard.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'youtube_url' => [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.|m\.)?(youtube\.com\/(watch\?.*v=|embed\/|v\/|shorts\/)|youtu\.be\/)[a-zA-Z0-9_-]+/i'
            ],
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ], [
            'youtube_url.regex' => '🚫 AKSES DITOLAK! Link yang dimasukkan bukan merupakan link dari YouTube. Hanya URL video resmi YouTube yang diperbolehkan.',
            'youtube_url.url' => '🚫 AKSES DITOLAK! Format URL/Link tidak valid.',
            'youtube_url.required' => 'Link / URL Video YouTube wajib diisi.',
        ]);

        $video = Video::create($request->all());

        ActivityLogger::log('CREATE', 'Video', "Menambahkan video dokumentasi baru: {$video->title}", [
            'video_id' => $video->id
        ]);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        $categories = Category::where('module', 'video')->where('status', 'aktif')->orderBy('order')->orderBy('name')->get();
        if ($categories->isEmpty()) {
            $categories = Category::where('status', 'aktif')->orderBy('name')->get();
        }
        return view('dashboard.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'youtube_url' => [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.|m\.)?(youtube\.com\/(watch\?.*v=|embed\/|v\/|shorts\/)|youtu\.be\/)[a-zA-Z0-9_-]+/i'
            ],
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ], [
            'youtube_url.regex' => '🚫 AKSES DITOLAK! Link yang dimasukkan bukan merupakan link dari YouTube. Hanya URL video resmi YouTube yang diperbolehkan.',
            'youtube_url.url' => '🚫 AKSES DITOLAK! Format URL/Link tidak valid.',
            'youtube_url.required' => 'Link / URL Video YouTube wajib diisi.',
        ]);

        $video->update($request->all());

        ActivityLogger::log('UPDATE', 'Video', "Perubahan video dokumentasi: {$video->title}", [
            'video_id' => $video->id
        ]);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $title = $video->title;
        $video->delete();

        ActivityLogger::log('DELETE', 'Video', "Menghapus video dokumentasi: {$title}");

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil dihapus.');
    }
}
