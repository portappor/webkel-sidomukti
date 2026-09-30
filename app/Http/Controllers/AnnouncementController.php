<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('dashboard.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('dashboard.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        ActivityLogger::log('CREATE', 'Pengumuman', "Menambahkan pengumuman baru: {$announcement->title}", [
            'announcement_id' => $announcement->id
        ]);

        return redirect()->route('dashboard.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('dashboard.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        ActivityLogger::log('UPDATE', 'Pengumuman', "Mengubah pengumuman: {$announcement->title}", [
            'announcement_id' => $announcement->id
        ]);

        return redirect()->route('dashboard.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete();

        ActivityLogger::log('DELETE', 'Pengumuman', "Menghapus pengumuman: {$title}");

        return redirect()->route('dashboard.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
