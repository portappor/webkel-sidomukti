@extends('layouts.app')

@section('title', $post->title . ' - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

    <!-- Page Header (Deep Dark Theme matching portal standard) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-6 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400" aria-label="Breadcrumb">
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
                            <a href="{{ route('posts.index') }}" class="ml-1.5 text-slate-400 hover:text-emerald-400 transition font-medium">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold truncate max-w-[200px] sm:max-w-xs md:max-w-md">{{ $post->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Main Article Column (Left ~65-70%) -->
            <div class="lg:col-span-8">
                <article class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
                    
                    {{-- 1. Foto Utama (Full Width Banner) --}}
                    @if($post->thumbnail)
                    <div class="w-full mb-6 overflow-hidden rounded-xl shadow-sm">
                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full aspect-[16/9] object-cover rounded-xl shadow-sm">
                    </div>
                    @endif

                    {{-- 2. Metadata Informasi (Tepat di Bawah Gambar) --}}
                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($post->published_at ?? $post->created_at)->translatedFormat('d F Y') }} - {{ $post->category_name }} Oleh {{ $post->author ?? 'Admin' }}
                        </span>
                    </div>

                    {{-- 3. Judul Berita (Heading Utama) --}}
                    <h1 class="text-2xl md:text-3xl font-bold text-[#1e3a8a] leading-tight mt-3 mb-6">
                        {{ $post->title }}
                    </h1>

                    {{-- 4. Isi Berita (Body Content) --}}
                    <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                        {!! $post->content !!}
                    </div>

                    {{-- Footer Section --}}
                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-emerald-700 hover:text-emerald-800 font-bold text-xs sm:text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Indeks Berita
                        </a>

                        <div class="flex items-center gap-2">
                            <span class="text-xs font-medium text-slate-500">Bagikan:</span>
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!');" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Salin Tautan
                            </button>
                        </div>
                    </div>

                </article>
            </div>

            <!-- Sidebar Column (Right ~30-35%) -->
            <aside class="lg:col-span-4 space-y-6">
                
                <!-- Search Box Widget (Standardized Portal Design) -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200">
                    <form action="{{ route('posts.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="q" placeholder="Cari Informasi..." value="{{ request('q') }}" class="w-full px-4 py-2.5 text-xs sm:text-sm border border-slate-200 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-700 bg-slate-50/50 placeholder-slate-400 transition">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-r-xl transition-colors flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Informasi Lainnya Widget (Standardized Portal Design) -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h2 class="text-sm sm:text-base font-bold text-slate-800">Informasi Lainnya</h2>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                            Terkini
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($recentPosts as $item)
                        <div class="flex gap-3.5 items-start pb-3.5 border-b border-slate-100 last:border-0 last:pb-0 group">
                            {{-- Thumbnail Image --}}
                            <a href="{{ route('posts.show', $item->slug) }}" class="shrink-0 w-20 h-16 sm:w-24 sm:h-18 rounded-xl overflow-hidden bg-slate-100 block relative border border-slate-100 shadow-2xs">
                                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </a>

                            {{-- Title & Meta --}}
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('posts.show', $item->slug) }}" class="block">
                                    <h3 class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-emerald-700 transition line-clamp-2 leading-snug mb-1.5">
                                        {{ $item->title }}
                                    </h3>
                                </a>
                                <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-medium">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($item->published_at ?? $item->created_at)->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada berita lainnya saat ini.</p>
                        @endforelse
                    </div>
                </div>

            </aside>

        </div>
    </div>

</div>
@endsection
