<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::withCount('photos')->latest()->paginate(12);
        return view('dashboard.galleries.index', compact('albums'));
    }

    public function create()
    {
        return view('dashboard.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|required_without:cover_image_url|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cover_image_url' => 'nullable|required_without:cover_image|url',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'photo_urls' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('albums/covers', 'public');
        } else {
            $coverPath = trim($request->cover_image_url);
        }

        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $count = 1;
        while (Album::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        $album = Album::create([
            'title' => $request->title,
            'slug' => $slug,
            'category' => $request->category,
            'description' => $request->description,
            'cover_image' => $coverPath,
            'event_date' => $request->event_date,
        ]);

        // Process uploaded multi-file photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile->isValid()) {
                    $path = $photoFile->store('albums/photos', 'public');
                    AlbumPhoto::create([
                        'album_id' => $album->id,
                        'image_path' => $path,
                    ]);
                }
            }
        }

        // Process URL photos (one per line)
        if ($request->filled('photo_urls')) {
            $urls = array_map('trim', explode("\n", $request->photo_urls));
            foreach ($urls as $url) {
                if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                    AlbumPhoto::create([
                        'album_id' => $album->id,
                        'image_path' => $url,
                    ]);
                }
            }
        }

        // Also add cover image as first photo if album has no interior photos yet
        if ($album->photos()->count() === 0) {
            AlbumPhoto::create([
                'album_id' => $album->id,
                'image_path' => $coverPath,
            ]);
        }

        ActivityLogger::log('CREATE', 'Galeri', "Membuat album foto baru: {$album->title}", [
            'album_id' => $album->id
        ]);

        return redirect()->route('dashboard.galleries.index')->with('success', 'Album foto berhasil dibuat.');
    }

    public function edit($id)
    {
        $album = Album::with('photos')->findOrFail($id);
        return view('dashboard.galleries.edit', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cover_image_url' => 'nullable|url',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'photo_urls' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('albums/covers', 'public');
            $album->cover_image = $coverPath;
        } elseif ($request->filled('cover_image_url')) {
            $album->cover_image = trim($request->cover_image_url);
        }

        $album->title = $request->title;
        $album->category = $request->category;
        $album->event_date = $request->event_date;
        $album->description = $request->description;
        $album->save();

        // Process newly uploaded photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile->isValid()) {
                    $path = $photoFile->store('albums/photos', 'public');
                    AlbumPhoto::create([
                        'album_id' => $album->id,
                        'image_path' => $path,
                    ]);
                }
            }
        }

        // Process additional URL photos
        if ($request->filled('photo_urls')) {
            $urls = array_map('trim', explode("\n", $request->photo_urls));
            foreach ($urls as $url) {
                if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                    AlbumPhoto::create([
                        'album_id' => $album->id,
                        'image_path' => $url,
                    ]);
                }
            }
        }

        ActivityLogger::log('UPDATE', 'Galeri', "Perubahan album foto: {$album->title}", [
            'album_id' => $album->id
        ]);

        return redirect()->route('dashboard.galleries.index')->with('success', 'Album foto berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $album = Album::with('photos')->findOrFail($id);
        $title = $album->title;

        // Delete cover image file if stored locally
        if ($album->cover_image && Storage::disk('public')->exists($album->cover_image)) {
            Storage::disk('public')->delete($album->cover_image);
        }

        // Delete all photo files stored locally
        foreach ($album->photos as $photo) {
            if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }
        }

        $album->delete();

        ActivityLogger::log('DELETE', 'Galeri', "Menghapus album foto: {$title}");

        return redirect()->route('dashboard.galleries.index')->with('success', 'Album foto berhasil dihapus.');
    }

    public function destroyPhoto($id)
    {
        $photo = AlbumPhoto::findOrFail($id);
        $albumId = $photo->album_id;

        if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari album.');
    }
}
