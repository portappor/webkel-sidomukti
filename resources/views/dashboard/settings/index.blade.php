@extends('layouts.admin')

@section('title', 'Kelola Identitas & Pengaturan Umum')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Identitas & Pengaturan Umum</h2>
        <p class="text-slate-500 text-sm">Kelola informasi publik, hero banner, statistik, sambutan pimpinan, dan kontak resmi kelurahan.</p>
    </div>
    <div>
        <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Beranda Publik
        </a>
    </div>
</div>



<form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSettingsIndexForm(this)" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Section 1: Logo & Branding Kelurahan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M9 8h.01M15 16h.01M15 12h.01M15 8h.01"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Identitas & Logo Kelurahan</h3>
                    <p class="text-slate-500 text-xs">Identitas utama yang tampil pada Navbar dan Header Website.</p>
                </div>
            </div>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Instansi Kelurahan</label>
                    <input type="text" name="agency_name" value="{{ $settings['agency_name'] ?? 'KELURAHAN SIDOMUKTI' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-semibold text-slate-800" placeholder="Contoh: KELURAHAN SIDOMUKTI">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kecamatan & Kabupaten</label>
                    <input type="text" name="regency_name" value="{{ $settings['regency_name'] ?? 'Kecamatan Kraksaan, Kabupaten Probolinggo' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-medium text-slate-800" placeholder="Contoh: Kecamatan Kraksaan, Kabupaten Probolinggo">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Logo Kelurahan (Muncul di Header Navigation)</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <div class="w-20 h-20 rounded-2xl border border-slate-200 bg-slate-50 p-2 flex items-center justify-center shrink-0 shadow-xs relative">
                        @php
                            $logoVal = $settings['logo_kelurahan'] ?? '';
                            $logoSrc = $app_logo;
                        @endphp
                        <img id="previewLogoKelurahan" src="{{ $logoSrc }}" alt="Logo Saat Ini" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="flex-grow space-y-3">
                        <div>
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">Opsi A: Unggah Berkas File Logo <span class="text-[10px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                            <div class="flex items-center gap-2">
                                <input type="file" name="logo_kelurahan" id="logo_kelurahan" data-ratio="1:1" data-preview="#previewLogoKelurahan" accept="image/png, image/svg+xml, image/jpeg" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                                <button type="button" onclick="window.CropHelper && window.CropHelper.open(document.getElementById('logo_kelurahan'))" class="shrink-0 text-xs text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-semibold px-3 py-2 rounded-xl border border-emerald-200 transition inline-flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                                    Potong
                                </button>
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">Opsi B: Atau Tempel Link/URL Foto Logo (HTTP/HTTPS)</span>
                            <input type="url" name="logo_kelurahan_url" value="{{ \Illuminate\Support\Str::startsWith($logoVal, ['http://', 'https://']) ? $logoVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" oninput="if(this.value){ document.getElementById('previewLogoKelurahan').src = this.value; }" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-mono" placeholder="https://domain.com/logo.png">
                        </div>
                        @if(isset($settings['logo_kelurahan']) && $settings['logo_kelurahan'])
                        <div class="pt-1">
                            <button type="submit" form="destroy-logo-form" onclick="return confirm('Yakin ingin menghapus logo dan menggunakan logo bawaan?')" class="text-xs text-red-600 hover:text-red-800 font-bold underline flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Reset Logo ke Default
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Gambar Latar Belakang Halaman Login Admin -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Gambar Latar Belakang Halaman Login Admin</h3>
                    <p class="text-slate-500 text-xs">Foto / Gambar visual branding yang tampil di sisi samping halaman Login Operator/Admin.</p>
                </div>
            </div>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Background Login Saat Ini</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <div class="w-full sm:w-64 h-36 rounded-2xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 shadow-xs relative">
                        @php
                            $loginBgVal = $settings['login_background'] ?? '';
                            $loginBgSrc = !empty($loginBgVal)
                                ? (\Illuminate\Support\Str::startsWith($loginBgVal, ['http://', 'https://']) ? $loginBgVal : Storage::url($loginBgVal))
                                : asset('login-bg.jpg');
                        @endphp
                        <img id="previewLoginBackground" src="{{ $loginBgSrc }}" alt="Latar Login Saat Ini" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-2">
                            <span class="text-[9px] text-indigo-300 font-bold bg-slate-900/90 px-2 py-0.5 rounded border border-slate-700">Preview Halaman Login</span>
                        </div>
                    </div>
                    <div class="flex-grow space-y-3 w-full">
                        <div>
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">Opsi A: Unggah Berkas Gambar Latar Login Baru (HD 16:9) <span class="text-[10px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                            <div class="flex items-center gap-2">
                                <input type="file" name="login_background" id="login_background" data-ratio="16:9" data-preview="#previewLoginBackground" accept="image/png, image/jpeg, image/webp, image/jpg" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                                <button type="button" onclick="window.CropHelper && window.CropHelper.open(document.getElementById('login_background'))" class="shrink-0 text-xs text-indigo-700 bg-indigo-50 hover:bg-indigo-100 font-semibold px-3 py-2 rounded-xl border border-indigo-200 transition inline-flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                                    Potong
                                </button>
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">Opsi B: Atau Tempel Link/URL Gambar Latar Belakang (HTTP/HTTPS)</span>
                            <input type="url" name="login_background_url" value="{{ \Illuminate\Support\Str::startsWith($loginBgVal, ['http://', 'https://']) ? $loginBgVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" oninput="if(this.value){ document.getElementById('previewLoginBackground').src = this.value; }" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 transition font-mono" placeholder="https://images.unsplash.com/photo-login-bg.jpg">
                        </div>
                        @if(isset($settings['login_background']) && $settings['login_background'])
                        <div class="pt-1">
                            <button type="submit" form="destroy-login-bg-form" onclick="return confirm('Yakin ingin menghapus gambar latar login dan memakai foto bawaan?')" class="text-xs text-red-600 hover:text-red-800 font-bold underline flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Reset Gambar Login ke Default
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Hero Banner Beranda -->
    @php
        $heroMode = $settings['hero_banner_mode'] ?? 'slider';
        $rawHeroSlides = isset($settings['hero_slides']) ? json_decode($settings['hero_slides'], true) : [];
        if (!is_array($rawHeroSlides) || empty($rawHeroSlides)) {
            $rawHeroSlides = [
                [
                    'tag' => $settings['hero_tag'] ?? 'Program Unggulan Kelurahan',
                    'title_1' => $settings['hero_title_1'] ?? 'Pelayanan Publik',
                    'title_2' => $settings['hero_title_2'] ?? 'Berbasis Digital Cepat & Transparan',
                    'subtitle' => $settings['hero_subtitle'] ?? 'Kini administrasi kependudukan lebih cepat dan transparan melalui integrasi digital.',
                    'background' => $settings['hero_background'] ?? '',
                ]
            ];
        }
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden"
         x-data="heroBannerManager({{ json_encode($rawHeroSlides) }}, '{{ $heroMode }}')">
        <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Hero Banner Utama (Top Header Beranda)</h3>
                    <p class="text-slate-500 text-xs">Pengaturan mode banner (Slide Carousel vs Statis/Tunggal), judul utama, slogan, dan gambar latar belakang.</p>
                </div>
            </div>
        </div>
        <div class="p-6 md:p-8 space-y-6">

            <!-- Mode Selector Switch -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Pilihan Mode Tampilan Hero Banner</label>
                <input type="hidden" name="hero_banner_mode" :value="mode">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Mode Slider Carousel -->
                    <div @click="mode = 'slider'"
                         :class="mode === 'slider' ? 'border-emerald-500 bg-emerald-50/40 ring-2 ring-emerald-500/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                         class="p-4 rounded-2xl border-2 transition cursor-pointer flex items-start gap-3.5">
                        <div :class="mode === 'slider' ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-400'"
                             class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center font-bold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-slate-800">Mode Slide Carousel</span>
                                <span class="px-2 py-0.5 text-[10px] font-extrabold bg-emerald-100 text-emerald-700 rounded-md">Multi Slide</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Menampilkan beberapa banner bergantian secara otomatis dengan navigasi panah & titik indikator.</p>
                        </div>
                    </div>

                    <!-- Mode Statis / Single Banner -->
                    <div @click="mode = 'static'"
                         :class="mode === 'static' ? 'border-blue-500 bg-blue-50/40 ring-2 ring-blue-500/20' : 'border-slate-200 bg-white hover:border-slate-300'"
                         class="p-4 rounded-2xl border-2 transition cursor-pointer flex items-start gap-3.5">
                        <div :class="mode === 'static' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400'"
                             class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center font-bold transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-slate-800">Mode Statis (Tunggal)</span>
                                <span class="px-2 py-0.5 text-[10px] font-extrabold bg-blue-100 text-blue-700 rounded-md">Tidak Slide</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Menampilkan 1 gambar latar belakang & teks banner utama tetap tanpa rotasi animasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice for Static Mode -->
            <div x-show="mode === 'static'" class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs flex items-center gap-3" x-cloak>
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Pada Mode Statis, hanya <strong>Slide 1</strong> yang akan ditayangkan sebagai banner utama di Beranda Publik.</span>
            </div>

            <!-- Slides List -->
            <div class="space-y-6">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="p-6 bg-slate-50/80 border border-slate-200 rounded-2xl relative space-y-5 transition shadow-xs">
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white text-xs font-bold flex items-center justify-center" x-text="index + 1"></span>
                                <span class="font-bold text-slate-800 text-sm" x-text="'Slide Banner #' + (index + 1)"></span>
                                <span x-show="index === 0 && mode === 'static'" class="text-[10px] font-extrabold bg-blue-100 text-blue-700 px-2 py-0.5 rounded uppercase">Utama (Statis)</span>
                            </div>
                            <button type="button"
                                    x-show="slides.length > 1"
                                    @click="removeSlide(index)"
                                    class="text-xs text-red-600 hover:text-red-800 font-bold flex items-center gap-1 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg border border-red-200 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Slide
                            </button>
                        </div>

                        <!-- Tag Badge -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Lencana Tag Banner (Badge Atas)</label>
                            <input type="text"
                                   :name="'slides[' + index + '][tag]'"
                                   x-model="slide.tag"
                                   class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-semibold text-slate-800 bg-white"
                                   placeholder="Contoh: Program Unggulan Kelurahan">
                        </div>

                        <!-- Title 1 & Title 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Utama - Baris 1 (Teks Putih)</label>
                                <input type="text"
                                       :name="'slides[' + index + '][title_1]'"
                                       x-model="slide.title_1"
                                       class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-slate-800 bg-white"
                                       placeholder="Contoh: Pelayanan Publik">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Utama - Baris 2 (Teks Hijau Highlight)</label>
                                <input type="text"
                                       :name="'slides[' + index + '][title_2]'"
                                       x-model="slide.title_2"
                                       class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-bold text-emerald-700 bg-white"
                                       placeholder="Contoh: Berbasis Digital Cepat & Transparan">
                            </div>
                        </div>

                        <!-- Subtitle -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Singkat / Sub-Judul Banner</label>
                            <textarea :name="'slides[' + index + '][subtitle]'"
                                      x-model="slide.subtitle"
                                      rows="2"
                                      class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium text-slate-700 bg-white"
                                      placeholder="Kini administrasi kependudukan lebih cepat dan transparan..."></textarea>
                        </div>

                        <!-- Background Image -->
                        <div class="pt-2 border-t border-slate-200/60">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Gambar Background Slide #{ index + 1 }</label>
                            <input type="hidden" :name="'slides[' + index + '][background_old]'" :value="slide.background">
                            
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-5">
                                <div class="w-full md:w-56 h-28 rounded-xl border border-slate-200 bg-slate-900 overflow-hidden shrink-0 shadow-xs relative">
                                    <img :src="getSlideBgSrc(slide)" alt="Slide Background" class="w-full h-full object-cover opacity-85">
                                    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/40 to-transparent flex items-end p-2.5">
                                        <span class="text-[9px] text-emerald-400 font-bold bg-slate-900/90 px-2 py-0.5 rounded border border-slate-700">Preview Slide</span>
                                    </div>
                                </div>
                                <div class="flex-grow space-y-3.5 w-full">
                                    <div>
                                        <span class="text-[11px] font-semibold text-slate-600 mb-1 block">Opsi A: Unggah File Gambar Latar Belakang (HD 16:9) <span class="text-[9px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                                        <input type="file"
                                               :name="'slides[' + index + '][background_file]'"
                                               accept="image/*"
                                               @change="previewSlideFile($event, index)"
                                               class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-semibold text-slate-600 mb-1 block">Opsi B: Atau Tempel Link/URL Gambar (HTTP/HTTPS)</span>
                                        <input type="url"
                                               :name="'slides[' + index + '][background_url]'"
                                               x-model="slide.background_url"
                                               @change="validateImageUrlInput($event.target)"
                                               @blur="validateImageUrlInput($event.target)"
                                               class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono bg-white"
                                               placeholder="https://images.unsplash.com/photo-example.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Add Slide Button (only shown when mode is 'slider') -->
            <div x-show="mode === 'slider'" class="pt-2" x-cloak>
                <button type="button"
                        @click="addSlide()"
                        class="w-full py-3.5 bg-slate-50 hover:bg-emerald-50/50 border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl font-bold text-slate-700 hover:text-emerald-700 text-xs flex items-center justify-center gap-2 transition cursor-pointer shadow-xs">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Slide Hero Banner Baru
                </button>
            </div>
        </div>
    </div>

    <!-- Section 3: Sambutan Lurah / Pimpinan -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Sambutan Lurah & Pimpinan Kelurahan</h3>
                    <p class="text-slate-500 text-xs">Profil singkat pimpinan yang tampil pada Seksi Sambutan Beranda Utama.</p>
                </div>
            </div>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap Lurah / Pimpinan</label>
                    <input type="text" name="kadin_name" value="{{ $settings['kadin_name'] ?? $settings['lurah_name'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-slate-800">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jabatan Resmi</label>
                    <input type="text" name="kadin_title" value="{{ $settings['kadin_title'] ?? $settings['lurah_title'] ?? 'LURAH SIDOMUKTI' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-emerald-700">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Foto Resmi Lurah / Pimpinan</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <div class="w-24 h-32 rounded-2xl border-2 border-slate-200 bg-slate-100 overflow-hidden shrink-0 shadow-xs">
                        @php
                            $kadinVal = $settings['kadin_photo'] ?? $settings['foto_lurah'] ?? '';
                            $kadinSrc = $kadinVal ? (\Illuminate\Support\Str::startsWith($kadinVal, ['http://', 'https://']) ? $kadinVal : Storage::url($kadinVal)) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop';
                        @endphp
                        <img id="previewKadinPhoto" src="{{ $kadinSrc }}" alt="Foto Lurah Saat Ini" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow space-y-3">
                        <div>
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">Opsi A: Unggah Berkas Foto Pimpinan <span class="text-[10px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                            <div class="flex items-center gap-2">
                                <input type="file" name="kadin_photo" id="kadin_photo" data-ratio="1:1" data-preview="#previewKadinPhoto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 transition cursor-pointer">
                                <button type="button" onclick="window.CropHelper && window.CropHelper.open(document.getElementById('kadin_photo'))" class="shrink-0 text-xs text-purple-700 bg-purple-50 hover:bg-purple-100 font-semibold px-3 py-2 rounded-xl border border-purple-200 transition inline-flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                                    Potong
                                </button>
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-600 mb-1 block">Opsi B: Atau Tempel Link/URL Foto Pimpinan (HTTP/HTTPS)</span>
                            <input type="url" name="kadin_photo_url" value="{{ \Illuminate\Support\Str::startsWith($kadinVal, ['http://', 'https://']) ? $kadinVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" oninput="if(this.value){ document.getElementById('previewKadinPhoto').src = this.value; }" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-mono" placeholder="https://images.unsplash.com/photo-lurah.jpg">
                        </div>
                        @if(isset($settings['kadin_photo']) && $settings['kadin_photo'])
                        <div class="pt-1">
                            <button type="submit" form="destroy-kadin-photo-form" onclick="return confirm('Yakin ingin menghapus foto pimpinan dan memakai foto bawaan?')" class="text-xs text-red-600 hover:text-red-800 font-bold underline flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Reset Foto Pimpinan ke Default
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-4">
                <div>
                    <label for="sambutan_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Utama Sambutan</label>
                    <input type="text" name="sambutan_title" id="sambutan_title" value="{{ $settings['sambutan_title'] ?? 'Melayani Warga Sepenuh Hati Menuju Kelurahan yang Maju, Sejahtera & Mandiri' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-slate-800" placeholder="Judul Utama Sambutan...">
                </div>

                <div>
                    <label for="sambutan_isi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Narasi Sambutan Lurah</label>
                    <textarea name="sambutan_isi" id="sambutan_isi" rows="8" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs text-sm leading-relaxed" placeholder="Tuliskan isi teks sambutan di sini...">{{ $settings['sambutan_isi'] ?? 'Selamat Datang di Portal Resmi KELURAHAN SIDOMUKTI Kecamatan Kraksaan, Kabupaten Probolinggo. Kami berkomitmen menyajikan pelayanan publik prima, kemudahan administrasi kependudukan dan pengurusan surat keterangan, transparansi kinerja kelurahan, serta pemberdayaan potensi ekonomi warga lokal.' }}</textarea>
                    <p class="text-xs text-slate-400 mt-1.5">Mendukung pemformatan teks tebal, miring, paragraf, dan daftar poin.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: Statistik Ringkas Beranda (Floating Stat Bar) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-slate-800 text-base">Statistik Ringkas Beranda (Floating Stat Bar)</h3>
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-extrabold rounded-md uppercase">Terintegrasi Monografi</span>
                    </div>
                    <p class="text-slate-500 text-xs">Angka statistik pencapaian & data kependudukan yang tampil melayang di bawah banner beranda.</p>
                </div>
            </div>
        </div>
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jumlah Penduduk (Jiwa)</label>
                    <div class="relative">
                        <input type="number" name="demografi_total" value="{{ $settings['demografi_total'] ?? ($settings['jumlah_penduduk'] ?? '2776') }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-slate-800">
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-semibold">Jiwa</span>
                    </div>
                    <p class="text-[10.5px] text-slate-400 mt-1">Sinkron dengan Statistik & Monografi</p>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jumlah Kepala Keluarga (KK)</label>
                    <div class="relative">
                        <input type="number" name="demografi_kk" value="{{ $settings['demografi_kk'] ?? '850' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-slate-800">
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-semibold">KK</span>
                    </div>
                    <p class="text-[10.5px] text-slate-400 mt-1">Sinkron dengan Statistik & Monografi</p>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Penduduk Laki-Laki (Jiwa)</label>
                    <div class="relative">
                        <input type="number" name="demografi_laki" value="{{ $settings['demografi_laki'] ?? '1402' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-slate-800">
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-semibold">Jiwa</span>
                    </div>
                    <p class="text-[10.5px] text-slate-400 mt-1">Sinkron dengan Statistik & Monografi</p>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Penduduk Perempuan (Jiwa)</label>
                    <div class="relative">
                        <input type="number" name="demografi_perempuan" value="{{ $settings['demografi_perempuan'] ?? '1374' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-bold text-slate-800">
                        <span class="absolute right-4 top-2.5 text-xs text-slate-400 font-semibold">Jiwa</span>
                    </div>
                    <p class="text-[10.5px] text-slate-400 mt-1">Sinkron dengan Statistik & Monografi</p>
                </div>
            </div>
        </div>
    </div>





    <!-- Sticky Bottom Submit Bar -->
    <div class="sticky bottom-4 z-40 bg-slate-900/90 backdrop-blur-md text-white p-4 rounded-2xl shadow-2xl border border-slate-700 flex items-center justify-between">
        <div class="hidden sm:flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>
            <span class="text-xs text-slate-300 font-medium">Perubahan akan langsung memperbarui Beranda & Footer Website Publik.</span>
        </div>
        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-emerald-900/30 transition flex items-center justify-center gap-2 cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Perubahan Pengaturan
        </button>
    </div>
</form>

{{-- Hidden Forms for Image Resets --}}
@if(isset($settings['logo_kelurahan']) && $settings['logo_kelurahan'])
<form id="destroy-logo-form" action="{{ route('dashboard.settings.destroy', 'logo_kelurahan') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(isset($settings['hero_background']) && $settings['hero_background'])
<form id="destroy-hero-bg-form" action="{{ route('dashboard.settings.destroy', 'hero_background') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(isset($settings['login_background']) && $settings['login_background'])
<form id="destroy-login-bg-form" action="{{ route('dashboard.settings.destroy', 'login_background') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(isset($settings['kadin_photo']) && $settings['kadin_photo'])
<form id="destroy-kadin-photo-form" action="{{ route('dashboard.settings.destroy', 'kadin_photo') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
    window.validateImageUrlInput = function(input) {
        const val = input.value ? input.value.trim() : '';
        if (!val) return true;

        const isImageUrl = /^https?:\/\/.+/i.test(val) && /\.(jpe?g|png|webp|gif|svg)($|\?|#)/i.test(val);
        if (!isImageUrl) {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            alert('🚫 AKSES DITOLAK!\n\nTautan URL foto \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan URL berkas Foto / Gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg) yang diperbolehkan!');
            return false;
        }
        return true;
    };

    window.validateSettingsIndexForm = function(form) {
        const fileInputs = form.querySelectorAll('input[type="file"][accept*="image"]');
        for (let input of fileInputs) {
            if (input.files && input.files.length > 0) {
                if (!validateImageUpload(input)) {
                    return false;
                }
            }
        }

        const urlInputs = ['logo_kelurahan_url', 'login_background_url', 'kadin_photo_url'];
        for (let name of urlInputs) {
            const input = form.querySelector(`input[name="${name}"]`);
            if (input && input.value.trim() !== '') {
                if (!validateImageUrlInput(input)) {
                    return false;
                }
            }
        }

        return true;
    };

    function heroBannerManager(initialSlides, initialMode) {
        return {
            mode: initialMode || 'slider',
            slides: (initialSlides && initialSlides.length > 0) ? initialSlides.map(s => {
                let bgUrl = s.background_url || '';
                if (!bgUrl && s.background && (s.background.startsWith('http://') || s.background.startsWith('https://'))) {
                    bgUrl = s.background;
                }
                if (bgUrl.startsWith('data:image')) {
                    bgUrl = '';
                }
                let bgPath = s.background || '';
                if (bgPath.startsWith('data:image')) {
                    bgPath = '';
                }
                return {
                    tag: s.tag || 'Program Unggulan Kelurahan',
                    title_1: s.title_1 || '',
                    title_2: s.title_2 || '',
                    subtitle: s.subtitle || '',
                    background: bgPath,
                    background_url: bgUrl,
                    preview_src: (s.background && s.background.startsWith('data:image')) ? s.background : ''
                };
            }) : [
                {
                    tag: 'Program Unggulan Kelurahan',
                    title_1: 'Pelayanan Publik',
                    title_2: 'Berbasis Digital Cepat & Transparan',
                    subtitle: 'Kini administrasi kependudukan lebih cepat dan transparan melalui integrasi digital.',
                    background: '',
                    background_url: '',
                    preview_src: ''
                }
            ],
            addSlide() {
                this.slides.push({
                    tag: 'Program Unggulan Kelurahan',
                    title_1: 'Judul Utama Baris 1',
                    title_2: 'Judul Utama Baris 2',
                    subtitle: 'Deskripsi singkat hero banner...',
                    background: '',
                    background_url: '',
                    preview_src: ''
                });
            },
            removeSlide(index) {
                if (this.slides.length <= 1) {
                    alert('Minimal harus ada 1 slide banner.');
                    return;
                }
                this.slides.splice(index, 1);
            },
            getSlideBgSrc(slide) {
                if (slide.preview_src) {
                    return slide.preview_src;
                }
                if (slide.background_url && (slide.background_url.startsWith('http://') || slide.background_url.startsWith('https://'))) {
                    return slide.background_url;
                }
                if (slide.background) {
                    if (slide.background.startsWith('http://') || slide.background.startsWith('https://')) {
                        return slide.background;
                    }
                    return '/storage/' + slide.background;
                }
                return '/hero-bg.jpg';
            },
            previewSlideFile(event, index) {
                const file = event.target.files[0];
                if (file) {
                    if (!validateImageUpload(event.target)) {
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.slides[index].preview_src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#sambutan_isi',
                height: 320,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
                    'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link table | preview fullscreen code',
                content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #334155; } ol { list-style-type: decimal; padding-left: 1.5rem; } ul { list-style-type: disc; padding-left: 1.5rem; } li { margin-bottom: 0.375rem; }',
                branding: false,
                promotion: false,
                setup: function (editor) {
                    editor.on('change keyup blur', function () {
                        editor.save();
                    });
                }
            });
        }
    });
</script>
@endpush
