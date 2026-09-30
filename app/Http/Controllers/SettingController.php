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
        $user = auth()->user();
        $recentActivities = \App\Models\ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.settings.profile', compact('user', 'recentActivities'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini telah digunakan oleh akun lain.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'current_password.required_with' => 'Kata sandi saat ini wajib diisi jika ingin mengubah kata sandi.',
        ]);

        if ($request->filled('new_password')) {
            if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.'])->withInput();
            }
            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !\Illuminate\Support\Str::startsWith($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        } elseif ($request->filled('avatar_url')) {
            $user->avatar = trim($request->avatar_url);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        ActivityLogger::log('UPDATE', 'Profil Saya', "Memperbarui informasi profil pengguna: {$user->name} ({$user->email})");

        return back()->with('success', 'Profil dan informasi akun Anda berhasil diperbarui.');
    }

    public function visiMisi()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.visi_misi', compact('settings'));
    }

    public function tugasFungsi()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.settings.tugas_fungsi', compact('settings'));
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
        // Sanitize request: clean up empty strings & base64 preview data URLs from inputs
        $input = $request->all();
        array_walk_recursive($input, function (&$val) {
            if (is_string($val)) {
                $trimmed = trim($val);
                if ($trimmed === '' || \Illuminate\Support\Str::startsWith($trimmed, 'data:image')) {
                    $val = null;
                }
            }
        });
        $request->merge($input);

        $request->validate([
            'foto_sejarah' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_sejarah_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'foto_lurah' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_lurah_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'foto_lpmk' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_lpmk_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'foto_sekretaris' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_sekretaris_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'foto_kasi_pemerintahan' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_kasi_pemerintahan_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'foto_kasi_trantib' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_kasi_trantib_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'foto_kasi_kesra' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'foto_kasi_kesra_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'gambar_bagan_struktur' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'gambar_bagan_struktur_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'logo_kelurahan' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'logo_kelurahan_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'login_background' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:10240',
            'login_background_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'kadin_photo' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'kadin_photo_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'hero_background' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:10240',
            'hero_background_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'slides.*.background_file' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:10240',
            'slides.*.background_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'aparatur_tambahan.*.foto_file' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
            'aparatur_tambahan.*.foto_url' => ['nullable', 'string', 'max:500', 'regex:/\.(jpe?g|png|webp|gif|svg)($|\?|#)/i'],
            'qr_code_image' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp,gif|max:5048',
        ], [
            'foto_sejarah.mimes' => '🚫 AKSES DITOLAK! Format berkas foto sejarah tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
            'foto_sejarah_url.regex' => '🚫 AKSES DITOLAK! Tautan URL foto sejarah harus mengarah ke berkas gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg).',
            'foto_lurah.mimes' => '🚫 AKSES DITOLAK! Format berkas foto lurah tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'foto_lurah_url.regex' => '🚫 AKSES DITOLAK! Tautan URL foto lurah harus mengarah ke berkas gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg).',
            'login_background.mimes' => '🚫 AKSES DITOLAK! Format berkas gambar latar login tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'login_background_url.regex' => '🚫 AKSES DITOLAK! Tautan URL gambar latar login harus mengarah ke berkas gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg).',
            'slides.*.background_file.mimes' => '🚫 AKSES DITOLAK! Format gambar slide hero banner tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'slides.*.background_url.regex' => '🚫 AKSES DITOLAK! Tautan URL gambar slide hero banner harus mengarah ke berkas gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg).',
            'aparatur_tambahan.*.foto_file.mimes' => '🚫 AKSES DITOLAK! Format gambar aparatur tambahan tidak diperbolehkan. Hanya Foto/Gambar yang diperbolehkan.',
            'aparatur_tambahan.*.foto_url.regex' => '🚫 AKSES DITOLAK! Tautan URL gambar aparatur tambahan harus mengarah ke berkas gambar.',
            'qr_code_image.mimes' => '🚫 AKSES DITOLAK! Format berkas Kode QR tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
        ]);

        $data = $request->except(['_token', '_method', 'aparatur_tambahan', 'aparatur_tambahan_hapus_semua']);
        
        $imageFields = [
            'foto_lurah',
            'kadin_photo',
            'logo_kelurahan',
            'login_background',
            'hero_background',
            'foto_sejarah',
            'foto_lpmk',
            'foto_sekretaris',
            'foto_kasi_pemerintahan',
            'foto_kasi_trantib',
            'foto_kasi_kesra',
            'gambar_bagan_struktur',
            'qr_code_image',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                $data[$field] = $path;
            } elseif ($request->filled($field . '_url') && !\Illuminate\Support\Str::startsWith($request->input($field . '_url'), 'data:image')) {
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

        // Sync whatsapp, wa_number, and telepon_wa for compatibility
        if (isset($data['whatsapp'])) {
            $data['wa_number'] = $data['whatsapp'];
            $data['telepon_wa'] = $data['whatsapp'];
        } elseif (isset($data['wa_number'])) {
            $data['whatsapp'] = $data['wa_number'];
            $data['telepon_wa'] = $data['wa_number'];
        } elseif (isset($data['telepon_wa'])) {
            $data['whatsapp'] = $data['telepon_wa'];
            $data['wa_number'] = $data['telepon_wa'];
        }

        // Process Hero Banner Slides if submitted
        if ($request->has('slides') && is_array($request->slides)) {
            $processedSlides = [];
            foreach ($request->slides as $index => $slideData) {
                $bgPath = $slideData['background_old'] ?? '';
                if (\Illuminate\Support\Str::startsWith($bgPath, 'data:image')) {
                    $bgPath = '';
                }

                // Check for file upload for this specific slide
                if ($request->hasFile("slides.{$index}.background_file")) {
                    $bgPath = $request->file("slides.{$index}.background_file")->store('settings/slides', 'public');
                } elseif (!empty($slideData['background_url']) && !\Illuminate\Support\Str::startsWith($slideData['background_url'], 'data:image')) {
                    $bgPath = trim($slideData['background_url']);
                }

                $processedSlides[] = [
                    'tag' => $slideData['tag'] ?? 'Program Unggulan Kelurahan',
                    'title_1' => $slideData['title_1'] ?? '',
                    'title_2' => $slideData['title_2'] ?? '',
                    'subtitle' => $slideData['subtitle'] ?? '',
                    'background' => $bgPath,
                ];
            }

            if (!empty($processedSlides)) {
                $data['hero_slides'] = json_encode($processedSlides);

                // Sync slide #0 for backward compatibility
                $data['hero_tag'] = $processedSlides[0]['tag'] ?? '';
                $data['hero_title_1'] = $processedSlides[0]['title_1'] ?? '';
                $data['hero_title_2'] = $processedSlides[0]['title_2'] ?? '';
                $data['hero_subtitle'] = $processedSlides[0]['subtitle'] ?? '';
                if (!empty($processedSlides[0]['background'])) {
                    $data['hero_background'] = $processedSlides[0]['background'];
                }
            }
            unset($data['slides']);
        }

        // Process Tambahan Aparatur
        if ($request->has('aparatur_tambahan') && is_array($request->aparatur_tambahan)) {
            $processedAparatur = [];
            foreach ($request->aparatur_tambahan as $index => $itemData) {
                $bgPath = $itemData['foto_old'] ?? '';
                if (\Illuminate\Support\Str::startsWith($bgPath, 'data:image')) {
                    $bgPath = '';
                }

                if ($request->hasFile("aparatur_tambahan.{$index}.foto_file")) {
                    $bgPath = $request->file("aparatur_tambahan.{$index}.foto_file")->store('settings/aparatur', 'public');
                } elseif (!empty($itemData['foto_url']) && !\Illuminate\Support\Str::startsWith($itemData['foto_url'], 'data:image')) {
                    $bgPath = trim($itemData['foto_url']);
                }

                $processedAparatur[] = [
                    'nama' => $itemData['nama'] ?? '',
                    'jabatan' => $itemData['jabatan'] ?? '',
                    'nip' => $itemData['nip'] ?? '',
                    'seksi' => $itemData['seksi'] ?? '',
                    'foto' => $bgPath,
                ];
            }

            if (!empty($processedAparatur)) {
                $data['aparatur_tambahan'] = json_encode($processedAparatur);
            } else {
                $data['aparatur_tambahan'] = json_encode([]);
            }
        } elseif ($request->has('aparatur_tambahan_hapus_semua')) {
            $data['aparatur_tambahan'] = json_encode([]);
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
                'foto_kasi_trantib', 'foto_kasi_kesra', 'gambar_bagan_struktur', 'qr_code_image',
                'login_background'
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

    public function lapor()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.integrations.lapor', compact('settings'));
    }

    public function halloSae()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.integrations.hallo_sae', compact('settings'));
    }

    public function contactMaps()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('dashboard.integrations.contact_maps', compact('settings'));
    }

    public function updateComplaintStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,resolved,rejected']);
        $complaint = \App\Models\Complaint::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        ActivityLogger::log('UPDATE', 'Pengaduan', "Mengubah status pengaduan ID #{$id} menjadi {$request->status}");

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function destroyComplaint($id)
    {
        $complaint = \App\Models\Complaint::findOrFail($id);
        $title = $complaint->title;
        $complaint->delete();

        ActivityLogger::log('DELETE', 'Pengaduan', "Menghapus pengaduan: {$title}");

        return back()->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
