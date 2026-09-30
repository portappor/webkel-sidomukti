# Galeri Album & Video Kegiatan Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Redesign section "Galeri Album & Video Kegiatan" on `resources/views/home.blade.php` into an Executive Dual Showcase layout.

**Architecture:** Update HTML/Blade structure and Tailwind CSS classes in `resources/views/home.blade.php` for section `#galeri` (around lines 522-780). Add top accent hover lines, glassmorphism category & count/duration badges, balanced action buttons, and cohesive typography.

**Tech Stack:** Laravel Blade, Tailwind CSS, Alpine.js.

## Global Constraints

- Modify only `resources/views/home.blade.php` inside the Galeri section container.
- Preserve Alpine.js attributes (`lightboxSrc`, `lightboxTitle`, `lightboxSlug`, `lightboxOpen`, `videoEmbedUrl`, `videoTitle`, `videoOpen`).
- Preserve dynamic data bindings for `$galleries` and `$videos`.

---

### Task 1: Redesign Section Header & Gallery Cards in Blade View

**Files:**
- Modify: `resources/views/home.blade.php:522-778`

**Interfaces:**
- Consumes: `$galleries` and `$videos` collections from `HomeController`.
- Produces: Executive Dual Showcase Galeri Album & Video section.

- [ ] **Step 1: Apply Executive Dual Showcase Blade layout edit**

Replace lines 522-778 in `resources/views/home.blade.php` with:

