<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicServiceController extends Controller
{
    /**
     * Display a listing of all SOP & Standar Pelayanan documents.
     */
    public function index()
    {
        $services = Service::with('kategoriLayanan')->where('is_active', true)->orderBy('order')->orderBy('id', 'asc')->get();
        $categories = KategoriLayanan::withCount(['services' => function($q) {
            $q->where('is_active', true);
        }])->orderBy('nama_kategori')->get();

        return view('services.index', compact('services', 'categories'));
    }

    /**
     * Display a specific SOP document viewer.
     */
    public function show($slug)
    {
        $service = Service::with('kategoriLayanan')->where('slug', $slug)->where('is_active', true)->firstOrFail();
        $allServices = Service::with('kategoriLayanan')->where('is_active', true)->orderBy('order')->orderBy('id', 'asc')->get();
        $categories = KategoriLayanan::withCount(['services' => function($q) {
            $q->where('is_active', true);
        }])->orderBy('nama_kategori')->get();

        return view('services.show', compact('service', 'allServices', 'categories'));
    }

    /**
     * Download the SOP document PDF file.
     */
    public function download($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();

        if ($service->file_path && Storage::disk('public')->exists($service->file_path)) {
            $filename = Str::slug($service->title) . '.pdf';
            return Storage::disk('public')->download($service->file_path, $filename);
        }

        return redirect()->route('services.show', $service->slug)->with('error', 'Dokumen PDF untuk layanan ini belum tersedia untuk diunduh.');
    }
}
