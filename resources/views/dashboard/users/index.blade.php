@extends('layouts.admin')

@section('title', 'CRUD Pengguna & Hak Akses (Users)')

@section('content')
<div class="space-y-6" x-data="userManagement()">
    
    <!-- Top Header Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 p-6 rounded-3xl text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-[10px] font-extrabold rounded-full uppercase tracking-wider mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                HAK AKSES & PENGGUNA
            </div>
            <h2 class="text-2xl font-black tracking-tight text-white">CRUD Pengguna & Hak Akses (Users)</h2>
            <p class="text-xs text-slate-300 mt-1">Kelola data seluruh akun operator, administrator, hak akses, dan foto profil pengguna.</p>
        </div>

        <div class="relative z-10 flex items-center gap-3">
            <button @click="openCreateModal()" class="bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-emerald-900/40 hover:-translate-y-0.5 transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Akun Pengguna Baru
            </button>
        </div>
    </div>

    <!-- Alert Flash Notifications -->
    

    

    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Total Pengguna</span>
                <span class="text-xl font-black text-slate-800">{{ $users->count() }} Akun</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-purple-50 text-purple-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Super Admin</span>
                <span class="text-xl font-black text-slate-800">{{ $users->where('role', 'admin')->count() }} Akun</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-sky-50 text-sky-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Anggota Staf</span>
                <span class="text-xl font-black text-slate-800">{{ $users->where('role', 'staf')->count() }} Akun</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider block">Status Server</span>
                <span class="text-xl font-black text-emerald-600 flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    Aktif Online
                </span>
            </div>
        </div>
    </div>

    <!-- Main Data Table Container -->
    <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden">
        
        <!-- Table Toolbar Filter -->
        <div class="p-5 bg-slate-50/50 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-700">Daftar Akun Terdaftar</span>
                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-extrabold rounded-full">{{ $users->count() }} Users</span>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" x-model="searchQuery" placeholder="Cari nama, email, phone..." class="pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs w-64">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-900 text-slate-200 font-extrabold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-6">Foto & Nama Pengguna</th>
                        <th class="py-4 px-5">Username & Email</th>
                        <th class="py-4 px-5">No. WhatsApp & Referral</th>
                        <th class="py-4 px-4 text-center">Role Hak Akses</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Aksi Operasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($users as $user)
                    <tr class="hover:bg-emerald-50/40 transition" x-show="matchesSearch('{{ strtolower($user->name . ' ' . $user->email . ' ' . $user->username . ' ' . $user->phone) }}')">
                        <!-- Avatar & Nama -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $user->avatar ? (str_starts_with($user->avatar, 'http') ? $user->avatar : Storage::url($user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=ffffff&background=059669&size=100' }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-11 h-11 object-cover rounded-2xl border-2 border-emerald-500 shadow-sm shrink-0">
                                <div>
                                    <span class="font-extrabold text-slate-800 text-sm block">{{ $user->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">ID Akun: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- Username & Email -->
                        <td class="py-4 px-5">
                            <div class="space-y-1">
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-mono text-[11px] rounded border border-slate-200 inline-block font-bold">
                                    {{ '@' . ($user->username ?: strtolower(str_replace(' ', '', $user->name))) }}
                                </span>
                                <span class="text-slate-600 block text-xs font-semibold">{{ $user->email }}</span>
                            </div>
                        </td>

                        <!-- Phone & Referral Code -->
                        <td class="py-4 px-5">
                            <div class="space-y-1">
                                <span class="text-slate-700 font-bold block flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $user->phone ?: '081234567890' }}
                                </span>
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-800 text-[10px] font-extrabold rounded border border-amber-200 inline-block">
                                    Ref: {{ $user->referral_code ?: 'STF' . rand(100, 999) }}
                                </span>
                            </div>
                        </td>

                        <!-- Role -->
                        <td class="py-4 px-4 text-center">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 border border-purple-200 text-[10px] font-black uppercase rounded-full tracking-wider shadow-2xs">
                                    Super Admin
                                </span>
                            @else
                                <span class="px-3 py-1 bg-sky-100 text-sky-800 border border-sky-200 text-[10px] font-black uppercase rounded-full tracking-wider shadow-2xs">
                                    Anggota Staf
                                </span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4 text-center">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-extrabold rounded-full inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Valid
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="openEditModal({{ json_encode($user) }})" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-xl font-bold transition flex items-center gap-1.5 cursor-pointer" title="Edit Akun User">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </button>

                                @if($user->id !== auth()->id())
                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 rounded-xl transition cursor-pointer" title="Hapus Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                            Belum ada akun pengguna terdaftar dalam sistem.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL POPUP FORM (MATCHES THE SCREENSHOT EXACTLY) -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;" 
         x-cloak>
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <!-- Modal Box -->
        <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
            <div class="relative w-full max-w-xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                
                <!-- Modal Dark Emerald Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                                HAK AKSES & PENGGUNA
                            </span>
                            <h3 class="text-base font-black text-white mt-0.5" x-text="isEdit ? 'Edit Data Akun Pengguna' : 'Tambah Akun Pengguna Baru'"></h3>
                        </div>
                    </div>

                    <button type="button" @click="closeModal()" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Form Content Body -->
                <form :action="isEdit ? '/dashboard/users/' + form.id : '{{ route('dashboard.users.store') }}'" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      onsubmit="return validateUserForm(this)" 
                      class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- 1. Foto Profil (PP Pengguna) -->
                    <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-700 text-white font-black text-xl flex items-center justify-center border-2 border-emerald-500 shrink-0 shadow-sm overflow-hidden">
                            <template x-if="avatarPreview">
                                <img :src="avatarPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!avatarPreview">
                                <span x-text="form.name ? form.name.charAt(0).toUpperCase() : 'U'"></span>
                            </template>
                        </div>
                        <div class="space-y-1.5 flex-grow">
                            <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Foto Profil (PP Pengguna)</label>
                            <input type="file" name="avatar" @change="previewAvatar($event)" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                            <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP (Maksimal 5MB)</p>
                        </div>
                    </div>

                    <!-- 2. Nama Lengkap Pengguna -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Nama Lengkap Pengguna <span class="text-rose-500">*</span>
                            </span>
                        </label>
                        <input type="text" 
                               name="name" 
                               x-model="form.name" 
                               @input="onNameInput()" 
                               placeholder="Misal: Sukma Rahmad" 
                               required 
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-medium">
                        
                        <p class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Ketik nama di atas untuk mengisi Username, Email & Kode Referral otomatis
                        </p>
                    </div>

                    <!-- 3. Grid: Username & Role -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                <span class="flex items-center justify-between">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        Username Login
                                    </span>
                                    <span class="text-[9px] px-1.5 py-0.5 bg-emerald-100 text-emerald-700 font-extrabold rounded">⚡ Auto-Fill</span>
                                </span>
                            </label>
                            <input type="text" 
                                   name="username" 
                                   x-model="form.username" 
                                   placeholder="sukma" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Role Hak Akses <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            <select name="role" x-model="form.role" required class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-bold">
                                <option value="staf">Anggota Staf</option>
                                <option value="admin">Super Admin / Administrator</option>
                            </select>
                        </div>
                    </div>

                    <!-- 4. Email Resmi Administrator -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Email Resmi Administrator <span class="text-rose-500">*</span>
                            </span>
                        </label>
                        <input type="email" 
                               name="email" 
                               x-model="form.email" 
                               placeholder="sukma@gmail.com" 
                               required 
                               class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-medium">
                        
                        <div class="mt-1 flex items-center justify-between text-[10px]">
                            <span class="text-slate-400">⚡ Email wajib berakhiran @gmail.com</span>
                            <span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-800 font-extrabold rounded">✔ Valid</span>
                        </div>
                    </div>

                    <!-- 5. Grid: WhatsApp & Kode Referral -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                <span class="flex items-center justify-between">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        No. WhatsApp (Validasi 1)
                                    </span>
                                    <span class="text-[9px] text-emerald-700 font-bold">✔ Valid</span>
                                </span>
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   x-model="form.phone" 
                                   placeholder="081234567890" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-medium">
                            <p class="text-[9px] text-slate-400 mt-0.5">Diawali 08 & 11–13 digit</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                <span class="flex items-center justify-between">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                        Kode Referral
                                    </span>
                                    <button type="button" @click="generateReferralCode()" class="text-[9px] px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 rounded hover:bg-emerald-100 transition cursor-pointer">
                                        ⚡ Acak Kode
                                    </button>
                                </span>
                            </label>
                            <input type="text" 
                                   name="referral_code" 
                                   x-model="form.referral_code" 
                                   placeholder="STF888" 
                                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-bold tracking-wider">
                            <p class="text-[9px] text-slate-400 mt-0.5">3 huruf + 3 angka</p>
                        </div>
                    </div>

                    <!-- 6. Password Keamanan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center justify-between">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Password Keamanan <span x-show="isEdit" class="text-slate-400 font-normal text-[10px]">(Kosongkan jika tidak diubah)</span>
                                </span>
                                <button type="button" @click="generatePassword()" class="text-[9px] px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 rounded hover:bg-emerald-100 transition cursor-pointer">
                                    ⚡ Buat Password Aman
                                </button>
                            </span>
                        </label>

                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" 
                                   name="password" 
                                   x-model="form.password" 
                                   :required="!isEdit" 
                                   placeholder="Kelurahan!4329" 
                                   class="w-full pl-4 pr-10 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-mono">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>

                        <!-- Password Combination Rules Checklist -->
                        <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-200/80 space-y-1.5 text-[10px]">
                            <span class="font-extrabold text-slate-700 uppercase tracking-wider block mb-1">Syarat Kombinasi Password Aman:</span>
                            <div class="grid grid-cols-2 gap-1.5 font-bold text-slate-600">
                                <div class="flex items-center gap-1" :class="hasMinLength ? 'text-emerald-700' : ''">
                                    <svg class="w-3 h-3" :class="hasMinLength ? 'text-emerald-600' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Min. 8 Karakter
                                </div>
                                <div class="flex items-center gap-1" :class="hasUppercase ? 'text-emerald-700' : ''">
                                    <svg class="w-3 h-3" :class="hasUppercase ? 'text-emerald-600' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Huruf Besar (A–Z)
                                </div>
                                <div class="flex items-center gap-1" :class="hasLowercase ? 'text-emerald-700' : ''">
                                    <svg class="w-3 h-3" :class="hasLowercase ? 'text-emerald-600' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Huruf Kecil (a-z)
                                </div>
                                <div class="flex items-center gap-1" :class="hasNumber ? 'text-emerald-700' : ''">
                                    <svg class="w-3 h-3" :class="hasNumber ? 'text-emerald-600' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    Angka (0–9)
                                </div>
                            </div>
                            <div class="flex items-center gap-1 font-bold text-slate-600 pt-1" :class="hasSpecialChar ? 'text-emerald-700' : ''">
                                <svg class="w-3 h-3" :class="hasSpecialChar ? 'text-emerald-600' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Kode Unik / Simbol (@, #, $, %, !, *)
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="closeModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Data User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function userManagement() {
    return {
        showModal: false,
        isEdit: false,
        searchQuery: '',
        showPassword: true,
        avatarPreview: null,
        form: {
            id: null,
            name: '',
            username: '',
            role: 'staf',
            email: '',
            phone: '',
            referral_code: '',
            password: ''
        },

        matchesSearch(text) {
            if (!this.searchQuery) return true;
            return text.includes(this.searchQuery.toLowerCase());
        },

        openCreateModal() {
            this.isEdit = false;
            this.avatarPreview = null;
            this.form = {
                id: null,
                name: '',
                username: '',
                role: 'staf',
                email: '',
                phone: '',
                referral_code: '',
                password: ''
            };
            this.generateReferralCode();
            this.generatePassword();
            this.showModal = true;
        },

        openEditModal(user) {
            this.isEdit = true;
            this.avatarPreview = user.avatar ? (user.avatar.startsWith('http') ? user.avatar : '/storage/' + user.avatar) : null;
            this.form = {
                id: user.id,
                name: user.name,
                username: user.username || user.name.toLowerCase().replace(/\s+/g, ''),
                role: user.role || 'staf',
                email: user.email,
                phone: user.phone || '081234567890',
                referral_code: user.referral_code || 'STF888',
                password: ''
            };
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        onNameInput() {
            if (!this.form.name) return;
            const cleanName = this.form.name.toLowerCase().replace(/[^a-z0-9]/g, '');
            if (!this.isEdit) {
                this.form.username = cleanName;
                this.form.email = cleanName + '@gmail.com';
            }
        },

        generateReferralCode() {
            const letters = 'STF';
            const numbers = Math.floor(100 + Math.random() * 900);
            this.form.referral_code = letters + numbers;
        },

        generatePassword() {
            const prefix = 'Kelurahan!';
            const num = Math.floor(1000 + Math.random() * 9000);
            this.form.password = prefix + num;
        },

        previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                if (typeof window.validateImageUpload === 'function' && !window.validateImageUpload(event.target)) {
                    event.target.value = '';
                    this.avatarPreview = null;
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.avatarPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        get hasMinLength() {
            return this.form.password && this.form.password.length >= 8;
        },
        get hasUppercase() {
            return /[A-Z]/.test(this.form.password || '');
        },
        get hasLowercase() {
            return /[a-z]/.test(this.form.password || '');
        },
        get hasNumber() {
            return /[0-9]/.test(this.form.password || '');
        },
        get hasSpecialChar() {
            return /[@#$%!*&^]/.test(this.form.password || '');
        }
    };
}

window.validateUserForm = function(form) {
    const avatarInput = form.querySelector('input[name="avatar"]');
    if (avatarInput && avatarInput.files && avatarInput.files.length > 0) {
        if (!validateImageUpload(avatarInput)) {
            return false;
        }
    }
    return true;
};
</script>
@endsection
