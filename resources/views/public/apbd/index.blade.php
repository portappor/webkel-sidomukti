@extends('layouts.app')

@section('title', 'Transparansi APBD - Kelurahan Sidomukti')

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Transparansi Anggaran</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Anggaran Desa / Kelurahan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Transparansi Anggaran
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Rincian publikasi Anggaran Pendapatan dan Belanja Kelurahan (APB-Kel) Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo.
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 md:py-12 max-w-7xl">

    @if($apbds->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 shadow-sm max-w-2xl mx-auto">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h4 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Publikasi APBD</h4>
            <p class="text-slate-500">Saat ini belum ada dokumen transparansi anggaran yang dipublikasikan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($apbds as $apbd)
                <article class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full relative">
                    <div class="relative h-40 overflow-hidden bg-slate-200 shrink-0">
                        @if($apbd->thumbnail)
                            <img src="{{ Storage::url($apbd->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $apbd->title }}">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-300 bg-slate-100">
                                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3 flex flex-col text-center shadow-lg rounded-lg overflow-hidden">
                            <span class="bg-[#008c5f] text-white font-extrabold text-base px-2.5 py-0.5">{{ \Carbon\Carbon::parse($apbd->date)->format('d') }}</span>
                            <span class="bg-white text-slate-800 text-[9px] font-bold uppercase px-2 py-0.5 leading-none tracking-wider">{{ \Carbon\Carbon::parse($apbd->date)->format('M Y') }}</span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="bg-amber-400 text-slate-900 text-[9px] font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider shadow">Tahun {{ $apbd->year }}</span>
                        </div>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-base font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-[#008c5f] transition-colors leading-snug">
                            <a href="{{ route('apbd.show', $apbd->id) }}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $apbd->title }}
                            </a>
                        </h3>
                        
                        <p class="text-slate-500 text-xs mb-4 line-clamp-2 flex-grow">
                            {{ $apbd->description ?: 'Dokumen publikasi APBD Kelurahan Sidomukti.' }}
                        </p>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] font-bold text-[#008c5f] uppercase tracking-wider group-hover:text-[#00734e] transition-colors">Lihat Rincian</span>
                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center group-hover:bg-[#008c5f] group-hover:text-white transition-colors text-emerald-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
    </div>
</div>
@endsection
