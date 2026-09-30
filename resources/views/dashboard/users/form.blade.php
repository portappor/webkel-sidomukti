@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Akun Pengguna' : 'Tambah Akun Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="userForm({{ isset($user) ? json_encode($user) : 'null' }})">
    <!-- Back Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard.users.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-700 transition flex items-center gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-2xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Akun
        </a>
    </div>

    <!-- Form Container Box -->
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center gap-3 text-white">
            <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <div>
                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                    HAK AKSES & PENGGUNA
                </span>
                <h3 class="text-base font-black text-white mt-0.5">{{ isset($user) ? 'Edit Data Akun Pengguna' : 'Tambah Akun Pengguna Baru' }}</h3>
            </div>
        </div>

        <form action="{{ isset($user) ? route('dashboard.users.update', $user->id) : route('dashboard.users.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              onsubmit="return validateUserForm(this)" 
              class="p-6 md:p-8 space-y-5">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

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
                @error('name')
                    <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
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
                @error('email')
                    <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
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
                            Password Keamanan {{ isset($user) ? '(Kosongkan jika tidak diubah)' : '' }}
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
                           {{ !isset($user) ? 'required' : '' }} 
                           placeholder="Kelurahan!4329" 
                           class="w-full pl-4 pr-10 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs font-mono">
                    <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror

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
                <a href="{{ route('dashboard.users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function userForm(initialUser) {
    return {
        showPassword: true,
        avatarPreview: initialUser && initialUser.avatar ? (initialUser.avatar.startsWith('http') ? initialUser.avatar : '/storage/' + initialUser.avatar) : null,
        form: {
            name: initialUser ? initialUser.name : '',
            username: initialUser ? (initialUser.username || initialUser.name.toLowerCase().replace(/\s+/g, '')) : '',
            role: initialUser ? initialUser.role : 'staf',
            email: initialUser ? initialUser.email : '',
            phone: initialUser ? (initialUser.phone || '081234567890') : '',
            referral_code: initialUser ? (initialUser.referral_code || 'STF888') : '',
            password: ''
        },

        init() {
            if (!initialUser) {
                this.generateReferralCode();
                this.generatePassword();
            }
        },

        onNameInput() {
            if (!this.form.name) return;
            const cleanName = this.form.name.toLowerCase().replace(/[^a-z0-9]/g, '');
            if (!initialUser) {
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
