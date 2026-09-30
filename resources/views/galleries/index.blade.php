@extends('layouts.app')

@section('title', 'Galeri & Dokumentasi Kegiatan - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen py-8">

    <!-- Page Header (Deep Dark Theme) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden mb-8 -mt-8">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-10 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400 mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1.5 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-emerald-400 transition font-medium">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-slate-400">Informasi</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Galeri & Dokumentasi Album</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Arsip Album Dokumentasi Visual
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Galeri Album Foto Kegiatan Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Arsip dokumentasi resmi program pembangunan, pemberdayaan masyarakat, kegiatan keagamaan, dan momen bersejarah Kelurahan Sidomukti.
                </p>

                {{-- Category Filter Pills in Header (Matching Berita Index Style) --}}
                @if(isset($categories) && $categories->count() > 0)
                <div class="flex flex-wrap items-center gap-2 mt-5">
                    <a href="{{ route('galleries.index', ['category' => 'all']) }}" 
                       class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ ($selectedCategory ?? 'all') === 'all' ? 'bg-emerald-500 text-slate-950 font-bold shadow-sm' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700' }}">
                        Semua Album
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('galleries.index', ['category' => $cat->slug]) }}" 
                       class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ ($selectedCategory ?? '') === $cat->slug || ($selectedCategory ?? '') === $cat->name ? 'bg-emerald-500 text-slate-950 font-bold shadow-sm' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700' }}">
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Container Utama -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- Grid Album Kartu -->
        @if($albums->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
            @foreach($albums as $album)
            <a href="{{ route('galleries.show', $album->slug) }}" 
               class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group">
                
                <!-- Thumbnail Cover (16:9 Ratio) -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-900">
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition duration-300"></div>

                    <!-- Category Badge Top-Left -->
                    <div class="absolute top-3 left-3 z-10">
                        <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-extrabold uppercase tracking-wider rounded-lg border border-slate-700">
                            {{ $categories->firstWhere('slug', $album->category)?->name ?? $categories->firstWhere('name', $album->category)?->name ?? ucfirst($album->category) }}
                        </span>
                    </div>

                    <!-- Count Badge Bottom-Right -->
                    <div class="absolute bottom-3 right-3 z-10">
                        <span class="px-2.5 py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[11px] font-extrabold rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $album->photos_count }} Foto
                        </span>
                    </div>
                </div>

                <!-- Content Info -->
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-2">
                            {{ $album->title }}
                        </h3>
                        @if($album->description)
                        <p class="text-xs text-slate-500 line-clamp-2 mb-3">
                            {{ $album->description }}
                        </p>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $album->event_date ? $album->event_date->translatedFormat('d F Y') : $album->created_at->translatedFormat('d F Y') }}
                        </span>
                        <span class="text-emerald-600 font-bold group-hover:translate-x-0.5 transition flex items-center gap-0.5">
                            Lihat Album &rarr;
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mb-10">
            {{ $albums->links() }}
        </div>
        @else
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 max-w-xl mx-auto my-8">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Album Foto</h3>
            <p class="text-slate-500 text-xs mt-1">Belum ada album foto yang diunggah untuk kategori ini.</p>
        </div>
        @endif

    </div>
</div>
@endsection
