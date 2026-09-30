<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function visiMisi()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('profil.visi-misi', compact('settings'));
    }

    public function tugasFungsi()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('profil.tugas-fungsi', compact('settings'));
    }

    public function struktur()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('profil.struktur', compact('settings'));
    }

    public function sejarah()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('profil.sejarah', compact('settings'));
    }

    public function demografi()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $rukunWargas = \App\Models\RukunWarga::orderBy('nama_rw')->get();
        return view('profil.demografi', compact('settings', 'rukunWargas'));
    }

    /**
     * Display a dynamic navigation page content.
     */
    public function showDynamicPage(Request $request, $slug)
    {
        $path = '/' . ltrim($request->path(), '/');

        // Find active NavigationMenu by exact URL or matching path
        $menu = \App\Models\NavigationMenu::where('is_active', true)
            ->where(function ($q) use ($path, $slug) {
                $q->where('url', $path)
                  ->orWhere('url', '/' . $slug)
                  ->orWhere('url', 'LIKE', '%/' . $slug);
            })
            ->first();

        if (!$menu) {
            // Fallback: search by title slug
            $allMenus = \App\Models\NavigationMenu::where('is_active', true)->get();
            foreach ($allMenus as $m) {
                if (\Illuminate\Support\Str::slug($m->title) === $slug) {
                    $menu = $m;
                    break;
                }
            }
        }

        if (!$menu) {
            abort(404);
        }

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        return view('profil.dynamic', compact('menu', 'settings'));
    }
}
