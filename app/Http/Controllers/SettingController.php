<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogger;

class SettingController extends Controller
{
    public function profile()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.profile', compact('settings'));
    }

    public function visiMisi()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.visi_misi', compact('settings'));
    }

    public function sejarah()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.sejarah', compact('settings'));
    }

    public function aparatur()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.aparatur', compact('settings'));
    }

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        
        $imageFields = [
            'foto_lurah',
            'kadin_photo',
            'logo_kelurahan',
            'hero_background',
            'foto_sejarah',
            'foto_lpmk',
            'foto_sekretaris',
            'foto_kasi_pemerintahan',
            'foto_kasi_trantib',
            'foto_kasi_kesra',
            'gambar_bagan_struktur',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                $data[$field] = $path;
            } elseif ($request->filled($field . '_url')) {
                $data[$field] = trim($request->input($field . '_url'));
            } else {
                unset($data[$field]);
            }
            unset($data[$field . '_url']);

            // Sync foto_lurah and kadin_photo for compatibility
            if (isset($data[$field])) {
                if ($field === 'kadin_photo') {
                    $data['foto_lurah'] = $data[$field];
                } elseif ($field === 'foto_lurah') {
                    $data['kadin_photo'] = $data[$field];
                }
            }
        }

        // Sync demografi_total and jumlah_penduduk for compatibility
        if (isset($data['demografi_total'])) {
            $data['jumlah_penduduk'] = $data['demografi_total'];
        } elseif (isset($data['jumlah_penduduk'])) {
            $data['demografi_total'] = $data['jumlah_penduduk'];
        }

        $keysUpdated = array_keys($data);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        ActivityLogger::log('UPDATE', 'Pengaturan', "Mengubah pengaturan web/profil kelurahan (" . count($keysUpdated) . " item)", [
            'updated_keys' => array_slice($keysUpdated, 0, 10)
        ]);

        return back()->with('success', 'Pengaturan struktur aparatur & profil berhasil disimpan.');
    }

    public function destroyKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $imageKeys = [
                'foto_lurah', 'kadin_photo', 'logo_kelurahan', 'hero_background',
                'foto_sejarah', 'foto_lpmk', 'foto_sekretaris', 'foto_kasi_pemerintahan',
                'foto_kasi_trantib', 'foto_kasi_kesra', 'gambar_bagan_struktur'
            ];

            if (in_array($key, $imageKeys) && $setting->value && !filter_var($setting->value, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($setting->value);
            }
            $setting->delete();

            // Also delete synced key if foto_lurah / kadin_photo
            if ($key === 'kadin_photo') {
                Setting::where('key', 'foto_lurah')->delete();
            } elseif ($key === 'foto_lurah') {
                Setting::where('key', 'kadin_photo')->delete();
            }

            ActivityLogger::log('DELETE', 'Pengaturan', "Menghapus item pengaturan: {$key}");
        }

        return back()->with('success', 'Data ' . str_replace('_', ' ', $key) . ' berhasil dihapus/dikosongkan.');
    }
}
