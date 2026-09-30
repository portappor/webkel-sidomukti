<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class NavigationMenuController extends Controller
{
    /**
     * Display a listing of navigation menus.
     */
    public function index()
    {
        // Auto seed default menus if navigation_menus is empty
        if (NavigationMenu::count() === 0) {
            $this->seedDefaultMenus();
        }

        $menus = NavigationMenu::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->orderBy('order', 'asc');
            }])
            ->orderBy('order', 'asc')
            ->get();

        $allParentMenus = $menus;

        $services = \App\Models\Service::where('is_active', true)->orderBy('order', 'asc')->get();
        $docCategories = \App\Models\Category::where('module', 'dokumen')->where('status', 'aktif')->orderBy('order', 'asc')->get();
        $kategoriLayanan = \App\Models\KategoriLayanan::orderBy('nama_kategori')->get();

        return view('dashboard.navigation.index', compact('menus', 'allParentMenus', 'services', 'docCategories', 'kategoriLayanan'));
    }

    /**
     * Store a newly created navigation menu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:navigation_menus,id',
            'target' => 'nullable|in:_self,_blank',
            'is_active' => 'boolean',
            'show_on_homepage' => 'boolean',
            'description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
        ], [
            'image.file' => '🚫 AKSES DITOLAK! Berkas yang diunggah harus berupa FOTO / GAMBAR.',
            'image.mimes' => '🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya berkas Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
            'image.max' => '🚫 AKSES DITOLAK! Ukuran berkas gambar maksimal adalah 5 MB.',
        ]);

        $parentId = $request->filled('parent_id') ? (int) $request->parent_id : null;

        if ($parentId) {
            $parent = NavigationMenu::find($parentId);
            if (!$parent || !is_null($parent->parent_id)) {
                return redirect()->back()->withErrors(['parent_id' => 'Sub-menu hanya dapat ditambahkan pada menu utama.'])->withInput();
            }
        }
        
        // Auto-increment order
        $maxOrder = NavigationMenu::where('parent_id', $parentId)->max('order') ?? 0;
        $order = $maxOrder + 1;

        $url = $request->filled('url') ? $request->url : null;
        if (empty($url)) {
            $slug = \Illuminate\Support\Str::slug($request->title);
            if ($parentId) {
                $parent = NavigationMenu::find($parentId);
                $parentPrefix = ($parent && $parent->url && $parent->url !== '#' && str_starts_with($parent->url, '/'))
                    ? rtrim($parent->url, '/')
                    : ($parent ? '/' . \Illuminate\Support\Str::slug($parent->title) : '');
                $url = $parentPrefix ? "{$parentPrefix}/{$slug}" : "/{$slug}";
            } else {
                $url = "/{$slug}";
            }
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('navigation', 'public');
        }

        $menu = NavigationMenu::create([
            'title' => $request->title,
            'url' => $url,
            'parent_id' => $parentId,
            'order' => $order,
            'target' => $request->target ?? '_self',
            'is_active' => $request->has('is_active') ? true : false,
            'show_on_homepage' => $request->has('show_on_homepage') ? true : false,
            'description' => $request->description,
            'content' => $request->content,
            'icon' => $request->icon,
            'image' => $imagePath,
        ]);

        ActivityLogger::log('CREATE', 'Navigasi', "Menambahkan menu navigasi baru: {$menu->title}", [
            'menu_id' => $menu->id
        ]);

        return redirect()->route('dashboard.navigation.index')->with('success', 'Menu navigasi berhasil ditambahkan.');
    }

    /**
     * Update the specified navigation menu.
     */
    public function update(Request $request, $id)
    {
        $menu = NavigationMenu::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:navigation_menus,id',
            'target' => 'nullable|in:_self,_blank',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'show_on_homepage' => 'boolean',
            'description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
        ], [
            'image.file' => '🚫 AKSES DITOLAK! Berkas yang diunggah harus berupa FOTO / GAMBAR.',
            'image.mimes' => '🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya berkas Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
            'image.max' => '🚫 AKSES DITOLAK! Ukuran berkas gambar maksimal adalah 5 MB.',
        ]);

        $parentId = $request->filled('parent_id') ? (int) $request->parent_id : null;

        // Prevent infinite loop (cannot set self as parent)
        if ($parentId && $parentId === (int) $menu->id) {
            return redirect()->back()->withErrors(['parent_id' => 'Menu tidak boleh memilih dirinya sendiri sebagai parent.'])->withInput();
        }

        // Prevent setting a child as parent
        if ($parentId) {
            $childIds = $menu->children()->pluck('id')->toArray();
            if (in_array($parentId, $childIds)) {
                return redirect()->back()->withErrors(['parent_id' => 'Menu tidak boleh memilih sub-menunya sendiri sebagai parent.'])->withInput();
            }

            $parent = NavigationMenu::find($parentId);
            if (!$parent || !is_null($parent->parent_id)) {
                return redirect()->back()->withErrors(['parent_id' => 'Sub-menu hanya dapat ditambahkan pada menu utama.'])->withInput();
            }
        }

        $url = $request->filled('url') ? $request->url : null;
        if (empty($url)) {
            $slug = \Illuminate\Support\Str::slug($request->title);
            if ($parentId) {
                $parent = NavigationMenu::find($parentId);
                $parentPrefix = ($parent && $parent->url && $parent->url !== '#' && str_starts_with($parent->url, '/'))
                    ? rtrim($parent->url, '/')
                    : ($parent ? '/' . \Illuminate\Support\Str::slug($parent->title) : '');
                $url = $parentPrefix ? "{$parentPrefix}/{$slug}" : "/{$slug}";
            } else {
                $url = "/{$slug}";
            }
        }

        $imagePath = $menu->image;
        if ($request->hasFile('image')) {
            if ($menu->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
            }
            $imagePath = $request->file('image')->store('navigation', 'public');
        } elseif ($request->has('remove_image') && $request->remove_image == '1') {
            if ($menu->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
            }
            $imagePath = null;
        }

        $menu->update([
            'title' => $request->title,
            'url' => $url,
            'parent_id' => $parentId,
            'order' => $request->filled('order') ? (int) $request->order : $menu->order,
            'target' => $request->target ?? '_self',
            'is_active' => $request->has('is_active') ? true : false,
            'show_on_homepage' => $request->has('show_on_homepage') ? true : false,
            'description' => $request->description,
            'content' => $request->content,
            'icon' => $request->icon,
            'image' => $imagePath,
        ]);

        ActivityLogger::log('UPDATE', 'Navigasi', "Mengubah menu navigasi: {$menu->title}", [
            'menu_id' => $menu->id
        ]);

        return redirect()->route('dashboard.navigation.index')->with('success', 'Menu navigasi berhasil diperbarui.');
    }

    /**
     * Toggle status active of navigation menu.
     */
    public function toggleActive($id)
    {
        $menu = NavigationMenu::findOrFail($id);
        $menu->is_active = !$menu->is_active;
        $menu->save();

        $statusStr = $menu->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLogger::log('UPDATE', 'Navigasi', "Menu navigasi {$menu->title} {$statusStr}", [
            'menu_id' => $menu->id
        ]);

        return redirect()->route('dashboard.navigation.index')->with('success', "Status menu '{$menu->title}' berhasil {$statusStr}.");
    }

    /**
     * Remove the specified navigation menu.
     */
    public function destroy($id)
    {
        $menu = NavigationMenu::findOrFail($id);

        $defaultParentTitles = ['home', 'profil', 'profil kelurahan', 'layanan', 'layanan publik', 'dokumen', 'dokumen publik', 'informasi', 'hubungi'];
        $titleLower = strtolower(trim($menu->title));

        if (is_null($menu->parent_id) && in_array($titleLower, $defaultParentTitles)) {
            return redirect()->back()->withErrors(['error' => 'Menu utama sistem tidak dapat dihapus.']);
        }

        if ($menu->children()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Menu yang memiliki sub-menu tidak dapat dihapus. Hapus sub-menu terlebih dahulu.']);
        }

        if ($menu->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
        }

        $title = $menu->title;
        $menu->delete();

        return redirect()->route('dashboard.navigation.index')->with('success', "Menu navigasi '{$title}' berhasil dihapus.");
    }

    /**
     * Seed default navigation menus.
     */
    private function seedDefaultMenus()
    {
        $defaults = [
            [
                'title' => 'Home',
                'url' => '/',
                'order' => 1,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Profil',
                'url' => '#',
                'order' => 2,
                'target' => '_self',
                'is_active' => true,
                'children' => [
                    ['title' => 'Visi & Misi', 'url' => '/profil/visi-misi', 'order' => 1, 'target' => '_self', 'is_active' => true, 'show_on_homepage' => true, 'description' => 'Arah kebijakan strategis dan sasaran prioritas pembangunan Kelurahan Sidomukti.'],
                    ['title' => 'Struktur Organisasi', 'url' => '/profil/struktur-organisasi', 'order' => 2, 'target' => '_self', 'is_active' => true, 'show_on_homepage' => true, 'description' => 'Bagan susunan organisasi dan aparatur pemerintahan Kelurahan Sidomukti.'],
                    ['title' => 'Sejarah Kelurahan', 'url' => '/profil/sejarah', 'order' => 3, 'target' => '_self', 'is_active' => true, 'show_on_homepage' => true, 'description' => 'Naskah histori, sejarah berdiri, serta rekam jejak Kelurahan Sidomukti.'],
                ]
            ],
            [
                'title' => 'Layanan',
                'url' => '/layanan',
                'order' => 3,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Dokumen',
                'url' => '/dokumen',
                'order' => 4,
                'target' => '_self',
                'is_active' => true,
            ],
            [
                'title' => 'Informasi',
                'url' => '#',
                'order' => 5,
                'target' => '_self',
                'is_active' => true,
                'children' => [
                    ['title' => 'Berita', 'url' => '/berita', 'order' => 1, 'target' => '_self', 'is_active' => true],
                    ['title' => 'Galeri Album Foto', 'url' => '/galeri', 'order' => 2, 'target' => '_self', 'is_active' => true],
                    ['title' => 'Video Dokumentasi', 'url' => '/video', 'order' => 3, 'target' => '_self', 'is_active' => true],
                    ['title' => 'Agenda Kegiatan', 'url' => '/agenda', 'order' => 4, 'target' => '_self', 'is_active' => true],
                    ['title' => 'Lembaga Kemasyarakatan', 'url' => '/lembaga', 'order' => 5, 'target' => '_self', 'is_active' => true],
                    ['title' => 'Transparansi APBD', 'url' => '/informasi/apbd', 'order' => 6, 'target' => '_self', 'is_active' => true],
                    ['title' => 'Statistik & Monografi', 'url' => '/profil/demografi', 'order' => 7, 'target' => '_self', 'is_active' => true],
                ]
            ],
            [
                'title' => 'Hubungi',
                'url' => '#',
                'order' => 6,
                'target' => '_self',
                'is_active' => true,
                'children' => [
                    ['title' => 'Lapor SP4N', 'url' => 'https://www.lapor.go.id', 'order' => 1, 'target' => '_blank', 'is_active' => true],
                    ['title' => 'Hallo SAE', 'url' => 'https://wa.me/6282131001001', 'order' => 2, 'target' => '_blank', 'is_active' => true],
                    ['title' => 'Kontak Kami', 'url' => '/hubungi', 'order' => 3, 'target' => '_self', 'is_active' => true],
                ]
            ],
        ];

        foreach ($defaults as $item) {
            $children = $item['children'] ?? [];
            unset($item['children']);

            $parent = NavigationMenu::create($item);

            foreach ($children as $child) {
                $child['parent_id'] = $parent->id;
                NavigationMenu::create($child);
            }
        }
    }
}
