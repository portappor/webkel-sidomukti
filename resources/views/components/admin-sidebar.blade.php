@php
    $user = auth()->user();
    $userName = $user ? $user->name : 'Super Admin';
    $userRole = 'SUPER_ADMIN';
    $userInitial = strtoupper(substr($userName, 0, 1));
    
    // Route matching for auto accordion state
    $isPelayananActive = request()->routeIs(['dashboard.demographics.*', 'dashboard.agendas.*', 'dashboard.posts.*', 'dashboard.categories.*', 'dashboard.announcements.*', 'dashboard.documents.*', 'dashboard.services.*', 'dashboard.galleries.*', 'dashboard.lembagas.*', 'dashboard.rt-rw.*']);
    $isPortalActive = request()->fullUrlIs('*#sp4n*') || request()->fullUrlIs('*#hallo-sae*') || request()->fullUrlIs('*#kontak*');
    $isPengaturanActive = request()->routeIs(['dashboard.settings.visi-misi', 'dashboard.settings.sejarah', 'dashboard.settings.aparatur']) || (request()->routeIs('dashboard.settings.index') && !request()->fullUrlIs('*#sp4n*'));
    $isSistemActive = request()->routeIs(['dashboard.users.*', 'dashboard.activity-logs.*']) || request()->routeIs('dashboard.settings.profile');
@endphp

