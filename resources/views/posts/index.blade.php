@extends('layouts.app')

@section('title', 'Berita & Artikel Terkini - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

    <!-- Page Header (Deep Dark Theme matching portal standard) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Berita & Artikel</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Kabar & Publikasi Terkini
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Indeks Berita Kelurahan Sidomukti
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Pusat informasi, liputan kegiatan masyarakat, pengumuman resmi, dan kabar pembangunan di wilayah Kelurahan Sidomukti.
                </p>

                {{-- Category Filter Pills in Header --}}
                @if(isset($categories) && $categories->count() > 0)
                <div class="flex flex-wrap items-center gap-2 mt-5">
                    <a href="{{ route('posts.index') }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ !request('kategori') ? 'bg-emerald-500 text-slate-950 font-bold shadow-sm' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700' }}">
                        Semua Berita
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('posts.index', ['kategori' => $cat->slug]) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ request('kategori') == $cat->slug ? 'bg-emerald-500 text-slate-950 font-bold shadow-sm' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700' }}">
                        {{ $cat->name }}
                        @if($cat->posts_count > 0)
                            <span class="ml-1 text-[10px] opacity-75">({{ $cat->posts_count }})</span>
                        @endif
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8">

        @if($posts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
            @foreach($posts as $post)
            <article class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden hover:shadow-md hover:border-emerald-400 transition duration-200 group flex flex-col h-full">
                <div class="relative h-44 overflow-hidden bg-slate-200 shrink-0">
                    <img src="{{ $post->thumbnail ? Storage::url($post->thumbnail) : 'https://images.unsplash.com/photo-1544396821-4dd40b938ad3?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-2.5 left-2.5 flex flex-col text-center shadow-md rounded-lg overflow-hidden">
                        <span class="bg-emerald-600 text-white font-extrabold text-sm px-2.5 py-0.5">{{ \Carbon\Carbon::parse($post->published_at)->format('d') }}</span>
                        <span class="bg-white text-slate-800 text-[8.5px] font-bold uppercase px-1.5 py-0.5 leading-none tracking-wider">{{ \Carbon\Carbon::parse($post->published_at)->format('M Y') }}</span>
                    </div>
                </div>

                <div class="p-4 flex flex-col flex-grow justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2 text-[11px] text-slate-400 font-medium">
                            <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full font-bold text-[10px] border border-emerald-200/60">
                                {{ $post->category_name ?? 'Berita' }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ $post->views }}
                            </span>
                        </div>

                        <a href="{{ route('posts.show', $post->slug) }}">
                            <h3 class="font-bold text-slate-800 text-sm leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-2">
                                {{ $post->title }}
                            </h3>
                        </a>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">
                            {{ Str::limit(strip_tags(html_entity_decode($post->excerpt ?? $post->content)), 100) }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                            <span>Baca Selengkapnya</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="flex justify-center pb-6">
            {{ $posts->links() }}
        </div>
        @else
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center max-w-lg mx-auto shadow-sm">
            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            <h3 class="font-bold text-slate-800 text-base mb-1">Belum Ada Berita</h3>
            <p class="text-xs text-slate-500">Belum ada artikel atau berita yang dipublikasikan pada kategori ini.</p>
        </div>
        @endif

    </div>
</div>
@endsection
