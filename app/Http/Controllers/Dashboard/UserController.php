<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ActivityLogger;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staf',
            'phone' => 'nullable|string|max:30',
            'referral_code' => 'nullable|string|max:50',
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Email resmi administrator wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'avatar.mimes' => '🚫 AKSES DITOLAK! Format berkas foto profil pengguna tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $newUser = User::create([
            'name' => $request->name,
            'username' => $request->username ?: strtolower(str_replace(' ', '', $request->name)),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'referral_code' => $request->referral_code,
            'avatar' => $avatarPath,
        ]);

        ActivityLogger::log('CREATE', 'Pengguna', "Menambahkan pengguna baru: {$newUser->name} ({$newUser->email}) sebagai {$newUser->role}", [
            'user_id' => $newUser->id,
            'role' => $newUser->role
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('dashboard.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staf',
            'phone' => 'nullable|string|max:30',
            'referral_code' => 'nullable|string|max:50',
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $request->validate($rules, [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'email.required' => 'Email resmi administrator wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'username.unique' => 'Username ini sudah digunakan.',
            'avatar.mimes' => '🚫 AKSES DITOLAK! Format berkas foto profil pengguna tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username ?: strtolower(str_replace(' ', '', $request->name)),
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'referral_code' => $request->referral_code,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && !\Illuminate\Support\Str::startsWith($user->avatar, 'http') && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        ActivityLogger::log('UPDATE', 'Pengguna', "Mengubah data pengguna: {$user->name} ({$user->email})", [
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $deletedName = $user->name;
        $deletedEmail = $user->email;
        $user->delete();

        ActivityLogger::log('DELETE', 'Pengguna', "Menghapus akun pengguna: {$deletedName} ({$deletedEmail})");

        return redirect()->route('dashboard.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}

