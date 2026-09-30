<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apbd;
use App\Models\ApbdItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogger;

class ApbdAdminController extends Controller
{
    public function index(Request $request)
    {
        $apbds = Apbd::orderBy('year', 'desc')->get();
        return view('dashboard.apbd.index', compact('apbds'));
    }

    public function create()
    {
        $categories = Category::where('module', 'APBD')->orderBy('order')->get();
        return view('dashboard.apbd.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'document' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('apbd_thumbnails', 'public');
            }

            $documentPath = null;
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('apbd_documents', 'public');
            }

            $apbd = Apbd::create([
                'title' => $request->title,
                'year' => $request->year,
                'date' => $request->date,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath,
                'document' => $documentPath,
                'is_published' => $request->has('is_published') ? true : false,
            ]);

            $this->saveItems($apbd, $request->items ?? []);

            DB::commit();

            ActivityLogger::log('CREATE', 'APBD Kelurahan', "Menambahkan data APBD Tahun {$apbd->year}");

            return redirect()->route('dashboard.apbd.index')->with('success', 'Data APBD berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $apbd = Apbd::with('items')->findOrFail($id);
        $categories = Category::where('module', 'APBD')->orderBy('order')->get();
        return view('dashboard.apbd.form', compact('apbd', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'document' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $apbd = Apbd::findOrFail($id);

        try {
            DB::beginTransaction();

            $thumbnailPath = $apbd->thumbnail;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('apbd_thumbnails', 'public');
            }

            $documentPath = $apbd->document;
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('apbd_documents', 'public');
            }

            $apbd->update([
                'title' => $request->title,
                'year' => $request->year,
                'date' => $request->date,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath,
                'document' => $documentPath,
                'is_published' => $request->has('is_published') ? true : false,
            ]);

            $apbd->items()->delete();
            $this->saveItems($apbd, $request->items ?? []);

            DB::commit();

            ActivityLogger::log('UPDATE', 'APBD Kelurahan', "Mengubah data APBD Tahun {$apbd->year}");

            return redirect()->route('dashboard.apbd.index')->with('success', 'Data APBD berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $apbd = Apbd::findOrFail($id);
        $year = $apbd->year;
        $apbd->delete();

        ActivityLogger::log('DELETE', 'APBD Kelurahan', "Menghapus data APBD Tahun {$year}");

        return redirect()->route('dashboard.apbd.index')->with('success', 'Data APBD berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $apbd = Apbd::findOrFail($id);
        $apbd->is_published = !$apbd->is_published;
        $apbd->save();

        $status = $apbd->is_published ? 'dipublikasikan' : 'disembunyikan';
        ActivityLogger::log('UPDATE', 'APBD Kelurahan', "Mengubah status publikasi APBD Tahun {$apbd->year} menjadi {$status}");

        return redirect()->back()->with('success', "Status publikasi APBD berhasil diubah.");
    }

    private function saveItems(Apbd $apbd, array $items)
    {
        foreach ($items as $item) {
            if (empty($item['uraian'])) continue;

            $anggaran = $this->parseCurrency($item['anggaran'] ?? 0);
            $realisasi = $this->parseCurrency($item['realisasi'] ?? 0);

            $apbd->items()->create([
                'jenis' => $item['jenis'] ?? 'pendapatan',
                'kategori' => $item['kategori'] ?? null,
                'uraian' => $item['uraian'],
                'anggaran' => $anggaran,
                'realisasi' => $realisasi,
            ]);
        }
    }

    private function parseCurrency($value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        $clean = preg_replace('/[^0-9]/', '', (string) $value);
        return (float) ($clean ?: 0);
    }
}
