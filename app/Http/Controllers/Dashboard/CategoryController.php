<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $modules = Category::getModules();
        $selectedModule = $request->query('module', 'all');

        $query = Category::query();
        if ($selectedModule !== 'all' && array_key_exists($selectedModule, $modules)) {
            $query->where('module', $selectedModule);
        }

        $categories = $query->orderBy('module', 'asc')
                            ->orderBy('order', 'asc')
                            ->orderBy('name', 'asc')
                            ->get();

        // Module counts
        $allCount = Category::count();
        $moduleCounts = [];
        foreach ($modules as $modKey => $modName) {
            $moduleCounts[$modKey] = Category::where('module', $modKey)->count();
        }

        return view('dashboard.categories.index', compact(
            'categories',
            'modules',
            'selectedModule',
            'allCount',
            'moduleCounts'
        ));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|in:dokumen,berita,galeri,video,layanan',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|in:emerald,blue,rose,amber,purple,indigo,cyan',
            'order' => 'required|integer|min:1',
            'status' => 'required|string|in:aktif,nonaktif',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'module.required' => 'Modul kategori wajib dipilih.',
            'color.required' => 'Warna penanda wajib dipilih.',
            'order.required' => 'Urutan wajib diisi.',
        ]);

        $baseSlug = Str::slug($request->name);
        if (!in_array($request->module, ['berita', 'layanan'])) {
            $baseSlug = Str::slug($request->module . '-' . $request->name);
        }

        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'module' => $request->module,
            'description' => $request->description,
            'color' => $request->color,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        // Sync with KategoriLayanan if module is layanan
        if ($category->module === 'layanan') {
            KategoriLayanan::updateOrCreate(
                ['slug' => $category->slug],
                [
                    'nama_kategori' => $category->name,
                    'deskripsi' => $category->description,
                ]
            );
        }

        ActivityLogger::log('CREATE', 'Kategori', "Menambahkan kategori ({$category->module}): {$category->name}", [
            'category_id' => $category->id
        ]);

        return redirect()->route('dashboard.categories.index', ['module' => $request->module])
            ->with('success', "Kategori baru untuk modul {$category->module_label} berhasil ditambahkan.");
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module' => 'required|string|in:dokumen,berita,galeri,video,layanan',
            'description' => 'nullable|string|max:500',
            'color' => 'required|string|in:emerald,blue,rose,amber,purple,indigo,cyan',
            'order' => 'required|integer|min:1',
            'status' => 'required|string|in:aktif,nonaktif',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'module.required' => 'Modul kategori wajib dipilih.',
            'color.required' => 'Warna penanda wajib dipilih.',
            'order.required' => 'Urutan wajib diisi.',
        ]);

        $oldSlug = $category->slug;

        $category->update([
            'name' => $request->name,
            'module' => $request->module,
            'description' => $request->description,
            'color' => $request->color,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        // Sync with KategoriLayanan if module is layanan
        if ($category->module === 'layanan') {
            KategoriLayanan::updateOrCreate(
                ['slug' => $category->slug],
                [
                    'nama_kategori' => $category->name,
                    'deskripsi' => $category->description,
                ]
            );
        }

        ActivityLogger::log('UPDATE', 'Kategori', "Mengubah kategori ({$category->module}): {$category->name}", [
            'category_id' => $category->id
        ]);

        return redirect()->route('dashboard.categories.index', ['module' => $request->module])
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->isInUse()) {
            return redirect()->route('dashboard.categories.index', ['module' => $category->module])
                ->with('error', 'Kategori tidak dapat dihapus karena sedang digunakan oleh data lain.');
        }

        $name = $category->name;
        $mod = $category->module;
        $slug = $category->slug;

        $category->delete();

        if ($mod === 'layanan') {
            KategoriLayanan::where('slug', $slug)->delete();
        }

        ActivityLogger::log('DELETE', 'Kategori', "Menghapus kategori: {$name}");

        return redirect()->route('dashboard.categories.index', ['module' => $mod])
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
