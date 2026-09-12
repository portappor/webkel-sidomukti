@extends('layouts.app')

@section('title', 'Video Dokumentasi Kegiatan - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen py-8"
     x-data="{
        videoModal: false,
        activeEmbed: '',
        activeTitle: '',
        openPlayer(embedUrl, title) {
            this.activeEmbed = embedUrl + '?autoplay=1';
            this.activeTitle = title;
            this.videoModal = true;
        },
        closePlayer() {
            this.videoModal = false;
            this.activeEmbed = '';
        }
     }">

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Video Dokumentasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Dokumentasi Video Resmi
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Video Dokumentasi & Pelayanan Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Kumpulan tayangan video dokumentasi program pembangunan, liputan liputan kegiatan kemasyarakatan, serta video profil resmi Kelurahan Sidomukti.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container mx-auto px-4 max-w-7xl">

        <!-- Filter Bar Kategori Video -->
        <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-slate-200/90 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0">
                <a href="{{ route('videos.index', ['category' => 'all']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ ($category ?? 'all') === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   Semua Video
                </a>
                <a href="{{ route('videos.index', ['category' => 'pemerintahan']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ ($category ?? '') === 'pemerintahan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   Pemerintahan
                </a>
                <a href="{{ route('videos.index', ['category' => 'pembangunan']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ ($category ?? '') === 'pembangunan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   Pembangunan
                </a>
                <a href="{{ route('videos.index', ['category' => 'pemberdayaan']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ ($category ?? '') === 'pemberdayaan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   Pemberdayaan
                </a>
                <a href="{{ route('videos.index', ['category' => 'keagamaan']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ ($category ?? '') === 'keagamaan' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   Keagamaan
                </a>
                <a href="{{ route('videos.index', ['category' => 'hut-ri']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ ($category ?? '') === 'hut-ri' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                   HUT RI
                </a>
            </div>

            <div class="text-xs text-slate-500 font-medium shrink-0">
                Menampilkan {{ $videos->total() }} Video
            </div>
        </div>

        <!-- Grid Kartu Video -->
        @if($videos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-10">
            @foreach($videos as $video)
            <div @click="openPlayer('{{ $video->embed_url }}', '{{ addslashes($video->title) }}')"
                 class="bg-white rounded-2xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col group cursor-pointer">
                
                <!-- Thumbnail Cover Video (16:9 Ratio) -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-900">
                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition duration-300"></div>

                    <!-- Category Badge Top-Left -->
                    <div class="absolute top-3 left-3 z-10">
                        <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-extrabold uppercase tracking-wider rounded-lg border border-slate-700">
                            {{ ucfirst($video->category) }}
                        </span>
                    </div>

                    <!-- Play Icon Center Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center z-10">
                        <div class="w-13 h-13 rounded-full bg-emerald-600/90 text-white shadow-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-emerald-500 transition duration-300 border border-white/20">
                            <svg class="w-7 h-7 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>

                    <!-- Duration Badge Bottom-Right -->
                    @if($video->duration)
                    <div class="absolute bottom-3 right-3 z-10">
                        <span class="px-2.5 py-1 bg-slate-950/90 text-white text-[11px] font-bold rounded-lg border border-slate-700 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $video->duration }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Info Body -->
                <div class="p-4 flex flex-col justify-between flex-grow">
                    <div>
                        <h3 class="font-bold text-sm text-slate-800 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-2">
                            {{ $video->title }}
                        </h3>
                        @if($video->description)
                        <p class="text-xs text-slate-500 line-clamp-2 mb-3">
                            {{ $video->description }}
                        </p>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $video->created_at->translatedFormat('d F Y') }}
                        </span>
                        <span class="text-emerald-600 font-bold group-hover:translate-x-0.5 transition flex items-center gap-0.5">
                            Putar Video &rarr;
                        </span>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        <div class="mb-10">
            {{ $videos->links() }}
        </div>
        @else
        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 max-w-xl mx-auto my-8">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Video Dokumentasi</h3>
            <p class="text-slate-500 text-xs mt-1">Belum ada video yang diunggah untuk kategori ini.</p>
        </div>
        @endif

    </div>

    <!-- Video Modal Player (Alpine.js) -->
    <div x-show="videoModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="closePlayer()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-md"
         style="display: none;">
        
        <div @click.away="closePlayer()" class="relative max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800">
            <!-- Close Button -->
            <button @click="closePlayer()" class="absolute top-4 right-4 z-50 w-11 h-11 bg-slate-950/80 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition shadow-lg border border-slate-700 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Video Player Screen -->
            <div class="relative aspect-video w-full bg-black flex items-center justify-center">
                <iframe x-show="activeEmbed"
                        :src="activeEmbed" 
                        class="w-full h-full" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>

            <!-- Footer Caption -->
            <div class="p-4 bg-slate-900 border-t border-slate-800 text-white flex items-center justify-between">
                <h3 class="font-bold text-sm text-white truncate max-w-2xl" x-text="activeTitle"></h3>
                <span class="text-xs text-slate-400">Video Dokumentasi Resmi</span>
            </div>
        </div>
    </div>

</div>
@endsection
