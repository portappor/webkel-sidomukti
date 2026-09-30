<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class ServiceController extends Controller
{
    /**
     * Display a listing of SOP / Standar Pelayanan documents in admin.
     */
    public function index()
    {
        $services = Service::with('kategoriLayanan')->orderBy('id', 'asc')->get();
        $kategoriLayanan = KategoriLayanan::orderBy('nama_kategori')->get();
        return view('dashboard.services.index', compact('services', 'kategoriLayanan'));
    }

    /**
     * Show the form for creating a new SOP document.
     */
    public function create()
    {
        $kategoriLayanan = KategoriLayanan::orderBy('nama_kategori')->get();
        return view('dashboard.services.create', compact('kategoriLayanan'));
    }

    /**
     * Store a newly created SOP document in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'kategori_layanan_id' => 'nullable|exists:kategori_layanan,id',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'operating_days' => 'nullable|string|max:255',
            'operating_hours' => 'nullable|string|max:255',
            'processing_time' => 'nullable|string|max:255',
            'cost' => 'nullable|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul SOP / Layanan wajib diisi.',
            'kategori_layanan_id.exists' => 'Kategori layanan yang dipilih tidak valid.',
            'pdf_file.mimes' => '🚫 Akses Ditolak! File dokumen harus berformat PDF (.pdf).',
            'pdf_file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $count = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $filePath = null;
        if ($request->hasFile('pdf_file')) {
            $filePath = $request->file('pdf_file')->store('sop_documents', 'public');
        }

        // Format operating hours string from days + hours input if provided
        $operatingDays = $request->operating_days;
        $operatingHoursInput = $request->operating_hours;
        if ($operatingDays && $operatingHoursInput) {
            if (str_contains($operatingHoursInput, $operatingDays)) {
                $operatingHours = $operatingHoursInput;
            } else {
                $operatingHours = $operatingDays . ' (' . $operatingHoursInput . ')';
            }
        } else {
            $operatingHours = $operatingHoursInput ?: ($operatingDays ?: 'Senin - Jumat');
        }

        $service = Service::create([
            'title' => $request->title,
            'kategori_layanan_id' => $request->kategori_layanan_id,
            'slug' => $slug,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'operating_hours' => $operatingHours,
            'processing_time' => $request->processing_time ?: 'Tergantung Layanan',
            'cost' => $request->cost ?: 'GRATIS',
            'file_path' => $filePath,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        ActivityLogger::log('CREATE', 'Layanan', "Menambahkan Standar Layanan/SOP baru: {$service->title}", [
            'service_id' => $service->id
        ]);

        return redirect()->route('dashboard.services.index')->with('success', 'Dokumen Standar Pelayanan / SOP berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified SOP document.
     */
    public function edit(Service $service)
    {
        $kategoriLayanan = KategoriLayanan::orderBy('nama_kategori')->get();
        return view('dashboard.services.edit', compact('service', 'kategoriLayanan'));
    }

    /**
     * Update the specified SOP document in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'kategori_layanan_id' => 'nullable|exists:kategori_layanan,id',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'operating_days' => 'nullable|string|max:255',
            'operating_hours' => 'nullable|string|max:255',
            'processing_time' => 'nullable|string|max:255',
            'cost' => 'nullable|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul SOP / Layanan wajib diisi.',
            'kategori_layanan_id.exists' => 'Kategori layanan yang dipilih tidak valid.',
            'pdf_file.mimes' => '🚫 Akses Ditolak! File dokumen harus berformat PDF (.pdf).',
            'pdf_file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $count = 1;
        while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        $filePath = $service->file_path;
        if ($request->hasFile('pdf_file')) {
            $filePath = $request->file('pdf_file')->store('sop_documents', 'public');
        }

        // Format operating hours string from days + hours input if provided
        $operatingDays = $request->operating_days;
        $operatingHoursInput = $request->operating_hours;
        if ($operatingDays && $operatingHoursInput) {
            if (str_contains($operatingHoursInput, $operatingDays)) {
                $operatingHours = $operatingHoursInput;
            } else {
                $operatingHours = $operatingDays . ' (' . $operatingHoursInput . ')';
            }
        } else {
            $operatingHours = $operatingHoursInput ?: ($operatingDays ?: 'Senin - Jumat');
        }

        $service->update([
            'title' => $request->title,
            'kategori_layanan_id' => $request->kategori_layanan_id,
            'slug' => $slug,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'operating_hours' => $operatingHours,
            'processing_time' => $request->processing_time ?: 'Tergantung Layanan',
            'cost' => $request->cost ?: 'GRATIS',
            'file_path' => $filePath,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        ActivityLogger::log('UPDATE', 'Layanan', "Mengubah Standar Layanan/SOP: {$service->title}", [
            'service_id' => $service->id
        ]);

        return redirect()->route('dashboard.services.index')->with('success', 'Dokumen Standar Pelayanan / SOP berhasil diperbarui.');
    }

    /**
     * Remove the specified SOP document from storage.
     */
    public function destroy(Service $service)
    {
        $title = $service->title;
        
        // Hapus model data (Otomatis memicu event model deleting & pembersihan file fisik di storage)
        $service->delete();

        ActivityLogger::log('DELETE', 'Layanan', "Menghapus Standar Layanan/SOP: {$title}");

        return redirect()->route('dashboard.services.index')->with('success', 'Dokumen Standar Pelayanan / SOP berhasil dihapus.');
    }
}
