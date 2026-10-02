@php
    $user = auth()->user();
    $userName = $user ? $user->name : 'Super Admin';
    $userRole = $user ? strtoupper($user->role) : 'ADMIN';
    $userInitial = strtoupper(substr($userName, 0, 1));

    // Group active route checkers for automatic accordion open state
    $isPelayananActive = request()->routeIs(['dashboard.services.*', 'dashboard.maklumats.*', 'dashboard.survei.*', 'dashboard.integrations.lapor', 'dashboard.integrations.hallo-sae']);
    $isPublikasiActive = request()->routeIs(['dashboard.posts.*', 'dashboard.announcements.*', 'dashboard.agendas.*', 'dashboard.galleries.*', 'dashboard.videos.*', 'dashboard.documents.*']);
    $isTransparansiActive = request()->routeIs(['dashboard.apbd.*', 'dashboard.demographics.*', 'dashboard.lembagas.*', 'dashboard.partnerships.*']);
    $isProfilActive = request()->routeIs(['dashboard.settings.visi-misi', 'dashboard.settings.sejarah', 'dashboard.settings.aparatur']);
    $isPengaturanActive = request()->routeIs(['dashboard.categories.*', 'dashboard.settings.index', 'dashboard.navigation.*', 'dashboard.integrations.contact-maps', 'dashboard.users.*', 'dashboard.activity-logs.*']);
@endphp

<style>
    .custom-sidebar-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-sidebar-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-sidebar-scrollbar::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 9999px;
    }
    .custom-sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }
</style>