```blade
    <div class="container mx-auto px-4">
        <!-- Header Seksi Galeri & Video -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 pb-4 border-b border-slate-200/80 reveal fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-100 text-slate-800 text-[11px] font-extrabold tracking-widest uppercase rounded-full mb-3 border border-slate-200 shadow-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Dokumentasi Visual & Video
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Galeri Album & Video Kegiatan</h2>
                <p class="text-slate-500 mt-2 text-sm sm:text-base font-medium max-w-xl">Dokumentasi resmi foto program serta video kegiatan warga Kelurahan Sidomukti.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 mt-5 md:mt-0">
                <a href="{{ route('galleries.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 px-4 py-2.5 rounded-xl transition-all shadow-xs hover:shadow group">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Semua Album Foto</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('videos.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/80 px-4 py-2.5 rounded-xl transition-all shadow-xs hover:shadow group">
                    <svg class="w-3.5 h-3.5 text-rose-600 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <span>Semua Video Dokumentasi</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- 1. DUA ALBUM FOTO (2 Cards) -->
            @php
                $albumsList = (isset($galleries) && $galleries->count() > 0) ? $galleries->take(2) : collect([]);
            @endphp

            @if($albumsList->count() > 0)
                @foreach($albumsList as $index => $gallery)
                @php
                    $coverUrl = method_exists($gallery, 'getCoverUrlAttribute') ? $gallery->cover_url : (Str::startsWith($gallery->cover_image ?? $gallery->image_path, ['http://', 'https://']) ? ($gallery->cover_image ?? $gallery->image_path) : Storage::url($gallery->cover_image ?? $gallery->image_path));
                    $photoCount = $gallery->photos_count ?? (isset($gallery->photos) ? $gallery->photos->count() : 1);
                    $albumSlug = $gallery->slug ?? null;
                @endphp
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ $index * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                            <img src="{{ $coverUrl }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-95 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <!-- Category Badge Top-Left -->
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ ucfirst($gallery->category ?? 'Pemberdayaan') }}
                                </span>
                            </div>

                            <!-- Count Badge Bottom-Right -->
                            <div class="absolute bottom-3 right-3 z-10">
                                <span class="px-2.5 py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[11px] font-bold rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $photoCount }} Foto
                                </span>
                            </div>

                            <!-- Hover Overlay Preview Button -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-slate-950/40 backdrop-blur-xs">
                                <button @click.prevent="lightboxSrc = '{{ addslashes($coverUrl) }}'; lightboxTitle = '{{ addslashes($gallery->title) }}'; lightboxSlug = '{{ $albumSlug }}'; lightboxOpen = true;" class="bg-white/95 hover:bg-white text-slate-900 font-bold py-2 px-4 rounded-full text-xs shadow-xl transition transform group-hover:scale-105 flex items-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Perbesar Cover
                                </button>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-5">
                            @if($albumSlug)
                            <a href="{{ route('galleries.show', $albumSlug) }}">
                                <h3 class="font-bold text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-2">
                                    {{ $gallery->title }}
                                </h3>
                            </a>
                            @else
                            <h3 class="font-bold text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-2">
                                {{ $gallery->title }}
                            </h3>
                            @endif
                            <p class="text-xs text-slate-500 font-normal flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $gallery->event_date ? \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d F Y') : 'Dokumentasi Kelurahan' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            @if($albumSlug)
                            <a href="{{ route('galleries.show', $albumSlug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all">
                                <span>Lihat Album</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            @else
                            <button @click.prevent="lightboxSrc = '{{ addslashes($coverUrl) }}'; lightboxTitle = '{{ addslashes($gallery->title) }}'; lightboxOpen = true;" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <span>Perbesar</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback 2 Dummy Album Cards if DB empty -->
                @foreach([
                    ['title' => 'Pelatihan & Pemberdayaan UMKM Kripik Warga Sidomukti', 'date' => '12 August 2026', 'cat' => 'Pemberdayaan', 'img' => 'https://images.unsplash.com/photo-1542744100-8a38a7611dc8?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Peresmian Drainase Lingkungan & Gotong Royong RW 03', 'date' => '28 July 2026', 'cat' => 'Pembangunan', 'img' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop']
                ] as $index => $dummyAlbum)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ $index * 80 }}">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                            <img src="{{ $dummyAlbum['img'] }}" alt="{{ $dummyAlbum['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-95">
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-slate-700/80">{{ $dummyAlbum['cat'] }}</span>
                            </div>
                            <div class="absolute bottom-3 right-3 z-10">
                                <span class="px-2.5 py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[11px] font-bold rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    4 Foto
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-2">{{ $dummyAlbum['title'] }}</h3>
                            <p class="text-xs text-slate-500 font-normal flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $dummyAlbum['date'] }}
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-0">
                        <div class="pt-3 border-t border-slate-100">
                            <button @click.prevent="lightboxSrc = '{{ addslashes($dummyAlbum['img']) }}'; lightboxTitle = '{{ addslashes($dummyAlbum['title']) }}'; lightboxOpen = true;" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <span>Perbesar Cover</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            <!-- 2. DUA VIDEO DOKUMENTASI (2 Cards) -->
            @php
                $videosList = (isset($videos) && $videos->count() > 0) ? $videos->take(2) : collect([]);
            @endphp

            @if($videosList->count() > 0)
                @foreach($videosList as $index => $video)
                @php
                    $vThumb = $video->thumbnail_url;
                    $vEmbed = $video->embed_url;
                @endphp
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ ($index + 2) * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <!-- Thumbnail Container with Play Button -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950 cursor-pointer" @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;">
                            <img src="{{ $vThumb }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <!-- Category Badge Top-Left -->
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2.5 py-1 bg-rose-600/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider rounded-lg border border-rose-400/40 shadow-xs flex items-center gap-1">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    {{ ucfirst($video->category ?? 'Video Kegiatan') }}
                                </span>
                            </div>

                            <!-- Duration Badge Bottom-Right -->
                            <div class="absolute bottom-3 right-3 z-10">
                                <span class="px-2.5 py-1 bg-slate-900/90 backdrop-blur-md text-slate-200 text-[10px] font-bold rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ $video->duration ?? 'Video Dok.' }}
                                </span>
                            </div>

                            <!-- Center Glowing Play Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-12 rounded-full bg-rose-600 text-white shadow-lg shadow-rose-600/40 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-500 transition duration-300 border-2 border-white/90">
                                    <svg class="w-5 h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-5">
                            <h3 @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;" class="font-bold text-base text-slate-900 leading-snug group-hover:text-rose-600 transition line-clamp-2 mb-2 cursor-pointer">
                                {{ $video->title }}
                            </h3>
                            <p class="text-xs text-slate-500 font-normal line-clamp-1">
                                {{ $video->description ?? 'Video Liputan Resmi Kelurahan Sidomukti' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:text-rose-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span>Putar Video</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback 2 Dummy Video Cards if DB empty -->
                @foreach([
                    ['title' => 'Video Profil & Potensi Kelurahan Sidomukti 2026', 'cat' => 'Pemerintahan', 'dur' => '05:30', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'thumb' => 'https://images.unsplash.com/photo-1574626003295-d868953930b8?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Dokumentasi Peresmian Drainase Lingkungan & Gotong Royong RW 03', 'cat' => 'Pembangunan', 'dur' => '04:15', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'thumb' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=600&auto=format&fit=crop']
                ] as $index => $dummyVid)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ ($index + 2) * 80 }}">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950 cursor-pointer" @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;">
                            <img src="{{ $dummyVid['thumb'] }}" alt="{{ $dummyVid['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2.5 py-1 bg-rose-600/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider rounded-lg border border-rose-400/40 shadow-xs flex items-center gap-1">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    {{ $dummyVid['cat'] }}
                                </span>
                            </div>

                            <div class="absolute bottom-3 right-3 z-10">
                                <span class="px-2.5 py-1 bg-slate-900/90 backdrop-blur-md text-slate-200 text-[10px] font-bold rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ $dummyVid['dur'] }}
                                </span>
                            </div>

                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-12 h-12 rounded-full bg-rose-600 text-white shadow-lg shadow-rose-600/40 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-500 transition duration-300 border-2 border-white/90">
                                    <svg class="w-5 h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;" class="font-bold text-base text-slate-900 leading-snug group-hover:text-rose-600 transition line-clamp-2 mb-2 cursor-pointer">
                                {{ $dummyVid['title'] }}
                            </h3>
                            <p class="text-xs text-slate-500 font-normal line-clamp-1">Gambaran umum pelayanan publik, tata kelola...</p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:text-rose-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span>Putar Video</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Mobile Nav Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 md:hidden">
            <a href="{{ route('galleries.index') }}" class="w-full sm:w-auto inline-flex justify-center text-xs font-bold text-emerald-800 transition items-center gap-2 uppercase tracking-wide bg-emerald-50 hover:bg-emerald-100 px-5 py-3 rounded-xl border border-emerald-200/80 shadow-xs">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Semua Album Foto</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('videos.index') }}" class="w-full sm:w-auto inline-flex justify-center text-xs font-bold text-rose-800 transition items-center gap-2 uppercase tracking-wide bg-rose-50 hover:bg-rose-100 px-5 py-3 rounded-xl border border-rose-200/80 shadow-xs">
                <svg class="w-4 h-4 text-rose-700 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <span>Semua Video Dokumentasi</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
```

- [ ] **Step 2: Test and verify page template**

Execute Blade compilation verify.

- [ ] **Step 3: Commit changes**

```bash
git add resources/views/home.blade.php docs/superpowers/specs/2026-09-21-galeri-video-design.md docs/superpowers/plans/2026-09-21-galeri-video-redesign.md
git commit -m "feat: redesign Galeri Album & Video section to Executive Dual Showcase"
```
