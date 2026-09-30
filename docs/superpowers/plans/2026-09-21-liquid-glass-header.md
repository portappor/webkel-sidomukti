# Liquid Glass Header Effect Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Implement an automatic **Liquid Glass** transformation on header navigation and ticker elements upon scrolling down.

**Architecture:** Update `<header>` in `resources/views/layouts/app.blade.php` to include `@scroll.window="scrolled = (window.pageYOffset > 15)"` with Alpine.js. Dynamic classes for `scrolled` state apply `backdrop-blur-2xl backdrop-saturate-150 bg-white/75 border-slate-200/60 shadow-xl shadow-slate-900/5` and ambient rim lighting.

**Tech Stack:** Laravel Blade, Tailwind CSS, Alpine.js.

## Global Constraints

- Modify only `resources/views/layouts/app.blade.php` around header and ticker elements.
- Preserve all existing navigation menu links, dropdown logic, and authentication links.

---

### Task 1: Update Layout Blade View with Dynamic Liquid Glass Header

**Files:**
- Modify: `resources/views/layouts/app.blade.php:114-415`

**Interfaces:**
- Consumes: Alpine.js window scroll listener `@scroll.window="scrolled = (window.pageYOffset > 15)"`.
- Produces: Liquid Glass sticky header and ticker container.

- [ ] **Step 1: Replace header element in `resources/views/layouts/app.blade.php`**

Update `<header>` wrapper to include Alpine state `x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 15)"` and dynamic Liquid Glass class bindings:

```blade
    <!-- Main Navigation -->
    <header class="sticky top-0 z-50 flex flex-col w-full transition-all duration-500" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 15)">
        <!-- Top Ambient Rim Glow Line on Scroll -->
        <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-emerald-500/40 to-transparent transition-opacity duration-500" :class="scrolled ? 'opacity-100' : 'opacity-0'"></div>

        <!-- Main Nav -->
        <div class="w-full transition-all duration-500 ease-out" :class="scrolled ? 'bg-white/75 backdrop-blur-2xl backdrop-saturate-150 border-b border-slate-200/60 shadow-xl shadow-slate-900/5' : 'bg-white border-b border-gray-100'">
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
                            <li class="relative group" x-data="{ menuDropdown: false }" @mouseenter="menuDropdown = true" @mouseleave="menuDropdown = false">
                                <button :class="(menuDropdown || (active === '{{ $menu->url }}' && '{{ $menu->url }}' !== '#') || active.includes('{{ rtrim($menu->url, '/') }}')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50/80 font-bold'"
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
                                        <a href="{{ route('documents.index') }}" @click="active = '/dokumen'" 
                                           class="block px-3.5 py-2.5 text-[13px] rounded-xl transition-all duration-150 font-bold {{ $isSemuaDokumenActive ? 'bg-emerald-50 text-[#008c5f] font-extrabold' : 'text-slate-700 hover:bg-emerald-50/80 hover:text-[#008c5f]' }}">
                                            Semua Dokumen PDF
                                        </a>
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
                                   :class="(active === '{{ $menu->url }}' || (active === '/' && '{{ $menu->url }}' === '/')) ? 'text-[#008c5f] bg-emerald-50/90 font-black' : 'text-slate-700 hover:text-[#008c5f] hover:bg-slate-50/80 font-bold'"
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
                                        <a @click="mobileMenuOpen = false" href="{{ route('documents.index') }}" class="py-2 font-bold text-emerald-700 hover:text-[#008c5f]">→ Semuanya (Dokumen PDF)</a>
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

        <!-- Announcement Ticker with Liquid Glass Transition -->
        @if(isset($announcements) && $announcements->count() > 0)
        <div class="relative z-30 w-full transition-all duration-500 ease-out" :class="scrolled ? 'bg-slate-50/60 backdrop-blur-xl border-b border-slate-200/50 py-1.5' : 'bg-slate-50/80 border-b border-slate-200/60 py-2'">
            <div class="container mx-auto px-4">
                <div class="rounded-full px-3.5 py-1.5 transition-all duration-500 flex items-center gap-3" :class="scrolled ? 'bg-white/75 backdrop-blur-xl border border-white/80 shadow-md shadow-emerald-950/5' : 'bg-white border border-slate-200/80 shadow-2xs hover:border-slate-300'">
                    
                    <!-- Badge Kategori "BERITA TERKINI" -->
                    <div class="bg-emerald-600 text-white px-3 py-1 rounded-full font-bold text-[11px] uppercase tracking-wider shrink-0 flex items-center gap-1.5 shadow-2xs">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-white"></span>
                        </span>
                        <span>Berita Terkini</span>
                    </div>

                    <!-- Pembatas Tipis Vertikal -->
                    <div class="h-3.5 w-px bg-slate-200/80 shrink-0"></div>

                    <!-- Ticker Content Container -->
                    <div class="ticker-wrap flex-1 text-xs sm:text-sm relative overflow-hidden">
                        <div class="ticker-content flex items-center">
                            @foreach($announcements as $ann)
                                <div class="inline-flex items-center gap-2 mr-8 font-medium text-slate-700 hover:text-emerald-600 transition cursor-pointer group">
                                    <span class="font-semibold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $ann->title }}</span>
                                    @if(!empty($ann->content))
                                        <span class="text-slate-500 font-normal hidden sm:inline">- {{ Str::limit($ann->content, 65) }}</span>
                                    @endif
                                    <span class="bg-slate-100 text-slate-600 text-[11px] px-2 py-0.5 rounded-md font-medium border border-slate-200/50 shrink-0">
                                        {{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 inline-block shrink-0 mx-4"></span>
                                </div>
                            @endforeach
                            {{-- Duplicate for seamless loop --}}
                            @foreach($announcements as $ann)
                                <div class="inline-flex items-center gap-2 mr-8 font-medium text-slate-700 hover:text-emerald-600 transition cursor-pointer group">
                                    <span class="font-semibold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $ann->title }}</span>
                                    @if(!empty($ann->content))
                                        <span class="text-slate-500 font-normal hidden sm:inline">- {{ Str::limit($ann->content, 65) }}</span>
                                    @endif
                                    <span class="bg-slate-100 text-slate-600 text-[11px] px-2 py-0.5 rounded-md font-medium border border-slate-200/50 shrink-0">
                                        {{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 inline-block shrink-0 mx-4"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </header>
```

- [ ] **Step 2: Test Blade syntax & cache compilation**

Run test verification.

- [ ] **Step 3: Commit changes**

```bash
git add resources/views/layouts/app.blade.php docs/superpowers/specs/2026-09-21-liquid-glass-header-design.md docs/superpowers/plans/2026-09-21-liquid-glass-header.md
git commit -m "feat: add dynamic Liquid Glass effect to header navigation and ticker on scroll"
```
