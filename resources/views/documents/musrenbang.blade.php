@extends('layouts.app')

@section('title', 'Dokumen & Hasil Musrenbang - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen" x-data="{ search: '' }">

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Hasil Musrenbang</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        Perencanaan Pembangunan Partisipatif
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                        Dokumen & Hasil Musrenbang
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                        Wadah resmi transparansi publikasi hasil kesepakatan Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan Sidomukti.
                    </p>
                </div>

                <!-- Quick Search Input in Header -->
                <div class="w-full lg:w-80 shrink-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input 
                            type="text" 
                            x-model="search"
                            placeholder="Cari nama berkas musrenbang..." 
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-700 bg-slate-800/80 text-white placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-inner">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Document Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            
            <!-- Table Header Bar -->
            <div class="p-5 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3 bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Daftar Berkas Musrenbang 2026</h3>
                        <p class="text-[11px] text-slate-500">Format dokumen PDF resmi siap unduh.</p>
                    </div>
                </div>
                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/60">
                    {{ count($documents) }} Berkas Tersedia
                </span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-200/80">
                            <th class="py-3 px-5">Nama Dokumen & Keterangan</th>
                            <th class="py-3 px-4 hidden md:table-cell">Kategori</th>
                            <th class="py-3 px-4 hidden sm:table-cell">Tanggal</th>
                            <th class="py-3 px-4 hidden sm:table-cell">Ukuran</th>
                            <th class="py-3 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach($documents as $doc)
                        <tr class="hover:bg-slate-50 transition-colors" x-show="!search || '{{ strtolower($doc['title'] . ' ' . $doc['description']) }}'.includes(search.toLowerCase())">
                            <td class="py-4 px-5">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100 shadow-2xs mt-0.5 font-bold text-[11px]">
                                        PDF
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-bold text-slate-800 text-sm leading-snug">{{ $doc['title'] }}</h4>
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-full border border-emerald-200/60">{{ $doc['status'] }}</span>
                                        </div>
                                        <p class="text-slate-500 text-xs mt-1 leading-relaxed">{{ $doc['description'] }}</p>
                                        <div class="flex sm:hidden items-center gap-3 mt-1.5 text-[11px] text-slate-400 font-medium">
                                            <span>{{ $doc['date'] }}</span>
                                            <span>•</span>
                                            <span>{{ $doc['file_size'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 hidden md:table-cell">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-lg text-[11px]">{{ $doc['category'] }}</span>
                            </td>
                            <td class="py-4 px-4 hidden sm:table-cell font-medium text-slate-600 text-xs">
                                {{ $doc['date'] }}
                            </td>
                            <td class="py-4 px-4 hidden sm:table-cell font-semibold text-slate-600 text-xs">
                                {{ $doc['file_size'] }}
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ $doc['download_url'] }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <span>Unduh</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer Note -->
            <div class="p-4 bg-slate-50/80 border-t border-slate-100 text-center text-[11px] text-slate-500 font-medium">
                Setiap berkas dokumen yang tercantum telah melalui proses validasi Bappeda & Pemerintah Kabupaten Probolinggo.
            </div>
        </div>

    </div>
</div>
@endsection
