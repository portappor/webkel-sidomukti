<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-24">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Kelurahan Sidomukti</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="https://upload.wikimedia.org/wikipedia/commons/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg">
    <!-- Tailwind CSS (CDN for compatibility) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
        }
        .marquee-content {
            display: inline-block;
            animation: marquee 25s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .mask-image-gradient {
            -webkit-mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
            mask-image: linear-gradient(to bottom, black 40%, transparent 100%);
        }

        /* === Scroll Reveal Animations === */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.85); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes progressBar {
            from { width: 0; }
        }
        .reveal { opacity: 0; }
        .reveal.revealed {
            animation-fill-mode: both;
        }
        .reveal.revealed.fade-up { animation: fadeInUp 0.7s ease-out both; }
        .reveal.revealed.fade-left { animation: fadeInLeft 0.7s ease-out both; }
        .reveal.revealed.fade-right { animation: fadeInRight 0.7s ease-out both; }
        .reveal.revealed.scale-in { animation: scaleIn 0.6s ease-out both; }

        /* Hero entry animations */
        @keyframes heroFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hero-animate { animation: heroFadeIn 0.8s ease-out both; }
        .hero-animate-delay-1 { animation-delay: 0.15s; }
        .hero-animate-delay-2 { animation-delay: 0.3s; }
        .hero-animate-delay-3 { animation-delay: 0.45s; }
        .hero-animate-delay-4 { animation-delay: 0.6s; }

        /* Announcement Ticker */
        .ticker-wrap {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            mask-image: linear-gradient(to right, transparent 0%, black 28px, black calc(100% - 28px), transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 28px, black calc(100% - 28px), transparent 100%);
        }
        .ticker-content {
            display: inline-block;
            white-space: nowrap;
            animation: ticker 40s linear infinite;
        }
        .ticker-content:hover {
            animation-play-state: paused;
        }
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Lightbox */
        .lightbox-overlay {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* Progress bar animation */
        .progress-animated {
            animation: progressBar 1.5s ease-out both;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">



    @php
        $logoKelurahan = \App\Models\Setting::where('key', 'logo_kelurahan')->value('value');
        $logoUrl = !empty($logoKelurahan) 
            ? (\Illuminate\Support\Str::startsWith($logoKelurahan, ['http://', 'https://']) ? $logoKelurahan : Storage::url($logoKelurahan)) 
            : 'https://upload.wikimedia.org/wikipedia/commons/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg';
    @endphp

    <!-- Main Navigation -->
    <header class="sticky top-0 z-50 flex flex-col w-full shadow-sm">
        <!-- Top Bar -->
        <div class="bg-[#0c1324] border-b border-slate-800/80 text-slate-300 text-[11.5px] py-2 hidden lg:block w-full font-medium">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <!-- Left: Contact & Operational Hours -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5">
                        <div class="w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <span class="text-emerald-400 font-bold uppercase tracking-wider text-[10.5px]">Hotline:</span>
                        <span class="text-slate-200 font-semibold">{{ $settings['telepon'] ?? '(0335) 123456' }}</span>
                    </div>

                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['wa_number'] ?? '6281234567890') }}" target="_blank" class="flex items-center gap-1.5 text-slate-300 hover:text-emerald-400 transition-colors">
                        <div class="w-5 h-5 rounded-full bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981z"/></svg>
                        </div>
                        <span class="text-slate-300 hover:text-emerald-300 font-semibold">{{ $settings['telepon_wa'] ?? '0812-3456-7890' }}</span>
                    </a>

                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>

                    <div class="flex items-center gap-1.5 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Sen - Jum: 07.30 - 15.30 WIB</span>
                    </div>
                </div>

                <!-- Right: Date & Accessibility -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1.5 text-slate-400 text-[11px]">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <span class="h-3.5 w-[1px] bg-slate-800"></span>

                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 text-[11px]">Aksesibilitas:</span>
                        <div class="inline-flex items-center bg-slate-800/80 rounded-lg p-0.5 border border-slate-700/60">
                            <button class="px-2 py-0.5 rounded text-[10px] font-bold text-slate-300 hover:text-white hover:bg-slate-700 transition" title="Ukuran Normal">A</button>
                            <button class="px-2 py-0.5 rounded text-[10px] font-bold text-slate-300 hover:text-white hover:bg-slate-700 transition" title="Perbesar Teks">A+</button>
                            <button class="px-2 py-0.5 rounded text-[10px] font-bold text-slate-300 hover:text-white hover:bg-slate-700 transition flex items-center gap-1" title="Mode Kontras">
                                <svg class="w-3 h-3 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8v16z"/></svg>
                                <span>Kontras</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Nav -->
        <div class="bg-white w-full border-b border-gray-100">
            <nav class="container mx-auto px-4 py-3 flex justify-between items-center" x-data="{ mobileMenuOpen: false }">
                <!-- Logo Kelurahan -->
                <a href="/" class="flex items-center gap-3 shrink-0">
                    <img src="{{ $logoUrl }}" alt="Logo Kelurahan" class="w-10 h-10 md:w-12 md:h-12 object-contain">
                    <div class="flex flex-col border-l-[3px] border-[#008c5f] pl-3">
                        <h1 class="font-extrabold text-slate-800 text-[13px] md:text-[15px] uppercase tracking-tight leading-tight">Kelurahan Sidomukti</h1>
                        <p class="text-[10px] md:text-[11px] text-[#008c5f] font-bold uppercase tracking-wide mt-0.5 leading-tight">Kecamatan Kraksaan, Kabupaten Probolinggo</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <ul class="hidden lg:flex items-center gap-1 xl:gap-2 tracking-normal ml-auto flex-1 justify-end mr-3"
                    x-data="{ active: window.location.hash || window.location.pathname }"
                    @hashchange.window="active = window.location.hash || window.location.pathname">
                    
                    <!-- Home -->
                    <li>
                        <a href="{{ route('home') }}" 
                           @click="active = '/'"
                           :class="(active === '/' || active === '') && !window.location.hash ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50 font-bold'"
                           class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center">
                            Home
                        </a>
                    </li>
                    
                    <!-- Profil Dropdown -->
                    <li class="relative group" x-data="{ profilDropdown: false }" @mouseenter="profilDropdown = true" @mouseleave="profilDropdown = false">
                        <button :class="(profilDropdown || active.includes('/profil')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50 font-bold'"
                                class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center gap-1 cursor-pointer">
                            <span>Profil</span>
                            <svg class="w-3 h-3 transition-transform duration-200" :class="profilDropdown ? 'rotate-180 text-[#008c5f]' : 'text-slate-400 group-hover:text-[#008c5f]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="profilDropdown" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 transform origin-top-left z-50 mt-2 space-y-0.5" style="display: none;">
                            <a href="{{ route('profil.visi-misi') }}" @click="active = '/profil/visi-misi'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Visi & Misi</a>
                            <a href="{{ route('profil.struktur') }}" @click="active = '/profil/struktur-organisasi'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Struktur Organisasi</a>
                            <a href="{{ route('profil.sejarah') }}" @click="active = '/profil/sejarah'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Sejarah Kelurahan</a>
                        </div>
                    </li>

                    <!-- Layanan Dropdown -->
                    <li class="relative group" x-data="{ layananDropdown: false }" @mouseenter="layananDropdown = true" @mouseleave="layananDropdown = false">
                        <button :class="(layananDropdown || active.includes('/layanan')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50 font-bold'"
                                class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center gap-1 cursor-pointer">
                            <span>Layanan</span>
                            <svg class="w-3 h-3 transition-transform duration-200" :class="layananDropdown ? 'rotate-180 text-[#008c5f]' : 'text-slate-400 group-hover:text-[#008c5f]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="layananDropdown" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-80 md:w-[380px] bg-white rounded-2xl shadow-2xl border border-slate-100 p-2.5 transform origin-top-left z-50 mt-2" style="display: none;">
                            
                            <div class="px-3 py-2 border-b border-slate-100 mb-1 flex items-center justify-between">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-800">Standar Pelayanan & SOP</span>
                                <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">12 Dokumen</span>
                            </div>

                            <div class="max-h-[420px] overflow-y-auto space-y-0.5 pr-1">
                                <a href="{{ route('services.show', 'standar-pelayanan-publik-kelurahan') }}" @click="active = '/layanan/standar-pelayanan-publik-kelurahan'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>Standar Pelayanan Publik Kelurahan</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-usaha-sku') }}" @click="active = '/layanan/sop-pelayanan-surat-keterangan-usaha-sku'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Surat Keterangan Usaha (SKU)</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-tidak-mampu-sktm') }}" @click="active = '/layanan/sop-pelayanan-surat-keterangan-tidak-mampu-sktm'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Surat Keterangan Tidak Mampu (SKTM)</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-domisili') }}" @click="active = '/layanan/sop-pelayanan-surat-keterangan-domisili'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Surat Keterangan Domisili</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-pengantar-nikah-n1-n4') }}" @click="active = '/layanan/sop-pelayanan-pengantar-nikah-n1-n4'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Pengantar Nikah (N1–N4)</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-pengantar-ktp-el-kartu-keluarga') }}" @click="active = '/layanan/sop-pelayanan-pengantar-ktp-el-kartu-keluarga'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Pengantar KTP-el & KK</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-kelahiran-kematian') }}" @click="active = '/layanan/sop-pelayanan-surat-keterangan-kelahiran-kematian'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Surat Ket. Kelahiran & Kematian</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-pengantar-skck') }}" @click="active = '/layanan/sop-pelayanan-pengantar-skck'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Pengantar SKCK</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-pindah-datang') }}" @click="active = '/layanan/sop-pelayanan-surat-keterangan-pindah-datang'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Surat Keterangan Pindah / Datang</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-belum-menikah-janda-duda') }}" @click="active = '/layanan/sop-pelayanan-surat-keterangan-belum-menikah-janda-duda'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Pelayanan Surat Belum Menikah / Janda / Duda</span>
                                </a>
                                <a href="{{ route('services.show', 'sop-penanganan-pengaduan-dan-aspirasi-warga') }}" @click="active = '/layanan/sop-penanganan-pengaduan-dan-aspirasi-warga'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>SOP Penanganan Pengaduan dan Aspirasi Warga</span>
                                </a>
                                <a href="{{ route('services.show', 'alur-dan-petunjuk-teknis-permohonan-surat-online') }}" @click="active = '/layanan/alur-dan-petunjuk-teknis-permohonan-surat-online'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>Alur dan Juknis Permohonan Surat</span>
                                </a>
                            </div>

                            <div class="pt-2 border-t border-slate-100 mt-1">
                                <a href="{{ route('services.index') }}" @click="active = '/layanan'" class="block py-2 text-center text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100/80 rounded-xl transition-colors">
                                    Lihat Semua Dokumen SOP (12) →
                                </a>
                            </div>
                        </div>
                    </li>

                    <!-- Dokumen Dropdown -->
                    <li class="relative group" x-data="{ dokumenDropdown: false }" @mouseenter="dokumenDropdown = true" @mouseleave="dokumenDropdown = false">
                        <button :class="(dokumenDropdown || active.includes('/dokumen') || active.includes('/transparansi')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50 font-bold'"
                                class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center gap-1 cursor-pointer">
                            <span>Dokumen</span>
                            <svg class="w-3 h-3 transition-transform duration-200" :class="dokumenDropdown ? 'rotate-180 text-[#008c5f]' : 'text-slate-400 group-hover:text-[#008c5f]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="dokumenDropdown" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-60 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 transform origin-top-left z-50 mt-2 space-y-0.5" style="display: none;">
                            <a href="{{ route('documents.musrenbang') }}" @click="active = '/dokumen/musrenbang'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                Musrenbang
                            </a>
                            <a href="{{ route('documents.renstra_renja') }}" @click="active = '/dokumen/renstra-renja'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                Renstra & Renja
                            </a>
                            <a href="{{ route('documents.sk_kelembagaan') }}" @click="active = '/dokumen/sk-kelembagaan'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                SK Kelembagaan
                            </a>
                        </div>
                    </li>

                    <!-- Informasi Dropdown -->
                    <li class="relative group" x-data="{ infoDropdown: false }" @mouseenter="infoDropdown = true" @mouseleave="infoDropdown = false">
                        <button :class="(infoDropdown || active.includes('/berita') || active.includes('/galeri') || active.includes('/video') || active.includes('/profil/demografi') || active.includes('/agenda') || active.includes('/lembaga')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50 font-bold'"
                                class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center gap-1 cursor-pointer">
                            <span>Informasi</span>
                            <svg class="w-3 h-3 transition-transform duration-200" :class="infoDropdown ? 'rotate-180 text-[#008c5f]' : 'text-slate-400 group-hover:text-[#008c5f]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="infoDropdown" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-60 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 transform origin-top-left z-50 mt-2 space-y-0.5" style="display: none;">
                            <a href="{{ route('posts.index') }}" @click="active = '/berita'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Berita</a>
                            <a href="{{ route('galleries.index') }}" @click="active = '/galeri'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Galeri Album Foto</a>
                            <a href="{{ route('videos.index') }}" @click="active = '/video'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Video Dokumentasi</a>
                            <a href="{{ route('agendas.index') }}" @click="active = '/agenda'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Agenda Kegiatan</a>
                            <a href="{{ route('lembaga.index') }}" @click="active = '/lembaga'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Lembaga Kemasyarakatan</a>
                            <a href="{{ route('profil.demografi') }}" @click="active = '/profil/demografi'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Statistik & Monografi</a>
                        </div>
                    </li>

                    <!-- Hubungi Dropdown -->
                    <li class="relative group" x-data="{ hubungiDropdown: false }" @mouseenter="hubungiDropdown = true" @mouseleave="hubungiDropdown = false">
                        <button :class="(hubungiDropdown || active.includes('/hubungi')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50 font-bold'"
                                class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center gap-1 cursor-pointer">
                            <span>Hubungi</span>
                            <svg class="w-3 h-3 transition-transform duration-200" :class="hubungiDropdown ? 'rotate-180 text-[#008c5f]' : 'text-slate-400 group-hover:text-[#008c5f]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="hubungiDropdown" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute top-full left-0 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 transform origin-top-left z-50 mt-2 space-y-0.5" style="display: none;">
                            <a href="https://www.lapor.go.id" target="_blank" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                Lapor SP4N
                            </a>
                            <a href="https://wa.me/6282131001001" target="_blank" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                Hallo SAE
                            </a>
                            <a href="{{ route('contact') }}" @click="active = '/hubungi'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                Kontak Kami
                            </a>
                        </div>
                    </li>

                    <li class="hidden xl:flex items-center pl-2 pr-1">
                        <!-- BerAKHLAK logo -->
                        <img src="{{ asset('logo-berakhlak.png') }}" alt="BerAKHLAK" class="h-8 object-contain">
                    </li>
                </ul>
                
                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center gap-3 shrink-0 border-l border-slate-200 pl-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-[#008c5f] hover:bg-[#00734e] text-white font-extrabold text-[12px] uppercase px-4 py-2 rounded-xl transition-all duration-300 flex items-center gap-1.5 shadow-sm hover:shadow">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Panel Admin
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 font-bold text-[12px] uppercase px-2 py-2 transition-all flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#008c5f] hover:bg-[#00734e] text-white font-extrabold text-[12px] uppercase px-4 py-2 rounded-xl transition-all duration-300 flex items-center gap-1.5 shadow-sm hover:shadow">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-slate-800 focus:outline-none p-2 rounded-md hover:bg-slate-100 ml-auto">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" x-transition class="lg:hidden absolute top-[100%] left-0 w-full bg-white shadow-xl border-t py-2 flex flex-col font-bold text-sm text-slate-700 z-50 tracking-wide" style="display: none;">
                    <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="px-5 py-3 border-b border-slate-100 hover:bg-slate-50 hover:text-[#008c5f] uppercase">Home</a>
                    <div x-data="{ mobileProfil: false }" class="border-b border-slate-100">
                        <button @click="mobileProfil = !mobileProfil" class="w-full text-left px-5 py-3 flex justify-between items-center hover:bg-slate-50 hover:text-[#008c5f] uppercase">
                            Profil <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="mobileProfil" class="bg-slate-50 flex flex-col text-xs pl-8 pb-2" style="display: none;">
                            <a @click="mobileMenuOpen = false" href="{{ route('profil.visi-misi') }}" class="py-2 hover:text-[#008c5f]">Visi & Misi</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('profil.struktur') }}" class="py-2 hover:text-[#008c5f]">Struktur Organisasi</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('profil.sejarah') }}" class="py-2 hover:text-[#008c5f]">Sejarah Kelurahan</a>
                        </div>
                    </div>
                    <div x-data="{ mobileLayanan: false }" class="border-b border-slate-100">
                        <button @click="mobileLayanan = !mobileLayanan" class="w-full text-left px-5 py-3 flex justify-between items-center hover:bg-slate-50 hover:text-[#008c5f] uppercase">
                            Standar Pelayanan & SOP <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="mobileLayanan" class="bg-slate-50 flex flex-col text-xs pl-8 pb-3 pr-4 space-y-1" style="display: none;">
                            <a @click="mobileMenuOpen = false" href="{{ route('services.index') }}" class="py-1.5 font-bold text-emerald-700 hover:text-[#008c5f]">→ Indeks Semua Dokumen SOP</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'standar-pelayanan-publik-kelurahan') }}" class="py-1.5 hover:text-[#008c5f]">Standar Pelayanan Publik Kelurahan</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-usaha-sku') }}" class="py-1.5 hover:text-[#008c5f]">SOP Surat Keterangan Usaha (SKU)</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-tidak-mampu-sktm') }}" class="py-1.5 hover:text-[#008c5f]">SOP Surat Keterangan Tidak Mampu (SKTM)</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-domisili') }}" class="py-1.5 hover:text-[#008c5f]">SOP Surat Keterangan Domisili</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-pengantar-nikah-n1-n4') }}" class="py-1.5 hover:text-[#008c5f]">SOP Pengantar Nikah (N1–N4)</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-pengantar-ktp-el-kartu-keluarga') }}" class="py-1.5 hover:text-[#008c5f]">SOP Pengantar KTP-el & KK</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-kelahiran-kematian') }}" class="py-1.5 hover:text-[#008c5f]">SOP Surat Kelahiran & Kematian</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-pengantar-skck') }}" class="py-1.5 hover:text-[#008c5f]">SOP Pengantar SKCK</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-pindah-datang') }}" class="py-1.5 hover:text-[#008c5f]">SOP Surat Keterangan Pindah / Datang</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-pelayanan-surat-keterangan-belum-menikah-janda-duda') }}" class="py-1.5 hover:text-[#008c5f]">SOP Surat Belum Menikah / Janda / Duda</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'sop-penanganan-pengaduan-dan-aspirasi-warga') }}" class="py-1.5 hover:text-[#008c5f]">SOP Penanganan Pengaduan Warga</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', 'alur-dan-petunjuk-teknis-permohonan-surat-online') }}" class="py-1.5 hover:text-[#008c5f]">Alur dan Juknis Permohonan Surat</a>
                        </div>
                    </div>
                    <div x-data="{ mobileDokumen: false }" class="border-b border-slate-100">
                        <button @click="mobileDokumen = !mobileDokumen" class="w-full text-left px-5 py-3 flex justify-between items-center hover:bg-slate-50 hover:text-[#008c5f] uppercase">
                            Dokumen <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="mobileDokumen" class="bg-slate-50 flex flex-col text-xs pl-8 pb-2" style="display: none;">
                            <a @click="mobileMenuOpen = false" href="{{ route('documents.musrenbang') }}" class="py-2 hover:text-[#008c5f]">Musrenbang</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('documents.renstra_renja') }}" class="py-2 hover:text-[#008c5f]">Renstra & Renja</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('documents.sk_kelembagaan') }}" class="py-2 hover:text-[#008c5f]">SK Kelembagaan</a>
                        </div>
                    </div>
                    <div x-data="{ mobileInfo: false }" class="border-b border-slate-100">
                        <button @click="mobileInfo = !mobileInfo" class="w-full text-left px-5 py-3 flex justify-between items-center hover:bg-slate-50 hover:text-[#008c5f] uppercase">
                            Informasi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="mobileInfo" class="bg-slate-50 flex flex-col text-xs pl-8 pb-2" style="display: none;">
                            <a @click="mobileMenuOpen = false" href="{{ route('posts.index') }}" class="py-2 hover:text-[#008c5f]">Berita</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('galleries.index') }}" class="py-2 hover:text-[#008c5f]">Galeri Album Foto</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('videos.index') }}" class="py-2 hover:text-[#008c5f]">Video Dokumentasi</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('agendas.index') }}" class="py-2 hover:text-[#008c5f]">Agenda Kegiatan</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('lembaga.index') }}" class="py-2 hover:text-[#008c5f]">Lembaga Kemasyarakatan</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('profil.demografi') }}" class="py-2 hover:text-[#008c5f]">Statistik & Monografi</a>
                        </div>
                    </div>
                    <div x-data="{ mobileHubungi: false }" class="border-b border-slate-100">
                        <button @click="mobileHubungi = !mobileHubungi" class="w-full text-left px-5 py-3 flex justify-between items-center hover:bg-slate-50 hover:text-[#008c5f] uppercase">
                            Hubungi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="mobileHubungi" class="bg-slate-50 flex flex-col text-xs pl-8 pb-2" style="display: none;">
                            <a @click="mobileMenuOpen = false" href="https://www.lapor.go.id" target="_blank" class="py-2 hover:text-[#008c5f]">Lapor SP4N</a>
                            <a @click="mobileMenuOpen = false" href="https://wa.me/6282131001001" target="_blank" class="py-2 hover:text-[#008c5f]">Hallo SAE</a>
                            <a @click="mobileMenuOpen = false" href="{{ route('contact') }}" class="py-2 hover:text-[#008c5f]">Kontak Kami</a>
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-3 bg-[#008c5f] text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Panel Admin</a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-3 bg-red-600 text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg> Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-3 bg-[#008c5f] text-white flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg> Login Admin</a>
                    @endauth
                </div>
            </nav>
        </div>

        <!-- Announcement Ticker -->
        @if(isset($announcements) && $announcements->count() > 0)
        <div class="bg-slate-50/95 border-b border-slate-200/80 text-slate-800 relative z-30 w-full py-2 backdrop-blur-sm shadow-[0_1px_2px_rgba(0,0,0,0.02)]">
            <div class="container mx-auto px-4 flex items-center">
                <div class="bg-[#008c5f] text-white px-3.5 py-1.5 rounded-xl font-extrabold text-[11px] uppercase tracking-wider shrink-0 flex items-center gap-2 shadow-sm z-10 relative">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-200 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    <span>Berita Terkini</span>
                </div>
                <div class="ticker-wrap flex-1 ml-4 text-sm relative">
                    <div class="ticker-content flex items-center">
                        @foreach($announcements as $ann)
                            <span class="inline-flex items-center gap-2 mr-10 text-[12.5px] font-semibold text-slate-700">
                                <span>{{ $ann->title }}</span>
                                <span class="bg-slate-200/80 text-slate-600 text-[10.5px] font-medium px-2 py-0.5 rounded-md">({{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }})</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block shrink-0 mx-2"></span>
                            </span>
                        @endforeach
                        {{-- Duplicate for seamless loop --}}
                        @foreach($announcements as $ann)
                            <span class="inline-flex items-center gap-2 mr-10 text-[12.5px] font-semibold text-slate-700">
                                <span>{{ $ann->title }}</span>
                                <span class="bg-slate-200/80 text-slate-600 text-[10.5px] font-medium px-2 py-0.5 rounded-md">({{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }})</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block shrink-0 mx-2"></span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </header>

    <!-- Main Content -->
    <main class="flex-grow bg-slate-50">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="kontak" class="bg-[#0B1220] text-slate-300 pt-16 pb-8 font-sans border-t-[6px] border-emerald-600">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                
                <!-- Box 1: Tentang & Sosial Media -->
                <div class="bg-[#121E31] rounded-3xl p-8 shadow-sm flex flex-col h-full border border-slate-800">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ $logoUrl }}" alt="Logo" class="w-12 h-12 object-contain bg-white rounded-lg p-1">
                        <h2 class="font-extrabold text-xl text-white">Kelurahan Sidomukti</h2>
                    </div>
                    <div class="h-[2px] w-full bg-emerald-500 mb-6"></div>
                    <p class="text-[13px] text-slate-400 leading-relaxed mb-8 flex-grow">
                        Website Resmi Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo - Portal Informasi Publik, Pelayanan Administrasi Kependudukan, Surat Keterangan Online, Berita, dan Pembangunan Kemasyarakatan.
                    </p>
                    
                    <div>
                        <h3 class="font-black text-xs text-white tracking-widest uppercase mb-3">Media Sosial</h3>
                        <div class="h-[2px] w-full bg-emerald-500 mb-4"></div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ $settings['instagram'] ?? '#' }}" class="w-9 h-9 rounded-full bg-slate-800/80 border border-slate-700 hover:bg-emerald-600 hover:border-emerald-500 flex items-center justify-center text-white transition-all" title="Instagram">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                            <a href="{{ $settings['youtube'] ?? '#' }}" class="w-9 h-9 rounded-full bg-slate-800/80 border border-slate-700 hover:bg-emerald-600 hover:border-emerald-500 flex items-center justify-center text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 00-2.122 2.136C0 8.07 0 12 0 12s0 3.93.498 5.814a3.016 3.016 0 002.122 2.136c1.872.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            <a href="{{ $settings['tiktok'] ?? '#' }}" class="w-9 h-9 rounded-full bg-slate-800/80 border border-slate-700 hover:bg-emerald-600 hover:border-emerald-500 flex items-center justify-center text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                            </a>
                            <a href="{{ $settings['whatsapp'] ?? '#' }}" class="w-9 h-9 rounded-full bg-slate-800/80 border border-slate-700 hover:bg-emerald-600 hover:border-emerald-500 flex items-center justify-center text-white transition-all">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Scan QR -->
                <div class="bg-[#121E31] rounded-3xl p-8 shadow-sm flex flex-col items-center text-center justify-center h-full border border-slate-800">
                    <h3 class="font-black text-[13px] text-white tracking-widest uppercase mb-4">Scan Kode QR</h3>
                    <div class="h-[2px] w-48 bg-emerald-500 mb-6"></div>
                    <div class="bg-white p-4 rounded-3xl mb-5 shadow-lg border-4 border-slate-100">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(url('/')) }}&margin=0" alt="QR Code" class="w-36 h-36 object-contain">
                    </div>
                    <div class="flex items-center gap-2 text-emerald-400 font-extrabold text-sm mb-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        Scan QR Portal Pelayanan
                    </div>
                    <p class="text-[11px] text-slate-500 uppercase tracking-wider">Kelurahan Sidomukti</p>
                </div>

                <!-- Box 3: Alamat Kantor -->
                <div class="bg-[#121E31] rounded-3xl p-8 shadow-sm flex flex-col h-full border border-slate-800">
                    <h2 class="font-extrabold text-xl text-white mb-4">Alamat Kantor</h2>
                    <div class="h-[2px] w-full bg-emerald-500 mb-6"></div>
                    
                    <ul class="space-y-6 text-[13px] text-slate-300 flex-grow font-medium">
                        <li class="flex items-start gap-4">
                            <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="leading-relaxed">{{ $settings['alamat'] ?? 'Jl. Raya Sidomukti No. 10, Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo, Jawa Timur 67282' }}</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>Telepon: {{ $settings['telepon'] ?? '(0335) 123456' }} <br> WhatsApp: {{ $settings['whatsapp'] ?? '0812 3456 7890' }}</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <svg class="w-5 h-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="break-all">Email: {{ $settings['email'] ?? 'info@sidomukti.desa.id' }}</span>
                        </li>
                    </ul>
                </div>
                
            </div>
            
            <!-- Bottom Copyright -->
            <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-slate-800">
                <div class="w-10 h-10 rounded-full bg-[#121E31] flex items-center justify-center text-slate-400 border border-slate-800 shadow-sm mb-4 md:mb-0 hover:text-emerald-400 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="text-[11px] text-slate-500 font-bold uppercase tracking-widest text-center md:text-right">
                    Kelurahan Sidomukti Kraksaan - Kabupaten Probolinggo &copy; {{ date('Y') }}. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Reveal Observer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.dataset.delay || 0;
                        setTimeout(() => {
                            entry.target.classList.add('revealed');
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            reveals.forEach(el => observer.observe(el));

            // Animated counters
            const counters = document.querySelectorAll('[data-count-to]');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.dataset.countTo);
                        const suffix = el.dataset.countSuffix || '';
                        const prefix = el.dataset.countPrefix || '';
                        const duration = 1500;
                        const start = 0;
                        const startTime = performance.now();
                        function update(currentTime) {
                            const elapsed = currentTime - startTime;
                            const progress = Math.min(elapsed / duration, 1);
                            const eased = 1 - Math.pow(1 - progress, 3);
                            const current = Math.floor(start + (target - start) * eased);
                            el.textContent = prefix + current.toLocaleString('id-ID') + suffix;
                            if (progress < 1) requestAnimationFrame(update);
                        }
                        requestAnimationFrame(update);
                        counterObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.3 });
            counters.forEach(el => counterObserver.observe(el));

            // Progress bar animation
            const bars = document.querySelectorAll('[data-progress]');
            const barObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.style.width = el.dataset.progress + '%';
                        el.classList.add('progress-animated');
                        barObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.3 });
            bars.forEach(el => barObserver.observe(el));
        });
    </script>

</body>
</html>
