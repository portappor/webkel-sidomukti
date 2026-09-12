<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(12);
        return view('dashboard.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('dashboard.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'youtube_url' => 'required|url',
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $video = Video::create($request->all());

        ActivityLogger::log('CREATE', 'Video', "Menambahkan video dokumentasi baru: {$video->title}", [
            'video_id' => $video->id
        ]);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        return view('dashboard.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'youtube_url' => 'required|url',
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
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
