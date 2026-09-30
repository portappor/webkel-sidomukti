@extends('layouts.admin')

@section('title', 'Profil Saya & Keamanan Akun')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2.5">
            <div class="p-2 bg-emerald-100 text-emerald-700 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            Profil Saya & Keamanan Akun
        </h2>
        <p class="text-slate-500 text-sm mt-1">Kelola data informasi akun pribadi, foto avatar, dan kata sandi login Anda.</p>
    </div>

    <div class="flex items-center gap-2">
        <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sesi Aktif: {{ strtoupper(auth()->user()->role ?? 'ADMIN') }}
        </span>
    </div>
</div>



@if($errors->any())
<div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl relative mb-6 shadow-xs flex items-start gap-3" role="alert">
    <div class="p-1.5 bg-rose-500 text-white rounded-lg shrink-0 mt-0.5">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div>
        <h4 class="font-bold text-xs uppercase tracking-wider text-rose-900">Terdapat Kesalahan</h4>
        <ul class="text-xs text-rose-700 font-medium list-disc list-inside mt-1 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- LEFT COLUMN: User Card & Overview -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Account Overview Card -->
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden relative">
            <div class="h-28 bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 relative">
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#34d399_1px,transparent_1px)] [background-size:16px_16px]"></div>
            </div>
            
            <div class="px-6 pb-6 text-center -mt-14 relative z-10">
                <div class="inline-block relative">
                    <img id="previewAvatarCard" 
                         src="{{ $user->avatar ? (str_starts_with($user->avatar, 'http') ? $user->avatar : Storage::url($user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=15803d&background=f0fdf4&size=200' }}" 
                         alt="{{ $user->name }}" 
                         class="w-28 h-28 object-cover rounded-2xl border-4 border-white shadow-xl bg-white mx-auto">
                    <span class="absolute bottom-1 right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full" title="Status Online"></span>
                </div>

                <h3 class="text-lg font-black text-slate-800 mt-3 tracking-tight">{{ $user->name }}</h3>
                <p class="text-xs font-medium text-slate-500 mb-3">{{ $user->email }}</p>

                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-extrabold rounded-full uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    {{ $user->role === 'admin' ? 'Administrator System' : 'Staf Operator' }}
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3 text-left">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Terdaftar Sejak</span>
                        <span class="text-xs font-bold text-slate-700 mt-0.5 block">
                            {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '14 Sep 2026' }}
                        </span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Log Aktivitas</span>
                        <span class="text-xs font-bold text-emerald-700 mt-0.5 block">
                            {{ $recentActivities->count() }} Terakhir
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Hints Box -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-xl border border-slate-700/50">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-emerald-500/20 text-emerald-400 rounded-xl border border-emerald-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-white">Panduan Keamanan Akun</h4>
                    <p class="text-xs text-slate-400">Tips menjaga kerahasiaan akses admin</p>
                </div>
            </div>
            <ul class="text-xs text-slate-300 space-y-2.5 leading-relaxed">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Gunakan kombinasi minimal 8 karakter dengan huruf dan angka.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Jangan membagikan kata sandi login kepada siapapun.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Pastikan selalu melakukan Logout jika mengakses dari komputer publik.
                </li>
            </ul>
        </div>
    </div>

    <!-- RIGHT COLUMN: Forms & Activity Log -->
    <div class="lg:col-span-8 space-y-6">

        <!-- Form Edit Informasi Akun & Avatar -->
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">Informasi Akun & Avatar</h3>
                        <p class="text-xs text-slate-500">Perbarui nama, email, dan pasfoto avatar profil Anda</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('dashboard.settings.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Upload Avatar section -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/70">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Foto Avatar Profil</label>
                    <div class="flex flex-col sm:flex-row items-center gap-5">
                        <img id="previewAvatarForm" 
                             src="{{ $user->avatar ? (str_starts_with($user->avatar, 'http') ? $user->avatar : Storage::url($user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=15803d&background=f0fdf4&size=200' }}" 
                             alt="Preview Avatar" 
                             class="w-20 h-20 object-cover rounded-2xl border-2 border-emerald-500 shadow-sm shrink-0">

                        <div class="flex-grow space-y-2 w-full">
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                <input type="file" 
                                       name="avatar" 
                                       id="inputAvatarFile" 
                                       data-preview="#previewAvatarForm" 
                                       accept="image/*" 
                                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                                
                                <button type="button" 
                                        onclick="window.CropHelper && window.CropHelper.open(document.getElementById('inputAvatarFile'))" 
                                        class="shrink-0 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3.5 py-2 rounded-xl transition flex items-center justify-center gap-1.5 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"></path></svg>
                                    Potong Presisi
                                </button>
                            </div>
                            <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP (Maks: 2MB). Rasio 1:1 direkomendasikan.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Fields Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required 
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required 
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Peran Akun (Role)</label>
                    <input type="text" 
                           value="{{ strtoupper($user->role ?? 'ADMIN') }} — (Akses Lengkap Fitur & Pengaturan)" 
                           disabled 
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed font-medium">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition flex items-center gap-2 text-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Form Ubah Kata Sandi -->
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-50 text-amber-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">Ubah Kata Sandi</h3>
                        <p class="text-xs text-slate-500">Perbarui kata sandi login untuk keamanan ekstra</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('dashboard.settings.profile.update') }}" method="POST" class="p-6 space-y-5" x-data="{ showPassCurrent: false, showPassNew: false, showPassConfirm: false }">
                @csrf
                @method('PUT')
                
                <!-- Hidden name & email to satisfy validation if required -->
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div>
                    <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </span>
                        <input :type="showPassCurrent ? 'text' : 'password'" 
                               name="current_password" 
                               id="current_password" 
                               placeholder="Masukkan kata sandi lama Anda" 
                               class="w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs">
                        <button type="button" @click="showPassCurrent = !showPassCurrent" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input :type="showPassNew ? 'text' : 'password'" 
                                   name="new_password" 
                                   id="new_password" 
                                   placeholder="Minimal 8 karakter" 
                                   class="w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs">
                            <button type="button" @click="showPassNew = !showPassNew" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <input :type="showPassConfirm ? 'text' : 'password'" 
                                   name="new_password_confirmation" 
                                   id="new_password_confirmation" 
                                   placeholder="Ulangi kata sandi baru" 
                                   class="w-full pl-10 pr-10 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs">
                            <button type="button" @click="showPassConfirm = !showPassConfirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition flex items-center gap-2 text-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>

        <!-- Section: Riwayat Aktivitas Saya -->
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">Riwayat Aktivitas Terakhir Saya</h3>
                        <p class="text-xs text-slate-500">Daftar tindakan dan pengeditan yang Anda lakukan di portal</p>
                    </div>
                </div>
                
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard.activity-logs.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition">
                    Lihat Semua Log
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-slate-500 font-bold uppercase tracking-wider">
                            <th class="py-3 px-6">Waktu</th>
                            <th class="py-3 px-4">Aksi / Modul</th>
                            <th class="py-3 px-6">Keterangan</th>
                            <th class="py-3 px-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($recentActivities as $log)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-6 text-slate-600 whitespace-nowrap">
                                {{ $log->created_at ? $log->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @php
                                        $actionBadgeClass = match(strtoupper($log->action)) {
                                            'CREATE' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'UPDATE' => 'bg-sky-100 text-sky-800 border-sky-200',
                                            'DELETE' => 'bg-rose-100 text-rose-800 border-rose-200',
                                            'LOGIN' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                            'LOGOUT' => 'bg-slate-100 text-slate-800 border-slate-200',
                                            default => 'bg-amber-100 text-amber-800 border-amber-200',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded text-[10px] font-extrabold border uppercase {{ $actionBadgeClass }}">
                                        {{ $log->action }}
                                    </span>
                                    <span class="text-slate-700 font-bold">{{ $log->module }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 text-slate-700 max-w-xs truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono text-[11px] whitespace-nowrap">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 font-medium">
                                Belum ada riwayat aktivitas tercatat untuk akun Anda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
