<?php

namespace App\Http\Controllers;

use App\Models\KategoriLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class KategoriLayananController extends Controller
{
    /**
     * Store a newly created category via AJAX quick-store method.
     * Endpoint: POST /admin/master-kategori/quick-store
     * Responds with JSON: { id, nama_kategori }
     */
    public function quickStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_layanan,nama_kategori',
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
        ]);

        $baseSlug = Str::slug($request->nama_kategori);
        $slug = $baseSlug;
        $count = 1;
        while (KategoriLayanan::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $kategori = KategoriLayanan::create([
            'nama_kategori' => trim($request->nama_kategori),
            'slug' => $slug,
            'deskripsi' => $request->deskripsi,
        ]);

        ActivityLogger::log('CREATE', 'Kategori Layanan', "Menambahkan kategori layanan baru: {$kategori->nama_kategori}", [
            'kategori_layanan_id' => $kategori->id
        ]);

        return response()->json([
            'id' => $kategori->id,
            'nama_kategori' => $kategori->nama_kategori,
            'slug' => $kategori->slug,
        ], 201);
    }
}
