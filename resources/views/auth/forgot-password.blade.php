<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Kata Sandi Akun - Kelurahan Sidomukti</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ $app_logo }}">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-900/90 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">

    <!-- Background Blur & Pattern -->
    <div class="fixed inset-0 bg-cover bg-center opacity-30 pointer-events-none" style="background-image: url('{{ asset('login-bg.jpg') }}');"></div>
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm pointer-events-none"></div>

    <!-- Main Card Box (Exact Screenshot Match) -->
    <div class="relative z-10 w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden p-6 sm:p-8 space-y-6"
         x-data="forgotPasswordForm({{ json_encode($users) }})">

        <!-- Top Logo Emblem -->
        <div class="text-center space-y-2">
            <div class="inline-block p-2 bg-gradient-to-tr from-emerald-500 via-rose-500 to-indigo-500 rounded-full shadow-lg">
                <div class="bg-white p-2 rounded-full">
                    <img src="{{ $app_logo }}" 
                         alt="Logo Probolinggo" 
                         class="w-12 h-12 object-contain">
                </div>
            </div>

            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-pink-50 border border-pink-200 text-pink-600 text-[11px] font-extrabold rounded-full uppercase tracking-wider shadow-2xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    🔑 LUPA PASSWORD
                </span>
            </div>

            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Pemulihan Kata Sandi Akun</h2>
            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                Lengkapi Email / Username, Nomor WhatsApp, dan Kode Referral Anda di bawah ini untuk memaksa masuk ke akun Anda
            </p>
        </div>

        <!-- Alert Notification -->
        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Recovery -->
        <form action="{{ route('password.force') }}" method="POST" class="space-y-4">
            @csrf

            <!-- 1. Pilih Akun / Email Login (Auto-Fill Dropdown & Input) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-800">
                        Pilih Akun / Email Login <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[10px] text-purple-600 font-extrabold flex items-center gap-1">
                        ⚡ Auto-Fill
                    </span>
                </div>

                <!-- Select Auto-Fill Dropdown -->
                <select @change="onSelectUser($event)" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-bold text-slate-700">
                    <option value="">-- Pilih Akun Administrator (Auto-Fill) --</option>
                    <template x-for="user in users" :key="user.id">
                        <option :value="user.id" x-text="user.name + ' (' + user.email + ')'"></option>
                    </template>
                </select>

                <!-- Input Text Field Email/Username -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    <input type="text" 
                           name="email" 
                           x-model="form.email" 
                           placeholder="admin@kandangjatikulon.probolinggokab.go.id atau user..." 
                           required 
                           class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-slate-300 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium">
                </div>
                <p class="text-[10px] text-blue-600 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Email terdaftar pengguna administrator
                </p>
            </div>

            <!-- 2. Grid Validation (WhatsApp & Kode Referral) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- No. WA (Validasi 1) -->
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        No. WA (Validasi 1) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="phone" 
                           x-model="form.phone" 
                           placeholder="081234567890" 
                           required
                           class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('phone') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-300' }} bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-medium">
                    @error('phone')
                        <p class="text-[10px] text-rose-600 font-bold mt-1">{{ $message }}</p>
                    @else
                        <p class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            11–13 digit angka
                        </p>
                    @enderror
                </div>

                <!-- Kode Referral (Validasi 2) -->
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Kode Referral (Validasi 2) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="referral_code" 
                           x-model="form.referral_code" 
                           placeholder="Contoh: ADM001" 
                           required 
                           class="w-full px-4 py-2.5 text-xs rounded-xl border {{ $errors->has('referral_code') ? 'border-rose-500 ring-1 ring-rose-500' : 'border-slate-300' }} bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-bold tracking-wider uppercase">
                    @error('referral_code')
                        <p class="text-[10px] text-rose-600 font-bold mt-1">{{ $message }}</p>
                    @else
                        <p class="text-[10px] text-blue-600 font-medium mt-1">
                            <span>ℹ Wajib diisi sesuai kode referral akun Anda</span>
                        </p>
                    @enderror
                </div>
            </div>

            <!-- 3. Syarat Kombinasi Instruksi Pemulihan Akun (Gmail Style) -->
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                <span class="block text-[10px] font-extrabold text-slate-600 uppercase tracking-wider">
                    SYARAT KOMBINASI INSTRUKSI PEMULIHAN AKUN (GMAIL STYLE):
                </span>
                
                <div class="grid grid-cols-2 gap-2 text-[11px] font-semibold text-slate-600">
                    <div class="flex items-center gap-1.5" :class="form.email.length >= 4 ? 'text-emerald-700 font-bold' : ''">
                        <span class="w-3.5 h-3.5 rounded-full border flex items-center justify-center text-[9px]" :class="form.email.length >= 4 ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300'">
                            <template x-if="form.email.length >= 4">✓</template>
                        </span>
                        Min. 4 Karakter
                    </div>

                    <div class="flex items-center gap-1.5" :class="/[A-Z]/.test(form.email || '') ? 'text-emerald-700 font-bold' : ''">
                        <span class="w-3.5 h-3.5 rounded-full border flex items-center justify-center text-[9px]" :class="/[A-Z]/.test(form.email || '') ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300'">
                            <template x-if="/[A-Z]/.test(form.email || '')">✓</template>
                        </span>
                        Huruf Besar (A–Z)
                    </div>

                    <div class="flex items-center gap-1.5" :class="/[a-z]/.test(form.email || '') ? 'text-emerald-700 font-bold' : ''">
                        <span class="w-3.5 h-3.5 rounded-full border flex items-center justify-center text-[9px]" :class="/[a-z]/.test(form.email || '') ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300'">
                            <template x-if="/[a-z]/.test(form.email || '')">✓</template>
                        </span>
                        Huruf Kecil (a-z)
                    </div>

                    <div class="flex items-center gap-1.5" :class="form.phone.length >= 10 ? 'text-emerald-700 font-bold' : ''">
                        <span class="w-3.5 h-3.5 rounded-full border flex items-center justify-center text-[9px]" :class="form.phone.length >= 10 ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300'">
                            <template x-if="form.phone.length >= 10">✓</template>
                        </span>
                        No. WA Valid
                    </div>
                </div>

                <div class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-600 pt-1" :class="form.referral_code.length >= 4 ? 'text-emerald-700 font-bold' : ''">
                    <span class="w-3.5 h-3.5 rounded-full border flex items-center justify-center text-[9px]" :class="form.referral_code.length >= 4 ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300'">
                        <template x-if="form.referral_code.length >= 4">✓</template>
                    </span>
                    Kode Referral (3 Huruf + 3 Angka)
                </div>
            </div>

            <!-- Footer Action Buttons -->
            <div class="pt-3 flex items-center justify-between gap-3">
                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center gap-1.5">
                    ← Batal
                </a>

                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-600/30 transition flex items-center gap-2 cursor-pointer">
                    ➔ Memaksa Masuk ke Akun
                </button>
            </div>
        </form>

    </div>

<script>
function forgotPasswordForm(users) {
    return {
        users: users || [],
        form: {
            email: '',
            phone: '',
            referral_code: ''
        },

        onSelectUser(event) {
            const selectedId = event.target.value;
            if (!selectedId) return;

            const selectedUser = this.users.find(u => u.id == selectedId);
            if (selectedUser) {
                // Only fill email/username, do NOT fill phone or referral_code automatically!
                this.form.email = selectedUser.email || selectedUser.username || '';
            }
        }
    };
}
</script>
</body>
</html>
