@extends('layouts.app')

@section('title', 'Tugas & Fungsi - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

    <!-- Page Header -->
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
                            <span class="ml-1.5 text-slate-400">Profil</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Tugas & Fungsi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-950/60 border border-amber-500/30 rounded-full text-amber-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    Penjelasan Tugas Pokok
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Tugas & Fungsi Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Informasi mengenai tugas pokok dan fungsi pelayanan administrasi di Kelurahan Sidomukti.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200/90">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Tugas Pokok & Keterangan Struktur</span>
            </div>
            
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-5 leading-snug">
                Tugas dan Fungsi Penyelenggaraan Pemerintahan
            </h2>
            
            @if(!empty($settings['tugas_fungsi']))
            <div class="prose prose-slate prose-base max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-emerald-600 hover:prose-a:text-emerald-700 text-slate-700 leading-relaxed space-y-4">
                {!! \Illuminate\Support\Str::startsWith(trim($settings['tugas_fungsi']), '<') ? $settings['tugas_fungsi'] : \Illuminate\Support\Str::markdown($settings['tugas_fungsi']) !!}
            </div>
            @else
            <div class="space-y-4 text-sm sm:text-base text-slate-700 leading-relaxed">
                <p>
                    Belum ada informasi tugas dan fungsi yang dipublikasikan.
                </p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
