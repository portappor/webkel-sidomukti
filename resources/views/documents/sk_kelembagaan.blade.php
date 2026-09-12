@extends('layouts.app')

@section('title', 'SK Kelembagaan Kelurahan - Kelurahan Sidomukti')

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
                            <span class="ml-1.5 text-slate-400">Dokumen</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">SK Kelembagaan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-950/60 border border-amber-500/30 rounded-full text-amber-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    Legalitas & Tata Kelola Kelembagaan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    SK Kelembagaan Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Arsip Surat Keputusan (SK) resmi pengukuhan kepengurusan RT/RW, LPMK, TP-PKK, dan Karang Taruna Kelurahan Sidomukti.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
            @foreach($skList as $sk)
            @php
                $theme = $sk['theme'] ?? 'emerald';
                $badgeBg = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                $iconColor = 'bg-emerald-50 text-emerald-600 border-emerald-100';

                if ($theme === 'rose') {
                    $badgeBg = 'bg-rose-50 text-rose-700 border-rose-200/60';
                    $iconColor = 'bg-rose-50 text-rose-600 border-rose-100';
                } elseif ($theme === 'blue') {
                    $badgeBg = 'bg-blue-50 text-blue-700 border-blue-200/60';
                    $iconColor = 'bg-blue-50 text-blue-600 border-blue-100';
                } elseif ($theme === 'amber') {
                    $badgeBg = 'bg-amber-50 text-amber-800 border-amber-200/60';
                    $iconColor = 'bg-amber-50 text-amber-600 border-amber-100';
                }
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/90 flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-200 group h-full">
                <div>
                    <!-- Top Badge & Organization -->
                    <div class="flex items-center justify-between gap-2 mb-3.5">
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badgeBg }}">
                            {{ $sk['organization'] }}
                        </span>
                        <span class="text-[11px] font-semibold text-slate-500">
                            Periode: {{ $sk['period'] }}
                        </span>
                    </div>

                    <div class="flex items-start gap-3.5 mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border shadow-2xs {{ $iconColor }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug">
                                {{ $sk['title'] }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-600 mt-0.5 font-mono">
                                {{ $sk['sk_number'] }}
                            </p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed mb-5">
                        {{ $sk['description'] }}
                    </p>
                </div>

                <!-- Footer & Action -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                    <div class="text-[11px] text-slate-500 font-medium">
                        <span>{{ $sk['file_size'] }}</span> • <span>{{ $sk['date'] }}</span>
                    </div>
                    <a href="{{ $sk['download_url'] }}" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-2xs flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Unduh SK</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
