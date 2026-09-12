<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $categoryFilter = $request->get('category', 'all');

        $query = Document::latest();
        if ($categoryFilter !== 'all') {
            $query->where('category', $categoryFilter);
        }

        $documents = $query->paginate(12);

        return view('dashboard.documents.index', compact('documents', 'categoryFilter'));
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
            'file_url' => 'required_without:document_file|nullable|url',
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

    public function destroy(Document $document)
    {
        $title = $document->title;
        
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

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