<!-- Desktop Sidebar -->
<aside x-data="{
            openPelayanan: {{ $isPelayananActive ? 'true' : 'false' }},
            openPublikasi: {{ $isPublikasiActive ? 'true' : 'false' }},
            openTransparansi: {{ $isTransparansiActive ? 'true' : 'false' }},
            openProfil: {{ $isProfilActive ? 'true' : 'false' }},
            openPengaturan: {{ $isPengaturanActive ? 'true' : 'false' }}
       }"
       class="hidden lg:flex flex-col w-72 h-screen px-4 py-5 bg-slate-900 border-r border-slate-800/80 shrink-0 text-slate-300 select-none">

    <!-- 1. Header Sidebar: Branding -->
    <div class="px-2 pb-4 mb-3 border-b border-slate-800/80">
        <div class="flex items-center gap-3">
            <img src="{{ $app_logo }}"
                 class="w-9 h-9 object-contain bg-white rounded-xl p-1 shadow-sm shrink-0" alt="Logo Kelurahan">
            <div class="flex flex-col">
                <span class="text-white font-extrabold text-sm tracking-tight leading-none uppercase">Admin</span>
                <span class="text-emerald-400 font-bold text-[10px] tracking-wider uppercase mt-1">Kelurahan Sidomukti</span>
            </div>
        </div>
    </div>

    <!-- 2. Navigation List with Smooth Collapsible Accordions -->
    <nav class="flex-grow space-y-1 overflow-y-auto pr-1 custom-sidebar-scrollbar text-xs">

        <!-- Overview Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-500/15 text-emerald-400 font-bold border-l-2 border-emerald-400 shadow-xs shadow-emerald-500/20' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-xs">Overview Dashboard</span>
        </a>

        @if($userRole === 'ADMIN')
        <!-- 1. GROUP: PELAYANAN PUBLIK -->
        <div class="pt-2">
            <button @click="openPelayanan = !openPelayanan"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span class="font-extrabold text-[10.5px] uppercase tracking-wider text-slate-300">Pelayanan Publik</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" :class="openPelayanan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="openPelayanan" x-collapse class="pl-3.5 ml-4 mt-1 space-y-1 border-l-2 border-slate-800/80">
                <a href="{{ route('dashboard.services.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.services.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.services.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Standar Pelayanan & SOP</span>
                </a>

                <a href="{{ route('dashboard.maklumats.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.maklumats.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.maklumats.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Maklumat Pelayanan</span>
                </a>

                <a href="{{ route('dashboard.integrations.lapor') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.integrations.lapor') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.integrations.lapor') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Kelola SP4N-LAPOR!</span>
                </a>

                <a href="{{ route('dashboard.integrations.hallo-sae') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.integrations.hallo-sae') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.integrations.hallo-sae') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Layanan Hallo SAE (WA)</span>
                </a>
            </div>
        </div>
        @endif

        <!-- 2. GROUP: PUBLIKASI & ARSIP -->
        <div class="pt-1">
            <button @click="openPublikasi = !openPublikasi"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span class="font-extrabold text-[10.5px] uppercase tracking-wider text-slate-300">Publikasi & Arsip</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" :class="openPublikasi ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="openPublikasi" x-collapse class="pl-3.5 ml-4 mt-1 space-y-1 border-l-2 border-slate-800/80">
                <a href="{{ route('dashboard.posts.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.posts.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.posts.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Berita & Artikel</span>
                </a>

                <a href="{{ route('dashboard.announcements.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.announcements.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.announcements.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Pengumuman Running Text</span>
                </a>

                <a href="{{ route('dashboard.agendas.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.agendas.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.agendas.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Agenda Kegiatan</span>
                </a>

                <a href="{{ route('dashboard.galleries.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.galleries.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.galleries.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Galeri Album Foto</span>
                </a>

                <a href="{{ route('dashboard.videos.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.videos.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.videos.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Video Dokumentasi</span>
                </a>

                <a href="{{ route('dashboard.documents.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.documents.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.documents.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Dokumen PDF Publik</span>
                </a>
            </div>
        </div>

        @if($userRole === 'ADMIN')
        <!-- 3. GROUP: TRANSPARANSI & DATA -->
        <div class="pt-1">
            <button @click="openTransparansi = !openTransparansi"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span class="font-extrabold text-[10.5px] uppercase tracking-wider text-slate-300">Transparansi & Data</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" :class="openTransparansi ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="openTransparansi" x-collapse class="pl-3.5 ml-4 mt-1 space-y-1 border-l-2 border-slate-800/80">
                <a href="{{ route('dashboard.apbd.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.apbd.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.apbd.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>APBD & Transparansi Anggaran</span>
                </a>

                <a href="{{ route('dashboard.demographics.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.demographics.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.demographics.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Data & Monografi Penduduk</span>
                </a>

                <a href="{{ route('dashboard.lembagas.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.lembagas.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.lembagas.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Lembaga Kemasyarakatan</span>
                </a>

                <a href="{{ route('dashboard.partnerships.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.partnerships.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.partnerships.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Kelola Instansi</span>
                </a>
            </div>
        </div>

        <!-- 4. GROUP: PROFIL KELURAHAN -->
        <div class="pt-1">
            <button @click="openProfil = !openProfil"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="font-extrabold text-[10.5px] uppercase tracking-wider text-slate-300">Profil Kelurahan</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" :class="openProfil ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="openProfil" x-collapse class="pl-3.5 ml-4 mt-1 space-y-1 border-l-2 border-slate-800/80">
                <a href="{{ route('dashboard.settings.visi-misi') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.settings.visi-misi') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.settings.visi-misi') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Visi & Misi Kelurahan</span>
                </a>

                <a href="{{ route('dashboard.settings.sejarah') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.settings.sejarah') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.settings.sejarah') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Sejarah Kelurahan</span>
                </a>

                <a href="{{ route('dashboard.settings.aparatur') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.settings.aparatur') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.settings.aparatur') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Struktur & Aparatur</span>
                </a>

                <a href="{{ route('dashboard.settings.tugas-fungsi') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.settings.tugas-fungsi') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.settings.tugas-fungsi') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Tugas & Fungsi Kelurahan</span>
                </a>
            </div>
        </div>

        <!-- 5. GROUP: PENGATURAN & SISTEM -->
        <div class="pt-1">
            <button @click="openPengaturan = !openPengaturan"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200 cursor-pointer">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-extrabold text-[10.5px] uppercase tracking-wider text-slate-300">Pengaturan & Sistem</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" :class="openPengaturan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="openPengaturan" x-collapse class="pl-3.5 ml-4 mt-1 space-y-1 border-l-2 border-slate-800/80">
                <a href="{{ route('dashboard.categories.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.categories.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.categories.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Master Kategori Terpadu</span>
                </a>

                <a href="{{ route('dashboard.settings.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.settings.index') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.settings.index') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Banner Hero Beranda</span>
                </a>

                <a href="{{ route('dashboard.navigation.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.navigation.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.navigation.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Menu Navigasi (Navbar)</span>
                </a>

                <a href="{{ route('dashboard.integrations.contact-maps') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.integrations.contact-maps') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.integrations.contact-maps') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Informasi Kontak & Maps</span>
                </a>

                @if($user && $user->role === 'admin')
                <a href="{{ route('dashboard.users.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.users.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.users.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Pengguna & Hak Akses</span>
                </a>

                <a href="{{ route('dashboard.activity-logs.index') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-150 {{ request()->routeIs('dashboard.activity-logs.*') ? 'text-emerald-400 bg-emerald-500/15 font-bold border-l-2 border-emerald-400 shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('dashboard.activity-logs.*') ? 'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)]' : 'bg-slate-700' }}"></span>
                    <span>Log Aktivitas System</span>
                </a>
                @endif
            </div>
        </div>
        @endif

    </nav>

    <!-- 3. Logout Footer Button -->
    <div class="pt-3 border-t border-slate-800/80 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-rose-600 text-slate-300 hover:text-white font-bold text-xs transition duration-200 border border-slate-700/50 hover:border-rose-500 shadow-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Sidebar (Offcanvas) -->
