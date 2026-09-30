<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

use App\Models\Category;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $categoryFilter = $request->get('category', 'all');

        $query = Document::latest();
        if ($categoryFilter !== 'all') {
            $variants = [
                $categoryFilter,
                \Illuminate\Support\Str::slug($categoryFilter),
                str_replace('-', '_', \Illuminate\Support\Str::slug($categoryFilter)),
                str_replace('dokumen-', '', $categoryFilter),
                str_replace('-', '_', str_replace('dokumen-', '', $categoryFilter)),
            ];

            $catObj = Category::where('module', 'dokumen')
                ->where(function ($c) use ($categoryFilter, $variants) {
                    $c->whereIn('slug', $variants)->orWhereIn('name', $variants);
                })->first();

            if ($catObj) {
                $variants[] = $catObj->slug;
                $variants[] = $catObj->name;
                $variants[] = \Illuminate\Support\Str::slug($catObj->name);
                $variants[] = str_replace('-', '_', \Illuminate\Support\Str::slug($catObj->name));
                $variants[] = str_replace('dokumen-', '', $catObj->slug);
                $variants[] = str_replace('-', '_', str_replace('dokumen-', '', $catObj->slug));
            }

            $variants = array_values(array_unique(array_filter($variants)));
            $query->whereIn('category', $variants);
        }
        $documents = $query->get();

        $categories = Category::where('module', 'dokumen')
            ->where('status', 'aktif')
            ->orderBy('order', 'asc')
            ->get();

        return view('dashboard.documents.index', compact('documents', 'categoryFilter', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'organization' => 'nullable|string|max:100',
            'document_file' => 'required_without:file_url|nullable|file|mimes:pdf|max:10240',
            'file_url' => ['required_without:document_file', 'nullable', 'url', 'regex:/\.pdf($|\?|#)/i'],
        ], [
            'document_file.required_without' => '🚫 AKSES DITOLAK! Silakan unggah berkas PDF atau isi tautan online PDF.',
            'document_file.mimes' => '🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya berkas Dokumen PDF (.pdf) yang diperbolehkan.',
            'document_file.max' => '🚫 AKSES DITOLAK! Ukuran berkas maksimal adalah 10 MB.',
            'file_url.required_without' => '🚫 AKSES DITOLAK! Silakan unggah berkas PDF atau isi tautan online PDF.',
            'file_url.url' => '🚫 AKSES DITOLAK! Format tautan URL tidak valid.',
            'file_url.regex' => '🚫 AKSES DITOLAK! Tautan URL online harus mengarah ke berkas PDF (berakhiran .pdf).',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = number_format($file->getSize() / 1048576, 1) . ' MB';
            $filePath = $file->store('documents', 'public');
        } else {
            $filePath = trim($request->file_url);
            $fileName = basename(parse_url($filePath, PHP_URL_PATH) ?? 'Dokumen.pdf');
            $fileSize = 'PDF Link';
        }

        $document = Document::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'published_date' => $request->published_date ?? date('Y-m-d'),
            'status' => 'Disahkan',
            'organization' => $request->organization,
        ]);

        ActivityLogger::log('CREATE', 'Dokumen PDF', "Mengunggah dokumen PDF baru: {$document->title}", [
            'document_id' => $document->id
        ]);

        return redirect()->route('dashboard.documents.index')->with('success', 'Dokumen PDF berhasil diunggah.');
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'organization' => 'nullable|string|max:100',
            'document_file' => 'nullable|file|mimes:pdf|max:10240',
            'file_url' => ['nullable', 'url', 'regex:/\.pdf($|\?|#)/i'],
        ], [
            'document_file.mimes' => '🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya berkas Dokumen PDF (.pdf) yang diperbolehkan.',
            'document_file.max' => '🚫 AKSES DITOLAK! Ukuran berkas maksimal adalah 10 MB.',
            'file_url.url' => '🚫 AKSES DITOLAK! Format tautan URL tidak valid.',
            'file_url.regex' => '🚫 AKSES DITOLAK! Tautan URL online harus mengarah ke berkas PDF (berakhiran .pdf).',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = number_format($file->getSize() / 1048576, 1) . ' MB';
            $filePath = $file->store('documents', 'public');

            $document->file_path = $filePath;
            $document->file_name = $fileName;
            $document->file_size = $fileSize;
        } elseif ($request->filled('file_url')) {
            $filePath = trim($request->file_url);
            $fileName = basename(parse_url($filePath, PHP_URL_PATH) ?? 'Dokumen.pdf');
            $fileSize = 'PDF Link';

            $document->file_path = $filePath;
            $document->file_name = $fileName;
            $document->file_size = $fileSize;
        }

        $document->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'published_date' => $request->published_date ?? $document->published_date,
            'organization' => $request->organization,
        ]);

        ActivityLogger::log('UPDATE', 'Dokumen PDF', "Memperbarui dokumen PDF: {$document->title}", [
            'document_id' => $document->id
        ]);

        return redirect()->route('dashboard.documents.index')->with('success', 'Dokumen PDF berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        $title = $document->title;
        
        // Hapus model data (Otomatis memicu event model deleting & pembersihan file fisik di storage)
        $document->delete();

        ActivityLogger::log('DELETE', 'Dokumen PDF', "Menghapus dokumen PDF: {$title}");

        return redirect()->route('dashboard.documents.index')->with('success', 'Dokumen PDF berhasil dihapus.');
    }

    public function download(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        if (filter_var($document->file_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($document->file_path);
        }

        return redirect()->back()->with('error', 'Berkas PDF tidak ditemukan di server.');
    }
}
