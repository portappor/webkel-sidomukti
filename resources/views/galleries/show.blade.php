@extends('layouts.app')

@section('title', $album->title . ' - Galeri Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen py-8"
     x-data="{
        lightboxOpen: false,
        activeIndex: 0,
        photos: {{ json_encode($album->photos->map(fn($p) => ['url' => $p->image_url, 'caption' => $p->caption])) }},
        openLightbox(index) {
            this.activeIndex = index;
            this.lightboxOpen = true;
        },
        next() {
            if (this.activeIndex < this.photos.length - 1) {
                this.activeIndex++;
            } else {
                this.activeIndex = 0;
            }
        },
        prev() {
            if (this.activeIndex > 0) {
                this.activeIndex--;
            } else {
                this.activeIndex = this.photos.length - 1;
            }
        }
     }">

    <!-- Page Header (Deep Dark Theme) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden mb-8 -mt-8">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-10 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400 mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1.5 md:space-x-2 flex-wrap">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-emerald-400 transition font-medium">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('galleries.index') }}" class="ml-1.5 hover:text-emerald-400 font-medium">Galeri Album</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold truncate max-w-xs">{{ $album->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider">
                        {{ ucfirst($album->category) }}
                    </span>
                    <span class="text-xs text-slate-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $album->event_date ? $album->event_date->translatedFormat('d F Y') : $album->created_at->translatedFormat('d F Y') }}
                    </span>
                    <span class="text-xs text-emerald-400 font-bold px-2 py-0.5 bg-emerald-950/80 rounded border border-emerald-800">
                        {{ $album->photos->count() }} Foto
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-4">
                    {{ $album->title }}
                </h1>
                @if($album->description)
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed bg-slate-900/60 p-4 rounded-xl border border-slate-800/80 backdrop-blur-xs">
                    {{ $album->description }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Container Grid Foto -->
    <div class="container mx-auto px-4 max-w-7xl">

        @if($album->photos->count() > 0)
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Dokumentasi Foto dalam Album
            </h2>
            <span class="text-xs text-slate-500 font-medium">Klik foto untuk melihat ukuran penuh</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4 mb-12">
            @foreach($album->photos as $index => $photo)
            <div @click="openLightbox({{ $index }})" 
                 class="group relative aspect-square bg-slate-900 rounded-xl overflow-hidden shadow-sm border border-slate-200/90 cursor-pointer hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <img src="{{ $photo->image_url }}" alt="Dokumentasi {{ $album->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <span class="bg-emerald-600/90 text-white font-extrabold text-xs py-1.5 px-3 rounded-full shadow border border-white/20 flex items-center gap-1.5 backdrop-blur-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        Perbesar
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 max-w-xl mx-auto my-8">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Foto dalam Album Ini</h3>
            <p class="text-slate-500 text-xs mt-1">Foto-foto dokumentasi untuk album ini akan segera diunggah.</p>
        </div>
        @endif

        <!-- Album Lainnya -->
        @if(isset($relatedAlbums) && $relatedAlbums->count() > 0)
        <div class="mt-12 pt-8 border-t border-slate-200">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Album Kegiatan Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedAlbums as $related)
                <a href="{{ route('galleries.show', $related->slug) }}" class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-md transition group flex flex-col">
                    <div class="aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="{{ $related->cover_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <div class="p-3">
                        <h4 class="font-bold text-xs text-slate-800 group-hover:text-emerald-600 line-clamp-1 mb-1">{{ $related->title }}</h4>
                        <span class="text-[10px] text-slate-500">{{ $related->event_date ? $related->event_date->translatedFormat('d M Y') : $related->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <!-- Lightbox Modal Screen (Alpine.js) -->
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="lightboxOpen = false"
         @keydown.right.window="next()"
         @keydown.left.window="prev()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md"
         style="display: none;">
        
        <!-- Close Button -->
        <button @click="lightboxOpen = false" class="absolute top-4 right-4 z-50 w-11 h-11 bg-slate-900/80 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition shadow-lg border border-slate-700 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Previous Button -->
        <button @click="prev()" x-show="photos.length > 1" class="absolute left-4 top-1/2 -translate-y-1/2 z-50 w-12 h-12 bg-slate-900/80 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center transition shadow-lg border border-slate-700 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Next Button -->
        <button @click="next()" x-show="photos.length > 1" class="absolute right-4 top-1/2 -translate-y-1/2 z-50 w-12 h-12 bg-slate-900/80 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center transition shadow-lg border border-slate-700 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Content Area -->
        <div @click.away="lightboxOpen = false" class="relative max-w-5xl w-full flex flex-col items-center justify-center">
            <div class="relative bg-black rounded-2xl overflow-hidden border border-slate-800 shadow-2xl flex items-center justify-center max-h-[80vh] w-full">
                <img :src="photos[activeIndex]?.url" :alt="'Foto ' + (activeIndex + 1)" class="max-h-[80vh] w-full object-contain">
            </div>

            <!-- Footer Caption & Indicator -->
            <div class="mt-4 text-center text-white">
                <span class="px-3 py-1 bg-slate-900/80 border border-slate-700 text-emerald-400 text-xs font-bold rounded-full inline-block mb-1">
                    Foto <span x-text="activeIndex + 1"></span> dari <span x-text="photos.length"></span>
                </span>
                <p x-show="photos[activeIndex]?.caption" x-text="photos[activeIndex]?.caption" class="text-xs text-slate-300 mt-1 max-w-xl mx-auto"></p>
            </div>
        </div>
    </div>

</div>
@endsection
