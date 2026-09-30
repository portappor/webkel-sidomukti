@extends('layouts.app')

@section('title', $menu->title . ' - Kelurahan Sidomukti')

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
                    @if($menu->parent)
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1.5 text-slate-400">{{ $menu->parent->title }}</span>
                            </div>
                        </li>
                    @else
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1.5 text-slate-400">Profil</span>
                            </div>
                        </li>
                    @endif
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">{{ $menu->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Informasi Resmi Kelurahan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    {{ $menu->title }}
                </h1>
                @if(!empty($menu->description))
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                        {{ $menu->description }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="space-y-6">

            <!-- Content Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/90 overflow-hidden">
                <div class="p-6 md:p-8">
                    
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold border border-emerald-100 shadow-2xs shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-700">Publikasi Resmi</span>
                            <h2 class="text-lg md:text-xl font-bold text-slate-900">{{ $menu->title }}</h2>
                        </div>
                    </div>

                    @if(!empty($menu->image))
                        <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 shadow-2xs">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->title }}" class="w-full max-h-[450px] object-cover">
                        </div>
                    @endif

                    @if(!empty($menu->content))
                        <div class="prose prose-slate prose-base max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-emerald-600 hover:prose-a:text-emerald-700 text-slate-700 leading-relaxed space-y-4">
                            {!! \Illuminate\Support\Str::startsWith(trim($menu->content), '<') ? $menu->content : nl2br(e($menu->content)) !!}
                        </div>
                    @else
                        <!-- Fallback Alert Box when Content is empty -->
                        <div class="p-6 md:p-8 bg-slate-50 rounded-xl border border-slate-200 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Konten Sedang Dalam Penyusunan</h3>
                            <p class="text-slate-600 text-xs sm:text-sm max-w-md mx-auto leading-relaxed">
                                Informasi detail untuk rincian <strong>"{{ $menu->title }}"</strong> sedang disiapkan oleh Pengelola Website dan Pemerintah Kelurahan Sidomukti, Kecamatan Kraksaan.
                            </p>
                            @if(!empty($menu->description))
                                <div class="mt-4 p-4 bg-white rounded-lg border border-slate-200 max-w-lg mx-auto text-left text-xs text-slate-700 font-medium">
                                    <span class="font-bold text-emerald-700 block mb-1">Ringkasan Info:</span>
                                    {{ $menu->description }}
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            <!-- Bottom Information Box -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500 font-medium">
                <span>Pemerintah Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo</span>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-bold transition">
                    <span>Kembali ke Beranda</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
