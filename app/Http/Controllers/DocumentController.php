<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    private function getAvailableYears()
    {
        $years = Document::selectRaw('YEAR(published_date) as yr')
            ->whereNotNull('published_date')
            ->pluck('yr')
            ->concat(
                Document::selectRaw('YEAR(created_at) as yr')->pluck('yr')
            )
            ->filter()
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        if (empty($years)) {
            $years = [2026, 2025, 2024];
        }

        return $years;
    }

    private function buildDocumentQuery(Request $request, array $categoryVariants = [])
    {
        $query = Document::latest('published_date')->latest('created_at');

        if (!empty($categoryVariants)) {
            $query->whereIn('category', $categoryVariants);
        } elseif ($request->filled('kategori') && $request->kategori !== 'all') {
            $variants = $this->getCategoryVariants($request->kategori);
            $query->whereIn('category', $variants);
        }

        $selectedYear = $request->get('tahun');
        if ($selectedYear && $selectedYear !== 'all') {
            $query->where(function($q) use ($selectedYear) {
                $q->whereYear('published_date', $selectedYear)
                  ->orWhereYear('created_at', $selectedYear);
            });
        }

        $search = $request->get('search', $request->get('q'));
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function index(Request $request, $tahun = null)
    {
        if ($tahun && !$request->has('tahun')) {
            $request->merge(['tahun' => $tahun]);
        }

        $selectedCategory = $request->get('kategori', 'all');
        $selectedYear = $request->get('tahun', 'all');
        $search = $request->get('search', $request->get('q', ''));
        $perPage = (int) $request->get('entries', $request->get('per_page', 10));
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $totalTotal = Document::count();
        $query = $this->buildDocumentQuery($request);
        $documents = $query->paginate($perPage)->withQueryString();

        $categories = Category::where('module', 'dokumen')
            ->where('status', 'aktif')
            ->orderBy('order', 'asc')
            ->get();

        $availableYears = $this->getAvailableYears();
        $pageTitle = 'Dokumen & Arsip Resmi Publik';

        return view('documents.index', compact(
            'documents', 'categories', 'availableYears', 'selectedCategory', 
            'selectedYear', 'search', 'perPage', 'totalTotal', 'pageTitle'
        ));
    }

    public function musrenbang(Request $request, $tahun = null)
    {
        if ($tahun && !$request->has('tahun')) {
            $request->merge(['tahun' => $tahun]);
        }

        $selectedCategory = 'dokumen-musrenbang';
        $selectedYear = $request->get('tahun', 'all');
        $search = $request->get('search', $request->get('q', ''));
        $perPage = (int) $request->get('entries', $request->get('per_page', 10));
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $categoryVariants = ['musrenbang', 'Musrenbang', 'dokumen-musrenbang'];
        $totalTotal = Document::whereIn('category', $categoryVariants)->count();
        $query = $this->buildDocumentQuery($request, $categoryVariants);
        $documents = $query->paginate($perPage)->withQueryString();

        $categories = Category::where('module', 'dokumen')
            ->where('status', 'aktif')
            ->orderBy('order', 'asc')
            ->get();

        $availableYears = $this->getAvailableYears();
        $pageTitle = 'Hasil Musrenbang & Perencanaan Pembangunan';

        return view('documents.musrenbang', compact(
            'documents', 'categories', 'availableYears', 'selectedCategory', 
            'selectedYear', 'search', 'perPage', 'totalTotal', 'pageTitle'
        ));
    }

    public function renstraRenja(Request $request, $tahun = null)
    {
        if ($tahun && !$request->has('tahun')) {
            $request->merge(['tahun' => $tahun]);
        }

        $selectedCategory = 'dokumen-renstra-renja';
        $selectedYear = $request->get('tahun', 'all');
        $search = $request->get('search', $request->get('q', ''));
        $perPage = (int) $request->get('entries', $request->get('per_page', 10));
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $categoryVariants = ['renstra_renja', 'renstra-renja', 'Renstra & Renja', 'dokumen-renstra-renja'];
        $totalTotal = Document::whereIn('category', $categoryVariants)->count();
        $query = $this->buildDocumentQuery($request, $categoryVariants);
        $documents = $query->paginate($perPage)->withQueryString();

        $categories = Category::where('module', 'dokumen')
            ->where('status', 'aktif')
            ->orderBy('order', 'asc')
            ->get();

        $availableYears = $this->getAvailableYears();
        $pageTitle = 'Dokumen Perencanaan Kinerja (Renstra & Renja)';

        return view('documents.renstra_renja', compact(
            'documents', 'categories', 'availableYears', 'selectedCategory', 
            'selectedYear', 'search', 'perPage', 'totalTotal', 'pageTitle'
        ));
    }

    public function skKelembagaan(Request $request, $tahun = null)
    {
        if ($tahun && !$request->has('tahun')) {
            $request->merge(['tahun' => $tahun]);
        }

        $selectedCategory = 'dokumen-sk-kelembagaan';
        $selectedYear = $request->get('tahun', 'all');
        $search = $request->get('search', $request->get('q', ''));
        $perPage = (int) $request->get('entries', $request->get('per_page', 10));
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $categoryVariants = ['sk_kelembagaan', 'sk-kelembagaan', 'SK Kelembagaan', 'dokumen-sk-kelembagaan'];
        $totalTotal = Document::whereIn('category', $categoryVariants)->count();
        $query = $this->buildDocumentQuery($request, $categoryVariants);
        $documents = $query->paginate($perPage)->withQueryString();

        $categories = Category::where('module', 'dokumen')
            ->where('status', 'aktif')
            ->orderBy('order', 'asc')
            ->get();

        $availableYears = $this->getAvailableYears();
        $pageTitle = 'SK Kelembagaan & Legalitas Kelurahan';

        return view('documents.sk_kelembagaan', compact(
            'documents', 'categories', 'availableYears', 'selectedCategory', 
            'selectedYear', 'search', 'perPage', 'totalTotal', 'pageTitle'
        ));
    }

    private function getCategoryVariants($selectedCategory)
    {
        $variants = [
            $selectedCategory,
            Str::slug($selectedCategory),
            str_replace('-', '_', Str::slug($selectedCategory)),
            str_replace('dokumen-', '', $selectedCategory),
            str_replace('-', '_', str_replace('dokumen-', '', $selectedCategory)),
        ];

        $catObj = Category::where('module', 'dokumen')
            ->where(function ($c) use ($selectedCategory, $variants) {
                $c->whereIn('slug', $variants)->orWhereIn('name', $variants);
            })->first();

        if ($catObj) {
            $variants[] = $catObj->slug;
            $variants[] = $catObj->name;
            $variants[] = Str::slug($catObj->name);
            $variants[] = str_replace('-', '_', Str::slug($catObj->name));
            $variants[] = str_replace('dokumen-', '', $catObj->slug);
            $variants[] = str_replace('-', '_', str_replace('dokumen-', '', $catObj->slug));
        }

        return array_values(array_unique(array_filter($variants)));
    }

    /**
     * Preview / Lihat Berkas PDF Public (Inline Viewer)
     */
    public function view(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return response()->file(Storage::disk('public')->path($document->file_path), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . ($document->file_name ?? 'dokumen.pdf') . '"'
            ]);
        }

        if (filter_var($document->file_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($document->file_path);
        }

        return redirect()->back()->with('error', 'Dokumen PDF belum diunggah atau tidak ditemukan.');
    }

    /**
     * Download Berkas PDF Public
     */
    public function download(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        if (filter_var($document->file_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($document->file_path);
        }

        return redirect()->back()->with('error', 'Dokumen PDF belum diunggah atau tidak ditemukan.');
    }
}
