<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-24">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Kelurahan Sidomukti</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ $app_logo }}">
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
            mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 5%, black 95%, transparent 100%);
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



    <!-- Main Navigation -->
    <header class="sticky top-0 z-50 flex flex-col w-full transition-all duration-500" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 15)">
        <!-- Top Ambient Rim Glow Line on Scroll -->
        <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-emerald-500/40 to-transparent transition-opacity duration-500" :class="scrolled ? 'opacity-100' : 'opacity-0'"></div>

        <!-- Main Nav -->
        <div class="relative z-40 w-full transition-all duration-500 ease-out" :class="scrolled ? 'bg-white/75 backdrop-blur-2xl backdrop-saturate-150 border-b border-slate-200/60 shadow-xl shadow-slate-900/5' : 'bg-white border-b border-gray-100'">
            <nav class="container mx-auto px-4 flex justify-between items-center transition-all duration-300" :class="scrolled ? 'py-2' : 'py-3'" x-data="{ mobileMenuOpen: false }">
                <!-- Logo Kelurahan -->
                <a href="/" class="flex items-center gap-3 shrink-0">
                    <img src="{{ $logoUrl }}" alt="Logo Kelurahan" class="w-10 h-10 md:w-12 md:h-12 object-contain transition-transform duration-300" :class="scrolled ? 'scale-95' : 'scale-100'">
                    <div class="flex flex-col border-l-[3px] border-[#008c5f] pl-3">
                        <h1 class="font-extrabold text-slate-800 text-[13px] md:text-[15px] uppercase tracking-tight leading-tight">Kelurahan Sidomukti</h1>
                        <p class="text-[10px] md:text-[11px] text-[#008c5f] font-bold uppercase tracking-wide mt-0.5 leading-tight">Kecamatan Kraksaan, Kabupaten Probolinggo</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                @php
                    $navMenus = \App\Models\NavigationMenu::whereNull('parent_id')
                        ->where('is_active', true)
                        ->with(['children' => function ($q) {
                            $q->where('is_active', true)->orderBy('order', 'asc');
                        }])
                        ->orderBy('order', 'asc')
                        ->get();

                    if ($navMenus->count() === 0) {
                        try {
                            app(\App\Http\Controllers\Dashboard\NavigationMenuController::class)->index();
                            $navMenus = \App\Models\NavigationMenu::whereNull('parent_id')
                                ->where('is_active', true)
                                ->with(['children' => function ($q) {
                                    $q->where('is_active', true)->orderBy('order', 'asc');
                                }])
                                ->orderBy('order', 'asc')
                                ->get();
                        } catch (\Exception $e) {}
                    }

                    $headerServices = \App\Models\Service::where('is_active', true)->orderBy('order', 'asc')->get();
                    $allDocCategories = \App\Models\Category::where('module', 'dokumen')
                        ->where('status', 'aktif')
                        ->orderBy('order', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();

                    $isDokumenRoute = request()->routeIs('documents.*') || request()->is('dokumen*') || request()->is('transparansi*');
                    $reqKategori = request()->get('kategori');
                    $isSemuaDokumenActive = request()->routeIs('documents.index') && empty($reqKategori);
                @endphp
                <ul class="hidden lg:flex items-center gap-1 xl:gap-2 tracking-normal ml-auto flex-1 justify-end mr-3"
                    x-data="{ active: window.location.hash || window.location.pathname }"
                    @hashchange.window="active = window.location.hash || window.location.pathname">
                    
                    @foreach($navMenus as $menu)
                        @php
                            $hasDbChildren = $menu->children->count() > 0;
                            $titleLower = strtolower(trim($menu->title));
                            $isLayanan = in_array($titleLower, ['layanan', 'layanan publik']);
                            $isDokumen = in_array($titleLower, ['dokumen', 'dokumen publik']);
                            $isHasDropdown = $hasDbChildren || $isLayanan || $isDokumen;
                        @endphp

                        @if($isHasDropdown)
                            @php
                                $childUrls = [];
                                foreach($menu->children as $child) {
                                    if($child->url !== '#' && $child->url !== '/') {
                                        $childUrls[] = rtrim($child->url, '/');
                                    }
                                }
                                $childUrlsJson = json_encode($childUrls);
                            @endphp
                            <li class="relative group" x-data="{ menuDropdown: false }" @mouseenter="menuDropdown = true" @mouseleave="menuDropdown = false">
                                <button :class="(menuDropdown || (active === '{{ $menu->url }}' && '{{ $menu->url }}' !== '#') || ('{{ $menu->url }}' !== '#' && '{{ $menu->url }}' !== '/' && active.includes('{{ rtrim($menu->url, '/') }}')) || ({{ $isLayanan ? 'true' : 'false' }} && active.includes('/layanan')) || ({{ $isDokumen ? 'true' : 'false' }} && (active.includes('/dokumen') || active.includes('/transparansi'))) || {{ $childUrlsJson }}.some(url => active.includes(url))) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50/80 font-bold'"
                                        class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center gap-1 cursor-pointer">
                                    <span>{{ $menu->title }}</span>
                                    <svg class="w-3 h-3 transition-transform duration-200" :class="menuDropdown ? 'rotate-180 text-[#008c5f]' : 'text-slate-400 group-hover:text-[#008c5f]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="menuDropdown" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                     class="absolute top-full left-0 {{ $isLayanan ? 'w-80 md:w-[380px]' : ($isDokumen ? 'w-64' : 'w-56') }} bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 p-2 transform origin-top-left z-50 mt-2 space-y-0.5" style="display: none;">
                                    
                                    @if($isLayanan)
                                        <div class="px-3 py-2 border-b border-slate-100 mb-1 flex items-center justify-between">
                                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-emerald-800">Standar Pelayanan & SOP</span>
                                            <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">{{ $headerServices->count() }} Dokumen</span>
                                        </div>

                                        <div class="max-h-[360px] overflow-y-auto space-y-0.5 pr-1">
                                            @foreach($headerServices as $srvItem)
                                                <a href="{{ route('services.show', $srvItem->slug) }}" @click="active = '/layanan/{{ $srvItem->slug }}'" class="flex items-center gap-2.5 px-3 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                                    <span>{{ $srvItem->title }}</span>
                                                </a>
                                            @endforeach
                                        </div>

                                        @if($hasDbChildren)
                                            <div class="pt-1 border-t border-slate-100 mt-1 space-y-0.5">
                                                @foreach($menu->children as $child)
                                                    <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-3.5 py-2 text-[12.5px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                                        {{ $child->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="pt-2 border-t border-slate-100 mt-1">
                                            <a href="{{ route('services.index') }}" @click="active = '/layanan'" class="block py-2 text-center text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100/80 rounded-xl transition-colors">
                                                Lihat Semua Dokumen SOP ({{ $headerServices->count() }}) →
                                            </a>
                                        </div>
                                    @elseif($isDokumen)
                                        @foreach($allDocCategories as $docCat)
                                            @php
                                                $cSlug = \Illuminate\Support\Str::slug($docCat->slug ?: $docCat->name);
                                                $catVal = $docCat->slug ?: $docCat->name;
                                                if (in_array($cSlug, ['musrenbang', 'dokumen-musrenbang'])) {
                                                    $catRoute = route('documents.musrenbang');
                                                } elseif (in_array($cSlug, ['renstra-renja', 'renstra_renja', 'dokumen-renstra-renja'])) {
                                                    $catRoute = route('documents.renstra_renja');
                                                } elseif (in_array($cSlug, ['sk-kelembagaan', 'sk_kelembagaan', 'dokumen-sk-kelembagaan'])) {
                                                    $catRoute = route('documents.sk_kelembagaan');
                                                } else {
                                                    $catRoute = route('documents.index', ['kategori' => $catVal]);
                                                }
                                            @endphp
                                            <a href="{{ $catRoute }}" class="block px-3.5 py-2 text-[13px] rounded-xl transition-all font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f]">
                                                {{ $docCat->name }}
                                            </a>
                                        @endforeach
                                        @if($hasDbChildren)
                                            @php
                                                $renderedCatSlugs = $allDocCategories->map(fn($c) => \Illuminate\Support\Str::slug($c->slug ?: $c->name))->toArray();
                                                $uniqueChildren = $menu->children->filter(function($child) use ($renderedCatSlugs) {
                                                    $childSlug = \Illuminate\Support\Str::slug($child->title);
                                                    return !in_array($childSlug, $renderedCatSlugs) && !in_array($childSlug, ['musrenbang', 'renstra-renja', 'sk-kelembagaan']);
                                                });
                                            @endphp
                                            @if($uniqueChildren->isNotEmpty())
                                                <div class="pt-1 border-t border-slate-100 mt-1 space-y-0.5">
                                                    @foreach($uniqueChildren as $child)
                                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-3.5 py-2 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                                            {{ $child->title }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url }}" target="{{ $child->target }}" @click="active = '{{ $child->url }}'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </li>
                        @else
                            <li>
                                <a href="{{ $menu->url }}" 
                                   target="{{ $menu->target }}"
                                   @click="active = '{{ $menu->url }}'"
                                   :class="(active === '{{ $menu->url }}' || (active === '/' && '{{ $menu->url }}' === '/') || ('{{ $menu->url }}' !== '/' && '{{ $menu->url }}' !== '#' && active.startsWith('{{ rtrim($menu->url, '/') }}'))) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50/80 font-bold'"
                                   class="px-3 py-1.5 rounded-xl text-[13.5px] transition-all flex items-center">
                                    {{ $menu->title }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    <li class="hidden xl:flex items-center pl-2 pr-1">
                        <img src="{{ asset('logo-berakhlak.png') }}" alt="BerAKHLAK" class="h-8 object-contain">
                    </li>
                </ul>
                
                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center gap-3 shrink-0 border-l border-slate-200/80 pl-4">
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
                <div x-show="mobileMenuOpen" x-transition class="lg:hidden absolute top-[100%] left-0 w-full bg-white/95 backdrop-blur-2xl shadow-xl border-t py-2 flex flex-col font-bold text-sm text-slate-700 z-50 tracking-wide" style="display: none;">
                    @foreach($navMenus as $menu)
                        @php
                            $hasDbChildren = $menu->children->count() > 0;
                            $titleLower = strtolower(trim($menu->title));
                            $isLayanan = in_array($titleLower, ['layanan', 'layanan publik']);
                            $isDokumen = in_array($titleLower, ['dokumen', 'dokumen publik']);
                            $isHasDropdown = $hasDbChildren || $isLayanan || $isDokumen;
                        @endphp

                        @if($isHasDropdown)
                            <div x-data="{ mobileSub: false }" class="border-b border-slate-100">
                                <button @click="mobileSub = !mobileSub" class="w-full text-left px-5 py-3 flex justify-between items-center hover:bg-slate-50 hover:text-[#008c5f] uppercase">
                                    {{ $menu->title }} <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="mobileSub" class="bg-slate-50/80 flex flex-col text-xs pl-8 pb-2" style="display: none;">
                                    @if($isLayanan)
                                        <a @click="mobileMenuOpen = false" href="{{ route('services.index') }}" class="py-1.5 font-bold text-emerald-700 hover:text-[#008c5f]">→ Indeks Semua Dokumen SOP ({{ $headerServices->count() }})</a>
                                        @foreach($headerServices as $srvItem)
                                            <a @click="mobileMenuOpen = false" href="{{ route('services.show', $srvItem->slug) }}" class="py-1.5 hover:text-[#008c5f]">{{ $srvItem->title }}</a>
                                        @endforeach
                                    @elseif($isDokumen)
                                        @foreach($allDocCategories as $docCat)
                                            <a @click="mobileMenuOpen = false" href="{{ route('documents.index', ['kategori' => $docCat->slug ?: $docCat->name]) }}" class="py-2 hover:text-[#008c5f]">{{ $docCat->name }}</a>
                                        @endforeach
                                    @endif

                                    @php
                                        $filteredMobileChildren = $menu->children;
                                        if ($isDokumen) {
                                            $renderedCatSlugs = $allDocCategories->map(fn($c) => \Illuminate\Support\Str::slug($c->slug ?: $c->name))->toArray();
                                            $filteredMobileChildren = $menu->children->filter(function($child) use ($renderedCatSlugs) {
                                                $childSlug = \Illuminate\Support\Str::slug($child->title);
                                                return !in_array($childSlug, $renderedCatSlugs) && !in_array($childSlug, ['musrenbang', 'renstra-renja', 'sk-kelembagaan']);
                                            });
                                        }
                                    @endphp
                                    @foreach($filteredMobileChildren as $child)
                                        <a @click="mobileMenuOpen = false" href="{{ $child->url }}" target="{{ $child->target }}" class="py-2 hover:text-[#008c5f]">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a @click="mobileMenuOpen = false" href="{{ $menu->url }}" target="{{ $menu->target }}" class="px-5 py-3 border-b border-slate-100 hover:bg-slate-50 hover:text-[#008c5f] uppercase">{{ $menu->title }}</a>
                        @endif
                    @endforeach

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

        <!-- Announcement Ticker with Compact Micro-Glass Transition -->
        @if(isset($announcements) && $announcements->count() > 0 && !request()->routeIs('announcements.index'))
        <div class="relative z-30 w-full transition-all duration-500 ease-out" :class="scrolled ? 'bg-slate-50/50 backdrop-blur-xl border-b border-slate-200/50 py-1' : 'bg-slate-50/70 border-b border-slate-200/60 py-1.5'">
            <div class="container mx-auto px-4">
                <div class="rounded-full h-8 px-3 py-0.5 transition-all duration-500 flex items-center gap-2.5" :class="scrolled ? 'bg-white/75 backdrop-blur-xl border border-white/80 shadow-xs' : 'bg-white border border-slate-200/70 shadow-2xs hover:border-slate-300'">
                    
                    <!-- Badge Kategori "PENGUMUMAN" Micro -->
                    <div class="bg-emerald-600/90 text-white px-2.5 py-0.5 rounded-md font-extrabold text-[10px] uppercase tracking-wider shrink-0 flex items-center gap-1.5 shadow-2xs">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-white"></span>
                        </span>
                        <span>Pengumuman</span>
                    </div>

                    <!-- Pembatas Tipis Vertikal -->
                    <div class="h-3 w-px bg-slate-200/80 shrink-0"></div>

                    <!-- Ticker Content Container -->
                    <div class="ticker-wrap flex-1 text-[11.5px] leading-none relative overflow-hidden">
                        <div class="ticker-content flex items-center">
                            @foreach($announcements as $ann)
                                <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2.5 cursor-pointer group">
                                    <div class="flex items-center gap-2.5 transition-transform duration-500 ease-out group-hover:translate-x-1">
                                        <span class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors tracking-tight">{{ $ann->title }}</span>
                                        @if(!empty($ann->content))
                                            <span class="text-slate-500/80 font-normal hidden sm:inline group-hover:text-slate-600 transition-colors italic">&mdash; {{ Str::limit(strip_tags($ann->content), 65) }}</span>
                                        @endif
                                        <span class="bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 text-[10px] px-2.5 py-0.5 rounded-full font-bold tracking-wide border border-emerald-100/80 shadow-[inset_0_1px_2px_rgba(255,255,255,0.8)] shrink-0 ml-1">
                                            {{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="mx-7 w-1 h-1 bg-emerald-400 rotate-45 shadow-[0_0_6px_rgba(52,211,153,0.9)] shrink-0 group-hover:bg-emerald-500 group-hover:scale-150 transition-all duration-500"></div>
                                </a>
                            @endforeach
                            {{-- Duplicate for seamless loop --}}
                            @foreach($announcements as $ann)
                                <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2.5 cursor-pointer group">
                                    <div class="flex items-center gap-2.5 transition-transform duration-500 ease-out group-hover:translate-x-1">
                                        <span class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors tracking-tight">{{ $ann->title }}</span>
                                        @if(!empty($ann->content))
                                            <span class="text-slate-500/80 font-normal hidden sm:inline group-hover:text-slate-600 transition-colors italic">&mdash; {{ Str::limit(strip_tags($ann->content), 65) }}</span>
                                        @endif
                                        <span class="bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 text-[10px] px-2.5 py-0.5 rounded-full font-bold tracking-wide border border-emerald-100/80 shadow-[inset_0_1px_2px_rgba(255,255,255,0.8)] shrink-0 ml-1">
                                            {{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="mx-7 w-1 h-1 bg-emerald-400 rotate-45 shadow-[0_0_6px_rgba(52,211,153,0.9)] shrink-0 group-hover:bg-emerald-500 group-hover:scale-150 transition-all duration-500"></div>
                                </a>
                            @endforeach
                        </div>
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
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-6 mt-8">
    <footer id="kontak" class="bg-[#0B1220] text-slate-300 pt-10 pb-6 font-sans border-t-4 border-emerald-600 rounded-3xl shadow-2xl overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl">
            @php
                $qrTargetUrl = $settings['qr_code_destination_url'] ?? url('/');
                $qrTitle = $settings['qr_code_title'] ?? 'Scan QR Portal Pelayanan';
                $qrSubtitle = $settings['qr_code_subtitle'] ?? 'Kelurahan Sidomukti';
                $gmapsLink = $settings['gmaps_link'] ?? 'https://maps.google.com/?q=Kelurahan+Sidomukti+Kraksaan';
                $qrImgUrl = !empty($settings['qr_code_image'])
                    ? (\Illuminate\Support\Str::startsWith($settings['qr_code_image'], 'http') ? $settings['qr_code_image'] : asset('storage/' . $settings['qr_code_image']))
                    : 'https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=' . urlencode($qrTargetUrl) . '&margin=0';
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8 items-stretch">
                
                <!-- Box 1: Tentang & Sosial Media -->
                <div class="bg-[#121E31] rounded-2xl p-5 md:p-6 shadow-sm flex flex-col justify-between border border-slate-800/90">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ $logoUrl }}" alt="Logo" class="w-10 h-10 object-contain bg-white rounded-lg p-1 shrink-0">
                            <div>
                                <h2 class="font-extrabold text-base text-white leading-tight">Kelurahan Sidomukti</h2>
                                <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">Kec. Kraksaan - Kab. Probolinggo</p>
                            </div>
                        </div>
                        <div class="h-[2px] w-full bg-emerald-500/80 mb-3.5"></div>
                        <p class="text-xs text-slate-400 leading-relaxed mb-4">
                            Portal Resmi Informasi Publik, Pelayanan Administrasi Kependudukan, Surat Keterangan Online, dan Pembangunan Kelurahan Sidomukti.
                        </p>
                    </div>
                    
                    <div>
                        <div class="text-[10px] font-black text-slate-400 tracking-widest uppercase mb-2">Media Sosial Resmi</div>
                        <div class="flex flex-wrap items-center gap-2">
                            @php
                                $defaultSocials = [
                                    ['platform' => 'Instagram', 'url' => $settings['instagram'] ?? 'https://www.instagram.com/', 'icon' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>'],
                                    ['platform' => 'YouTube', 'url' => $settings['youtube'] ?? 'https://www.youtube.com/', 'icon' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 00-2.122 2.136C0 8.07 0 12 0 12s0 3.93.498 5.814a3.016 3.016 0 002.122 2.136c1.872.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'],
                                    ['platform' => 'TikTok', 'url' => $settings['tiktok'] ?? 'https://www.tiktok.com/', 'icon' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>']
                                ];
                                $socials = isset($settings['social_media_links']) ? json_decode($settings['social_media_links'], true) : $defaultSocials;
                            @endphp

                            @if(is_array($socials))
                                @foreach($socials as $soc)
                                    @if(!empty($soc['url']) && $soc['url'] !== '#')
                                    <a href="{{ $soc['url'] }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition" title="{{ $soc['platform'] ?? 'Social Media' }}">
                                        {!! $soc['icon'] ?? '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>' !!}
                                    </a>
                                    @endif
                                @endforeach
                            @endif
                            @php
                                $waRaw = $settings['whatsapp'] ?? $settings['wa_number'] ?? $settings['telepon_wa'] ?? '6281234567890';
                                $waNumOnly = preg_replace('/[^0-9]/', '', $waRaw);
                                if (\Illuminate\Support\Str::startsWith($waNumOnly, '0')) {
                                    $waNumOnly = '62' . substr($waNumOnly, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $waNumOnly }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition" title="WhatsApp Hotline">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Scan QR -->
                <div class="bg-[#121E31] rounded-2xl p-5 md:p-6 shadow-sm flex flex-col items-center text-center justify-center border border-slate-800/90">
                    <h3 class="font-black text-xs text-white tracking-widest uppercase mb-2">Scan Kode QR</h3>
                    <div class="h-[2px] w-32 bg-emerald-500/80 mb-3.5"></div>
                    <a href="{{ $qrTargetUrl }}" target="_blank" class="group block bg-white p-2.5 rounded-2xl mb-3 shadow-md border-2 border-slate-100 hover:border-emerald-400 transition-all duration-300 transform hover:scale-105" title="Klik untuk buka tautan QR">
                        <img src="{{ $qrImgUrl }}" alt="QR Code" class="w-28 h-28 object-contain">
                    </a>
                    <div class="flex items-center gap-1.5 text-emerald-400 font-extrabold text-xs mb-0.5">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        <span>{{ $qrTitle }}</span>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium">{{ $qrSubtitle }}</p>
                </div>

                <!-- Box 3: Alamat Kantor -->
                <div class="bg-[#121E31] rounded-2xl p-5 md:p-6 shadow-sm flex flex-col justify-between border border-slate-800/90">
                    <div>
                        <h2 class="font-extrabold text-base text-white mb-2">Alamat Kantor</h2>
                        <div class="h-[2px] w-full bg-emerald-500/80 mb-3.5"></div>
                        
                        <ul class="space-y-2.5 text-xs text-slate-300 font-medium">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="leading-snug">{{ $settings['alamat'] ?? 'Jl. Raya Sidomukti No. 10, Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo 67282' }}</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>Telp: {{ $settings['telepon'] ?? '(0335) 123456' }} | WA: {{ $settings['whatsapp'] ?? $settings['wa_number'] ?? $settings['telepon_wa'] ?? '0812 3456 7890' }}</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="break-all">Email: {{ $settings['email'] ?? 'info@sidomukti.desa.id' }}</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div class="leading-snug">
                                    @php
                                        $jamSeninKamis = $settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB';
                                        $jamJumat = $settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB';
                                    @endphp
                                    @if($jamSeninKamis === $jamJumat)
                                        <span>Jam Kerja: Sen - Jum {{ $jamSeninKamis }}</span>
                                    @else
                                        <span>Jam Kerja: Sen-Kam {{ $jamSeninKamis }} | Jum {{ $jamJumat }}</span>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ $gmapsLink }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center justify-center gap-2 w-full px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs rounded-xl shadow-md border border-emerald-500/30 transition-all duration-200 hover:-translate-y-0.5 group">
                        <svg class="w-3.5 h-3.5 text-emerald-200 group-hover:scale-110 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Lihat Peta & Petunjuk Arah
                        <svg class="w-3 h-3 opacity-70 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

            </div>
            
            <!-- Bottom Copyright -->
            <div class="flex flex-col md:flex-row justify-between items-center pt-5 border-t border-slate-800/80 text-[11px] text-slate-500 font-medium">
                <div class="flex items-center gap-2 mb-2 md:mb-0">
                    <div class="w-7 h-7 rounded-lg bg-[#121E31] flex items-center justify-center text-slate-400 border border-slate-800">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <span>Kelurahan Sidomukti Kraksaan - Kabupaten Probolinggo</span>
                </div>
                <div>
                    &copy; {{ date('Y') }} Portal Resmi Kelurahan. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
    </div>

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

        // System Floating Toast Notification
        window.showToastNotification = function(options) {
            let title = 'AKSES DITOLAK!';
            let message = '';
            let type = 'error';

            if (typeof options === 'string') {
                const cleanStr = options.trim();
                const parts = cleanStr.split('\n\n');
                if (parts.length > 1) {
                    title = parts[0].replace(/^[^\w\s\-\!]+/, '').trim() || 'AKSES DITOLAK!';
                    message = parts.slice(1).join('<br>').replace(/\n/g, '<br>');
                } else {
                    message = cleanStr.replace(/\n/g, '<br>');
                }
            } else if (typeof options === 'object') {
                title = options.title || 'PERHATIAN';
                message = (options.message || '').replace(/\n/g, '<br>');
                type = options.type || 'error';
            }

            let container = document.getElementById('toastNotificationContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastNotificationContainer';
                container.className = 'fixed top-5 right-5 z-[999999] flex flex-col gap-3 max-w-md w-full pointer-events-none px-4 sm:px-0';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto w-full bg-slate-900/95 text-white rounded-2xl p-4 shadow-2xl border ${
                type === 'error' ? 'border-rose-500/50 shadow-rose-950/40' : 'border-emerald-500/50 shadow-emerald-950/40'
            } backdrop-blur-md transform transition-all duration-300 -translate-y-4 opacity-0 flex items-start gap-3.5 relative overflow-hidden`;

            const iconHtml = type === 'error' 
                ? `<div class="p-2.5 bg-rose-500/20 text-rose-400 rounded-xl border border-rose-500/30 shrink-0 mt-0.5">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                   </div>`
                : `<div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-xl border border-emerald-500/30 shrink-0 mt-0.5">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                   </div>`;

            toast.innerHTML = `
                <div class="absolute left-0 top-0 bottom-0 w-1.5 ${type === 'error' ? 'bg-rose-500' : 'bg-emerald-500'}"></div>
                ${iconHtml}
                <div class="flex-1 pr-6">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full ${
                            type === 'error' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'
                        }">${type === 'error' ? 'AKSES DITOLAK' : 'NOTIFIKASI'}</span>
                    </div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-white tracking-tight">${title}</h4>
                    <div class="text-xs text-slate-300 mt-1 leading-relaxed font-medium">${message}</div>
                </div>
                <button type="button" class="absolute top-3.5 right-3.5 text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;

            const closeBtn = toast.querySelector('button');
            closeBtn.onclick = function() {
                toast.classList.add('-translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            };

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('-translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            });

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('-translate-y-4', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 6000);
        };

        // Override native window.alert globally
        window.alert = function(msg) {
            window.showToastNotification(msg);
        };
    </script>

    <!-- Global Proteksi Double Click & Form Submit -->
    <x-global-protector />
</body>
</html>
