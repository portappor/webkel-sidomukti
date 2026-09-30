<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kelurahan Sidomukti</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ $app_logo }}">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom scrollbar for better appearance if needed */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased min-h-screen">

    <div class="flex w-full min-h-screen">
        
        <!-- Bagian Kiri: Visual Branding (Sembunyi di Mobile) -->
        <div class="hidden lg:flex w-1/2 relative items-center overflow-hidden bg-slate-950">
            @php
                $loginBgVal = \App\Models\Setting::where('key', 'login_background')->value('value');
                $loginBgUrl = !empty($loginBgVal)
                    ? (\Illuminate\Support\Str::startsWith($loginBgVal, ['http://', 'https://']) ? $loginBgVal : \Illuminate\Support\Facades\Storage::url($loginBgVal))
                    : asset('login-bg.jpg');
            @endphp
            <!-- Background Image -->
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 scale-105" style="background-image: url('{{ $loginBgUrl }}');"></div>
            <!-- Gradient Overlay for Contrast and Readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-slate-900/50"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/40 via-transparent to-transparent"></div>
            
            <!-- Top Left Logo -->
            <div class="absolute top-10 left-10 z-20 flex items-center gap-3 bg-slate-900/40 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/10 shadow-lg">
                <div class="bg-white p-1 rounded-xl shadow-sm">
                    <img src="{{ $app_logo }}" alt="Logo" class="w-10 h-10 object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="text-amber-300 font-black text-[20px] leading-none tracking-tight drop-shadow">endless</span>
                    <span class="text-cyan-300 font-black text-[20px] leading-none tracking-tight drop-shadow">probolinggo</span>
                </div>
            </div>

            <!-- Middle Text -->
            <div class="relative z-20 w-full px-12 xl:px-16 mt-24">
                <div class="inline-block px-3 py-1 bg-emerald-500/20 backdrop-blur-md text-emerald-300 border border-emerald-400/30 rounded-full text-xs font-extrabold uppercase tracking-widest mb-3 shadow-sm">
                    Portal Layanan & Administrasi
                </div>
                <h1 class="text-4xl xl:text-5xl font-black text-white mb-3 tracking-tight drop-shadow-lg leading-tight">
                    Kelurahan Sidomukti
                </h1>
                <p class="text-emerald-400 text-lg xl:text-xl font-bold tracking-wide drop-shadow-md">
                    Kecamatan Kraksaan, Kabupaten Probolinggo
                </p>
            </div>

            <!-- Bottom Left Footer -->
            <div class="absolute bottom-10 left-10 z-20 bg-slate-900/40 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10">
                <p class="text-white/90 text-xs font-semibold tracking-wide drop-shadow-md">Pemerintah Kabupaten Probolinggo • SIMPEL Kelurahan Integrasi</p>
            </div>
        </div>

        <!-- Bagian Kanan: Form Login -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 md:px-24 xl:px-32 bg-white relative">
            
            <!-- Logo Mobile Saja -->
            <div class="absolute top-8 left-8 lg:hidden flex items-center gap-3">
                <img src="{{ $app_logo }}" alt="Logo" class="w-10 h-10 object-contain">
                <div class="font-bold text-slate-800 text-sm uppercase leading-tight">Kelurahan<br>Sidomukti</div>
            </div>

            <div class="w-full max-w-[420px] mx-auto mt-16 lg:mt-0 relative pb-10">
                <div class="text-center mb-8">
                    <h2 class="text-[34px] font-black text-slate-900 tracking-tight">Login Admin</h2>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Alert Error Login -->
                    @if (isset($errors) && $errors->any())
                        <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2 border border-red-100 shadow-sm">
                            <div class="bg-red-500 rounded-full text-white shrink-0 w-4 h-4 flex items-center justify-center">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 12v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <span class="font-semibold text-[13px]">Email atau password yang Anda masukkan salah.</span>
                        </div>
                    @endif



                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-[12px] font-bold text-slate-800 mb-1.5">Username <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@sidomukti.probolinggokab.go.id') }}" required autofocus
                            class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-[#f8fafc] focus:bg-white focus:border-[#008c5f] focus:ring-1 focus:ring-[#008c5f] transition text-sm text-slate-800 font-medium placeholder-slate-400" 
                            placeholder="admin@sidomukti.probolinggokab.go.id">
                    </div>

                    <!-- Input Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-[12px] font-bold text-slate-800 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required value="password"
                                class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-[#f8fafc] focus:bg-white focus:border-[#008c5f] focus:ring-1 focus:ring-[#008c5f] transition text-sm text-slate-800 font-medium tracking-wider placeholder-slate-400" 
                                placeholder="••••••••">
                            <button type="button" @click="showPassword = !showPassword" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPassword" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Input Captcha -->
                    <div>
                        <label for="captcha" class="block text-[12px] font-bold text-slate-800 mb-1.5">Masukkan kode berikut</label>
                        <div class="flex flex-col gap-2">
                            <div class="flex h-[42px] w-full rounded-lg overflow-hidden border border-slate-200 bg-white">
                                <div class="flex-1 flex items-center justify-center overflow-hidden bg-white">
                                    {!! captcha_img('flat', ['id' => 'captcha-img', 'class' => 'h-full object-contain']) !!}
                                </div>
                                <button type="button" onclick="document.getElementById('captcha-img').src = '{{ url('captcha/flat') }}?' + Math.random()" class="w-[46px] bg-[#00a65a] hover:bg-[#008d4c] text-white flex items-center justify-center transition shrink-0" title="Muat ulang kode">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </div>
                            <input type="text" id="captcha" name="captcha" required
                                class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-[#f8fafc] focus:bg-white focus:border-[#008c5f] focus:ring-1 focus:ring-[#008c5f] transition text-sm text-slate-800 font-medium placeholder-slate-400" 
                                placeholder="Ketik kode di gambar...">
                            @error('captcha')
                                <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg shadow text-sm font-bold text-white bg-[#008c5f] hover:bg-[#00734e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#008c5f] transition duration-200"
                            x-data="{ loading: false }" x-on:click="loading = true; setTimeout(() => loading = false, 3000)">
                            <span x-show="!loading">Masuk</span>
                            <span x-show="loading" style="display: none;" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memproses...
                            </span>
                        </button>
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-3.5 w-3.5 text-[#008c5f] focus:ring-[#008c5f] border-slate-300 rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-xs font-medium text-slate-500 cursor-pointer">
                                Ingat Saya
                            </label>
                        </div>

                        <div class="text-xs">
                            <a href="{{ route('password.request') }}" class="font-bold text-[#008c5f] hover:text-[#00734e] transition">
                                Lupa Password?
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Tombol Kembali ke Beranda -->
                <div class="mt-8 text-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#008c5f] transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Halaman Beranda
                    </a>
                </div>
                
            </div>

            <!-- Bottom Right Footer -->
            <div class="absolute bottom-8 left-0 w-full text-center hidden lg:block">
                <p class="text-[11px] font-semibold text-slate-400">&copy; {{ date('Y') }} Kelurahan Sidomukti • Kab. Probolinggo</p>
            </div>
            
        </div>

    </div>

</body>
</html>
