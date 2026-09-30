@extends('layouts.app')

@section('title', 'Agenda & Jadwal Kegiatan - Kelurahan Sidomukti')

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Agenda Kegiatan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Jadwal Acara & Kegiatan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Agenda Kegiatan Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Informasi jadwal acara resmi kelurahan, kerja bakti lingkungan, posyandu balita/lansia, musrenbangkel, dan rapat koordinasi RT/RW.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
            @if(isset($agendas) && $agendas->count() > 0)
                @foreach($agendas as $agenda)
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-200/90 flex flex-col justify-between hover:shadow-md hover:border-emerald-400 transition-all duration-200 group h-full">
                    <div>
                        @if($agenda->image)
                        <div class="mb-4 rounded-xl overflow-hidden h-48 w-full border border-slate-200/80 shadow-2xs">
                            <img src="{{ Storage::url($agenda->image) }}" alt="{{ $agenda->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @endif

                        <!-- Top Badges -->
                        <div class="flex items-center justify-between gap-3 mb-3.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200/60">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @php
                                    $startDateStr = $agenda->date ? \Carbon\Carbon::parse($agenda->date)->translatedFormat('d M Y') : 'Terjadwal';
                                    $endDateStr = $agenda->end_date ? \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d M Y') : null;
                                @endphp
                                @if($endDateStr && $endDateStr !== $startDateStr)
                                    {{ $startDateStr }} s/d {{ $endDateStr }}
                                @else
                                    {{ $startDateStr }}
                                @endif
                            </span>
                            
                            @if($agenda->time)
                            <span class="inline-flex items-center gap-1 text-slate-500 text-xs font-semibold">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @if($agenda->end_time)
                                    {{ $agenda->time }} s/d {{ $agenda->end_time }}
                                @else
                                    {{ $agenda->time }}
                                @endif
                            </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-emerald-700 transition">
                            {{ $agenda->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-xs text-slate-500 leading-relaxed mb-5">
                            {{ $agenda->description }}
                        </p>
                    </div>

                    <!-- Meta Information (Location & Organizer) -->
                    <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                        @if($agenda->location)
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Lokasi: <strong class="text-slate-800">{{ $agenda->location }}</strong></span>
                        </div>
                        @endif
                        @if($agenda->organizer)
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Penyelenggara: <strong class="text-slate-800">{{ $agenda->organizer }}</strong></span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Belum Ada Agenda Mendatang</h3>
                    <p class="text-xs text-slate-500">Jadwal kegiatan warga dan kelurahan akan diperbarui secara berkala.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