<!-- Desktop Sidebar -->
<aside x-data="{ 
            openPelayanan: {{ $isPelayananActive ? 'true' : 'true' }}, 
            openPortal: {{ $isPortalActive ? 'true' : 'false' }}, 
            openPengaturan: {{ $isPengaturanActive ? 'true' : 'false' }}, 
            openSistem: {{ $isSistemActive ? 'true' : 'false' }} 
       }" 
       class="hidden lg:flex flex-col w-72 h-screen px-4 py-5 bg-slate-900 border-r border-slate-800/80 shrink-0 text-slate-300 select-none">

    <!-- 1. Header Sidebar: Branding -->
    <div class="px-2 pb-4 mb-4 border-b border-slate-800/80">
        <!-- Branding Logo & Kelurahan Name -->
        <div class="flex items-center gap-3">
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg" 
                 class="w-9 h-9 object-contain bg-white rounded-lg p-1 shadow-sm" alt="Logo Probolinggo">
            <div class="flex flex-col">
                <span class="text-white font-black text-sm tracking-tight leading-none uppercase">Admin Panel</span>
                <span class="text-emerald-400 font-bold text-[10px] tracking-wider uppercase mt-0.5">Kelurahan Sidomukti</span>
            </div>
        </div>
    </div>

    <!-- 2. Navigation List with Dark Accordion Dropdowns -->
    <nav class="flex-grow space-y-1.5 overflow-y-auto pr-1 custom-scrollbar text-xs">
        
        <!-- 1. [Button/Single Menu] Dashboard Overview -->
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-500/15 text-emerald-400 font-bold border-l-4 border-emerald-400 shadow-sm' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
            <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-xs">Dashboard Overview</span>
        </a>

        <!-- 2. [Dropdown Accordion] Pelayanan Kelurahan (Default Open) -->
        <div class="pt-2">
            <button @click="openPelayanan = !openPelayanan" 
                    class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span class="font-bold text-[11px] uppercase tracking-wider text-slate-300">Pelayanan Kelurahan</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openPelayanan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="openPelayanan" x-collapse class="pl-4 pr-1 mt-1 space-y-1 border-l-2 border-slate-800 ml-5">
                <!-- Data & Statistik Kelurahan -->
                <a href="{{ route('dashboard.demographics.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.demographics.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.demographics.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Data & Statistik Kelurahan
                </a>

                <!-- Agenda Kegiatan -->
                <a href="{{ route('dashboard.agendas.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.agendas.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.agendas.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Agenda Kegiatan
                </a>

                <!-- Berita & Pengumuman Sub-group -->
                <div x-data="{ openNews: {{ request()->routeIs(['dashboard.posts.*', 'dashboard.categories.*', 'dashboard.announcements.*']) ? 'true' : 'false' }} }">
                    <button @click="openNews = !openNews" class="w-full flex items-center justify-between px-3 py-2 text-slate-400 hover:text-slate-200 rounded-lg">
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs(['dashboard.posts.*', 'dashboard.categories.*', 'dashboard.announcements.*']) ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                            <span>Berita & Pengumuman</span>
                        </div>
                        <svg class="w-3 h-3 transition-transform" :class="openNews ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openNews" class="pl-4 space-y-1 mt-0.5 border-l border-slate-800/80 ml-3">
                        <a href="{{ route('dashboard.posts.index') }}" class="block px-2.5 py-1.5 rounded text-[11px] {{ request()->routeIs('dashboard.posts.*') ? 'text-emerald-400 font-bold' : 'text-slate-400 hover:text-white' }}">CRUD Berita & Artikel</a>
                        <a href="{{ route('dashboard.categories.index') }}" class="block px-2.5 py-1.5 rounded text-[11px] {{ request()->routeIs('dashboard.categories.*') ? 'text-emerald-400 font-bold' : 'text-slate-400 hover:text-white' }}">Kategori Berita</a>
                        <a href="{{ route('dashboard.announcements.index') }}" class="block px-2.5 py-1.5 rounded text-[11px] {{ request()->routeIs('dashboard.announcements.*') ? 'text-emerald-400 font-bold' : 'text-slate-400 hover:text-white' }}">Pengumuman Kelurahan</a>
                    </div>
                </div>

                <!-- Kelola & Unggah Dokumen PDF -->
                <a href="{{ route('dashboard.documents.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.documents.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.documents.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Kelola & Unggah Dokumen PDF
                </a>

                <!-- Standar Layanan & SOP -->
                <a href="{{ route('dashboard.services.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.services.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.services.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Standar Layanan & SOP (12 SOP)
                </a>

                <!-- Kelola Album Foto -->
                <a href="{{ route('dashboard.galleries.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.galleries.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.galleries.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Kelola Album Foto
                </a>

                <!-- Kelola Video Dokumentasi -->
                <a href="{{ route('dashboard.videos.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.videos.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.videos.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Kelola Video Dokumentasi
                </a>

                <!-- Lembaga Kemasyarakatan -->
                <a href="{{ route('dashboard.lembagas.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.lembagas.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.lembagas.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Lembaga Kemasyarakatan
                </a>

                <!-- Data Wilayah RT / RW -->
                <a href="{{ route('dashboard.rt-rw.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.rt-rw.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.rt-rw.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Data Wilayah RT / RW
                </a>
            </div>
        </div>

        <!-- 3. [Dropdown Accordion] Portal & Integrasi Publik -->
        <div class="pt-1">
            <button @click="openPortal = !openPortal" 
                    class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    <span class="font-bold text-[11px] uppercase tracking-wider text-slate-300">Portal & Integrasi Publik</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openPortal ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="openPortal" x-collapse class="pl-4 pr-1 mt-1 space-y-1 border-l-2 border-slate-800 ml-5">
                <a href="{{ route('dashboard.settings.index') }}#sp4n" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-slate-400 hover:text-slate-200 hover:bg-slate-800/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Integrasi SP4N-LAPOR!
                </a>
                <a href="{{ route('dashboard.settings.index') }}#hallo-sae" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-slate-400 hover:text-slate-200 hover:bg-slate-800/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Layanan Hallo SAE (Hotline WA)
                </a>
                <a href="{{ route('dashboard.settings.index') }}#kontak" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-slate-400 hover:text-slate-200 hover:bg-slate-800/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Informasi Kontak & Google Maps
                </a>
            </div>
        </div>

        <!-- 4. [Dropdown Accordion] Pengaturan Web & Struktur -->
        <div class="pt-1">
            <button @click="openPengaturan = !openPengaturan" 
                    class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-bold text-[11px] uppercase tracking-wider text-slate-300">Pengaturan Web & Struktur</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openPengaturan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="openPengaturan" x-collapse class="pl-4 pr-1 mt-1 space-y-1 border-l-2 border-slate-800 ml-5">
                <a href="{{ route('dashboard.settings.visi-misi') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.settings.visi-misi') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.settings.visi-misi') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Visi & Misi Kelurahan
                </a>
                <a href="{{ route('dashboard.settings.sejarah') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.settings.sejarah') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.settings.sejarah') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Sejarah Kelurahan
                </a>
                <a href="{{ route('dashboard.settings.aparatur') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.settings.aparatur') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.settings.aparatur') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Struktur Organisasi & Aparatur
                </a>
                <a href="{{ route('dashboard.settings.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.settings.index') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.settings.index') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Banner Beranda Hero
                </a>
            </div>
        </div>

        <!-- 5. [Dropdown Accordion] Sistem & Hak Akses -->
        @if($user && $user->role === 'admin')
        <div class="pt-1">
            <button @click="openSistem = !openSistem" 
                    class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition duration-200">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span class="font-bold text-[11px] uppercase tracking-wider text-slate-300">Sistem & Hak Akses</span>
                </div>
                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="openSistem ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            
            <div x-show="openSistem" x-collapse class="pl-4 pr-1 mt-1 space-y-1 border-l-2 border-slate-800 ml-5">
                <a href="{{ route('dashboard.users.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.users.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.users.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Kelola Pengguna / Admin
                </a>
                <a href="{{ route('dashboard.activity-logs.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard.activity-logs.*') ? 'text-emerald-400 bg-emerald-500/10 font-bold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/40' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard.activity-logs.*') ? 'bg-emerald-400' : 'bg-slate-600' }}"></span>
                    Log Aktivitas
                </a>
                <a href="{{ route('dashboard.settings.aparatur') }}" 
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition-colors text-slate-400 hover:text-slate-200 hover:bg-slate-800/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                    Keamanan & Sandi
                </a>
            </div>
        </div>
        @endif
    </nav>

    <!-- 6. [Button Bawah] Logout Keluar -->
    <div class="pt-4 border-t border-slate-800/80 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800/80 hover:bg-rose-600 text-slate-300 hover:text-white font-bold text-xs transition duration-200 border border-slate-700/50 hover:border-rose-500 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Logout Keluar</span>
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
                openPelayanan: true, 
                openPortal: false, 
                openPengaturan: false, 
                openSistem: false 
           }"
           class="fixed inset-y-0 left-0 flex flex-col w-72 px-4 py-5 bg-slate-900 shadow-2xl text-slate-300">
        
        <!-- Branding Mobile & Close -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 px-1">
            <div class="flex items-center gap-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e6/Logo_Kabupaten_Probolinggo_-_Seal_of_Probolinggo_Regency.svg" class="w-8 h-8 object-contain bg-white rounded p-1" alt="Logo">
                <div class="flex flex-col">
                    <span class="text-white font-black text-xs uppercase tracking-wide">Admin Panel</span>
                    <span class="text-emerald-400 font-bold text-[9px] uppercase tracking-wider">Kel. Sidomukti</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Mobile -->
        <nav class="flex-grow space-y-2 overflow-y-auto custom-scrollbar py-4 pr-1 text-xs">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-500/15 text-emerald-400 font-bold border-l-4 border-emerald-400' : 'text-slate-300' }}">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 01-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard Overview</span>
            </a>

            <!-- Pelayanan Kelurahan Mobile -->
            <div>
                <button @click="openPelayanan = !openPelayanan" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-bold uppercase text-[10px]">
                    <span>Pelayanan Kelurahan</span>
                    <svg class="w-3.5 h-3.5" :class="openPelayanan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openPelayanan" class="pl-4 space-y-1 mt-1 border-l border-slate-800">
                    <a href="{{ route('dashboard.demographics.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Data & Statistik Kelurahan</a>
                    <a href="{{ route('dashboard.agendas.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Agenda Kegiatan</a>
                    <a href="{{ route('dashboard.posts.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Berita & Artikel</a>
                    <a href="{{ route('dashboard.categories.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Kategori Berita</a>
                    <a href="{{ route('dashboard.announcements.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Pengumuman Kelurahan</a>
                    <a href="{{ route('dashboard.documents.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Kelola Dokumen PDF</a>
                    <a href="{{ route('dashboard.services.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Standar Layanan & SOP</a>
                    <a href="{{ route('dashboard.galleries.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Kelola Album Foto</a>
                    <a href="{{ route('dashboard.videos.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Kelola Video Dokumentasi</a>
                    <a href="{{ route('dashboard.lembagas.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Lembaga Kemasyarakatan</a>
                    <a href="{{ route('dashboard.rt-rw.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Data Wilayah RT / RW</a>
                </div>
            </div>

            <!-- Portal Publik Mobile -->
            <div>
                <button @click="openPortal = !openPortal" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-bold uppercase text-[10px]">
                    <span>Portal & Integrasi Publik</span>
                    <svg class="w-3.5 h-3.5" :class="openPortal ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openPortal" class="pl-4 space-y-1 mt-1 border-l border-slate-800">
                    <a href="{{ route('dashboard.settings.index') }}#sp4n" class="block py-1.5 text-slate-400 hover:text-white">SP4N-LAPOR!</a>
                    <a href="{{ route('dashboard.settings.index') }}#hallo-sae" class="block py-1.5 text-slate-400 hover:text-white">Layanan Hallo SAE</a>
                    <a href="{{ route('dashboard.settings.index') }}#kontak" class="block py-1.5 text-slate-400 hover:text-white">Informasi Kontak Kami</a>
                </div>
            </div>

            <!-- Pengaturan Web Mobile -->
            <div>
                <button @click="openPengaturan = !openPengaturan" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-bold uppercase text-[10px]">
                    <span>Pengaturan Web & Struktur</span>
                    <svg class="w-3.5 h-3.5" :class="openPengaturan ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openPengaturan" class="pl-4 space-y-1 mt-1 border-l border-slate-800">
                    <a href="{{ route('dashboard.settings.visi-misi') }}" class="block py-1.5 text-slate-400 hover:text-white">Visi & Misi</a>
                    <a href="{{ route('dashboard.settings.sejarah') }}" class="block py-1.5 text-slate-400 hover:text-white">Sejarah Kelurahan</a>
                    <a href="{{ route('dashboard.settings.aparatur') }}" class="block py-1.5 text-slate-400 hover:text-white">Struktur & Aparatur</a>
                    <a href="{{ route('dashboard.settings.index') }}" class="block py-1.5 text-slate-400 hover:text-white">Banner Hero</a>
                </div>
            </div>

            <!-- Sistem Mobile -->
            @if($user && $user->role === 'admin')
            <div>
                <button @click="openSistem = !openSistem" class="w-full flex items-center justify-between px-3 py-2 text-slate-300 font-bold uppercase text-[10px]">
                    <span>Sistem & Hak Akses</span>
                    <svg class="w-3.5 h-3.5" :class="openSistem ? 'rotate-180 text-emerald-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="openSistem" class="pl-4 space-y-1 mt-1 border-l border-slate-800">
                    <a href="{{ route('dashboard.users.index') }}" class="block py-1.5 {{ request()->routeIs('dashboard.users.*') ? 'text-emerald-400 font-bold' : 'text-slate-400 hover:text-white' }}">Kelola Pengguna</a>
                    <a href="{{ route('dashboard.activity-logs.index') }}" class="block py-1.5 {{ request()->routeIs('dashboard.activity-logs.*') ? 'text-emerald-400 font-bold' : 'text-slate-400 hover:text-white' }}">Log Aktivitas</a>
                    <a href="{{ route('dashboard.settings.aparatur') }}" class="block py-1.5 text-slate-400 hover:text-white">Keamanan & Sandi</a>
                </div>
            </div>
            @endif
        </nav>

        <!-- Logout Mobile -->
        <div class="pt-4 border-t border-slate-800 mt-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-rose-600 text-slate-200 text-xs font-bold rounded-xl flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>
</div>