<div class="lg:hidden relative z-50" x-show="sidebarOpen" style="display: none;" x-cloak>
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="sidebarOpen = false"></div>

    <aside x-show="sidebarOpen"
           x-transition:enter="transition ease-out duration-300 transform"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-300 transform"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           x-data="{
                openPelayanan: {{ $isPelayananActive ? 'true' : 'false' }},
                openPublikasi: {{ $isPublikasiActive ? 'true' : 'false' }},
                openTransparansi: {{ $isTransparansiActive ? 'true' : 'false' }},
                openProfil: {{ $isProfilActive ? 'true' : 'false' }},
                openPengaturan: {{ $isPengaturanActive ? 'true' : 'false' }}
           }"
           class="fixed inset-y-0 left-0 flex flex-col w-72 px-4 py-5 bg-slate-900 shadow-2xl text-slate-300 select-none">

        <!-- Branding Mobile & Close -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 px-1">
            <div class="flex items-center gap-3">
                <img src="{{ $app_logo }}" class="w-8 h-8 object-contain bg-white rounded-lg p-1" alt="Logo Kelurahan">
                <div class="flex flex-col">
                    <span class="text-white font-extrabold text-xs uppercase tracking-tight">Admin Panel</span>
                    <span class="text-emerald-400 font-bold text-[9px] uppercase tracking-wider">Kel. Sidomukti</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white p-1 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Mobile -->
        <nav class="flex-grow space-y-1.5 overflow-y-auto custom-sidebar-scrollbar py-4 pr-1 text-xs">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-500/15 text-emerald-400 font-bold border-l-2 border-emerald-400' : 'text-slate-300' }}">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Overview Dashboard</span>
            </a>

            @if($userRole === 'ADMIN')
            <!-- 1. Pelayanan Publik Mobile -->
            <div>
                <button @click="openPelayanan = !openPelayanan" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider cursor-pointer">
                    <span>Pelayanan Publik</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="openPelayanan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openPelayanan" x-collapse class="pl-3 ml-3.5 space-y-1 border-l-2 border-slate-800">
                    <a href="{{ route('dashboard.services.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.services.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Standar Pelayanan & SOP</a>
                    <a href="{{ route('dashboard.maklumats.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.maklumats.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Maklumat Pelayanan</a>
                    <a href="{{ route('dashboard.integrations.lapor') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.integrations.lapor') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Kelola SP4N-LAPOR!</a>
                    <a href="{{ route('dashboard.integrations.hallo-sae') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.integrations.hallo-sae') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Layanan Hallo SAE (WA)</a>
                </div>
            </div>
            @endif

            <!-- 2. Publikasi & Arsip Mobile -->
            <div>
                <button @click="openPublikasi = !openPublikasi" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider cursor-pointer">
                    <span>Publikasi & Arsip</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="openPublikasi ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openPublikasi" x-collapse class="pl-3 ml-3.5 space-y-1 border-l-2 border-slate-800">
                    <a href="{{ route('dashboard.posts.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.posts.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Berita & Artikel</a>
                    <a href="{{ route('dashboard.announcements.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.announcements.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Pengumuman</a>
                    <a href="{{ route('dashboard.agendas.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.agendas.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Agenda Kegiatan</a>
                    <a href="{{ route('dashboard.galleries.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.galleries.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Galeri Album Foto</a>
                    <a href="{{ route('dashboard.videos.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.videos.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Video Dokumentasi</a>
                    <a href="{{ route('dashboard.documents.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.documents.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Dokumen PDF Publik</a>
                </div>
            </div>

            @if($userRole === 'ADMIN')
            <!-- 3. Transparansi & Data Mobile -->
            <div>
                <button @click="openTransparansi = !openTransparansi" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider cursor-pointer">
                    <span>Transparansi & Data</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="openTransparansi ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openTransparansi" x-collapse class="pl-3 ml-3.5 space-y-1 border-l-2 border-slate-800">
                    <a href="{{ route('dashboard.apbd.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.apbd.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">APBD & Transparansi</a>
                    <a href="{{ route('dashboard.demographics.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.demographics.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Data & Monografi</a>
                    <a href="{{ route('dashboard.lembagas.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.lembagas.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Lembaga Kemasyarakatan</a>
                    <a href="{{ route('dashboard.partnerships.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.partnerships.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Kelola Instansi</a>
                </div>
            </div>

            <!-- 4. Profil Kelurahan Mobile -->
            <div>
                <button @click="openProfil = !openProfil" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider cursor-pointer">
                    <span>Profil Kelurahan</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="openProfil ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openProfil" x-collapse class="pl-3 ml-3.5 space-y-1 border-l-2 border-slate-800">
                    <a href="{{ route('dashboard.settings.visi-misi') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.settings.visi-misi') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Visi & Misi</a>
                    <a href="{{ route('dashboard.settings.sejarah') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.settings.sejarah') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Sejarah Kelurahan</a>
                    <a href="{{ route('dashboard.settings.aparatur') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.settings.aparatur') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Struktur & Aparatur</a>
                    <a href="{{ route('dashboard.settings.tugas-fungsi') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.settings.tugas-fungsi') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Tugas & Fungsi Kelurahan</a>
                </div>
            </div>

            <!-- 5. Pengaturan & Sistem Mobile -->
            <div>
                <button @click="openPengaturan = !openPengaturan" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-extrabold uppercase text-[10px] tracking-wider cursor-pointer">
                    <span>Pengaturan & Sistem</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="openPengaturan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openPengaturan" x-collapse class="pl-3 ml-3.5 space-y-1 border-l-2 border-slate-800">
                    <a href="{{ route('dashboard.categories.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.categories.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Master Kategori Terpadu</a>
                    <a href="{{ route('dashboard.settings.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.settings.index') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Banner Hero Beranda</a>
                    <a href="{{ route('dashboard.navigation.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.navigation.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Menu Navigasi (Navbar)</a>
                    <a href="{{ route('dashboard.integrations.contact-maps') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.integrations.contact-maps') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Informasi Kontak & Maps</a>
                    @if($user && $user->role === 'admin')
                    <a href="{{ route('dashboard.users.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.users.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Pengguna & Hak Akses</a>
                    <a href="{{ route('dashboard.activity-logs.index') }}" class="block py-1.5 px-2 rounded-lg {{ request()->routeIs('dashboard.activity-logs.*') ? 'text-emerald-400 font-bold bg-emerald-500/10' : 'text-slate-400 hover:text-white' }}">Log Aktivitas System</a>
                    @endif
                </div>
            </div>
            @endif
        </nav>

        <!-- Logout Mobile -->
        <div class="pt-4 border-t border-slate-800 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-rose-600 text-slate-200 text-xs font-bold rounded-xl flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>
</div>
