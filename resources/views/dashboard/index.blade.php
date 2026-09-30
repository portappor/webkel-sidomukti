@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
@php
    $user = auth()->user();
    $hour = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H');
    if ($hour >= 5 && $hour < 11) {
        $greeting = 'Selamat Pagi 🌅';
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Selamat Siang ☀️';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat Sore 🌤️';
    } else {
        $greeting = 'Selamat Malam 🌙';
    }
    $userName = $user ? $user->name : 'Administrator';
    $userRole = $user && $user->role === 'admin' ? 'SUPER ADMIN' : 'STAF OPERATOR';
    $userEmail = $user ? $user->email : 'admin@sidomukti.probolinggokab.go.id';
    $userAvatar = $user && $user->avatar ? (str_starts_with($user->avatar, 'http') ? $user->avatar : Storage::url($user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&color=ffffff&background=059669&size=200';
    $kelurahanName = \App\Models\Setting::where('key', 'nama_kelurahan')->value('value') ?? (\App\Models\Setting::where('key', 'agency_name')->value('value') ?? 'Kelurahan Sidomukti');
@endphp

<!-- HERO WELCOME CARD DYNAMIC ACCORDING TO LOGGED IN USER -->
<div class="mb-8 bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden border border-emerald-900/40">
    <!-- Decorative background elements -->
    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-96 h-full bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:20px_20px] opacity-10 pointer-events-none"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        
        <!-- Left: User Avatar & Welcome Text -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
            <div class="relative shrink-0">
                <img src="{{ $userAvatar }}" 
                     alt="{{ $userName }}" 
                     class="w-20 h-20 md:w-22 md:h-22 object-cover rounded-2xl border-2 border-emerald-400 p-0.5 shadow-xl bg-slate-800">
                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-slate-950 rounded-full shadow-sm" title="Status Online"></span>
            </div>

            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-extrabold text-emerald-400 tracking-wider uppercase bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                        {{ $greeting }}
                    </span>
                    <span class="px-2.5 py-0.5 bg-purple-500/20 text-purple-300 text-[10px] font-black uppercase rounded-full border border-purple-500/30 tracking-wider">
                        {{ $userRole }}
                    </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-black tracking-tight text-white flex items-center gap-2">
                    Selamat datang kembali, <span class="text-emerald-400 underline decoration-emerald-500/40 decoration-wavy">{{ $userName }}</span>!
                </h2>

                <p class="text-xs text-slate-300 font-medium max-w-2xl leading-relaxed">
                    Anda berhasil masuk sebagai <span class="font-bold text-white">{{ $userRole }}</span>. Seluruh sistem pelayanan publik, arsip dokumen, dan galeri kegiatan {{ $kelurahanName }} siap dikelola secara langsung.
                </p>
            </div>
        </div>

        <!-- Right: Day & Date Widget inside the Card -->
        <div class="shrink-0 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-800">
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 border border-white/15 rounded-2xl flex items-center gap-2.5 text-xs font-bold text-slate-200 shadow-sm">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>

    </div>
</div>

<!-- ====================================================
     1. KPI METRIC CARDS (BARIS ATAS REAL DATA)
     ==================================================== -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    <!-- Card 1: Total Dokumen SOP Layanan -->
    <a href="{{ route('dashboard.services.index') }}" class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group block">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">{{ $stats['active_sop'] }} Aktif</span>
        </div>
        <p class="text-3xl font-black text-slate-800 leading-none mb-1">{{ $stats['total_sop'] }}</p>
        <p class="text-xs text-slate-500 font-semibold">Total Dokumen SOP Layanan</p>
    </a>

    <!-- Card 2: Total Arsip Dokumen Publik -->
    <a href="{{ route('dashboard.documents.index') }}" class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group block">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">PDF Publik</span>
        </div>
        <p class="text-3xl font-black text-slate-800 leading-none mb-1">{{ $stats['total_dokumen'] }}</p>
        <p class="text-xs text-slate-500 font-semibold">Total Arsip Dokumen Publik</p>
    </a>

    <!-- Card 3: Lembaga Kemasyarakatan -->
    <a href="{{ route('dashboard.lembagas.index') }}" class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group block">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-100">Kelembagaan</span>
        </div>
        <p class="text-3xl font-black text-slate-800 leading-none mb-1">{{ $stats['total_lembaga'] }}</p>
        <p class="text-xs text-slate-500 font-semibold">Lembaga Kemasyarakatan</p>
    </a>

    <!-- Card 4: Total Berita / Agenda -->
    <a href="{{ route('dashboard.posts.index') }}" class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group block">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full border border-purple-100">Informasi</span>
        </div>
        <p class="text-3xl font-black text-slate-800 leading-none mb-1">{{ $stats['total_berita_agenda'] }}</p>
        <p class="text-xs text-slate-500 font-semibold">Total Berita & Agenda</p>
    </a>

</div>

<!-- ====================================================
     2. MAIN CONTENT GRID (2 COLUMNS)
     ==================================================== -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- LEFT COLUMN (2 SPANS): TABEL AGENDA & STANDAR LAYANAN -->
    <div class="xl:col-span-2 space-y-6">

        <!-- TABEL JADWAL AGENDA KEGIATAN TERDEKAT -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                    <h2 class="font-black text-slate-800 text-sm">Jadwal Agenda Kegiatan Terdekat</h2>
                </div>
                <a href="{{ route('dashboard.agendas.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">Kelola Agenda →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-wider border-b border-slate-100">
                            <th class="py-3 px-6">Tanggal & Waktu</th>
                            <th class="py-3 px-6">Nama Kegiatan</th>
                            <th class="py-3 px-6">Lokasi</th>
                            <th class="py-3 px-6">Penyelenggara</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($upcomingAgendas as $ag)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-6 whitespace-nowrap">
                                <div class="font-bold text-slate-800">
                                    {{ is_string($ag->date) ? $ag->date : $ag->date->format('d M Y') }}
                                </div>
                                <div class="text-[11px] text-slate-400 font-medium">{{ $ag->time ?? 'Sesuai Jadwal' }}</div>
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-800">
                                {{ $ag->title }}
                            </td>
                            <td class="py-3.5 px-6 text-slate-600 font-medium">
                                {{ $ag->location ?? 'Kantor Kelurahan' }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded font-bold text-[10px]">
                                    {{ $ag->organizer ?? $kelurahanName }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 font-medium">Belum ada agenda terdekat yang dijadwalkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- STANDAR PELAYANAN & SOP OVERVIEW (INTEGRATED REAL DATA) -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-1.5 h-5 bg-emerald-500 rounded-full"></div>
                    <h2 class="font-black text-slate-800 text-sm">Standar Pelayanan & SOP Kependudukan ({{ $stats['total_sop'] }} SOP)</h2>
                </div>
                <a href="{{ route('dashboard.services.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">Kelola Semua →</a>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    @forelse($servicesList as $srvIdx => $srv)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between hover:border-emerald-200 transition">
                            <span class="font-bold text-slate-700 truncate pr-2">{{ $srvIdx + 1 }}. {{ $srv->title }}</span>
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 font-bold rounded text-[10px] shrink-0">
                                {{ $srv->pdf_file ? 'PDF Active' : 'Aktif' }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-4 text-slate-400 font-medium">
                            Belum ada dokumen SOP pelayanan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN (1 SPAN): QUICK ACTIONS & STATISTIK PENDUDUK -->
    <div class="space-y-6">

        <!-- QUICK ACTIONS SHORTCUT CARD -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200 p-5">
            <h3 class="font-black text-slate-800 text-sm mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Quick Actions Shortcut
            </h3>
            
            <div class="space-y-2.5">
                <!-- Action 1: + Tambah Berita -->
                <a href="{{ route('dashboard.posts.create') }}" 
                   class="w-full flex items-center justify-between px-4 py-3 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl transition duration-200 border border-emerald-200/60 group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                            +
                        </div>
                        <span class="font-extrabold text-xs">Tambah Berita Baru</span>
                    </div>
                    <svg class="w-4 h-4 text-emerald-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <!-- Action 2: + Upload SOP -->
                <a href="{{ route('dashboard.services.index') }}" 
                   class="w-full flex items-center justify-between px-4 py-3 bg-blue-50 hover:bg-blue-100 text-blue-800 rounded-xl transition duration-200 border border-blue-200/60 group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                            +
                        </div>
                        <span class="font-extrabold text-xs">Upload Dokumen SOP</span>
                    </div>
                    <svg class="w-4 h-4 text-blue-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <!-- Action 3: + Unggah Dokumen -->
                <a href="{{ route('dashboard.documents.index') }}" 
                   class="w-full flex items-center justify-between px-4 py-3 bg-purple-50 hover:bg-purple-100 text-purple-800 rounded-xl transition duration-200 border border-purple-200/60 group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                            +
                        </div>
                        <span class="font-extrabold text-xs">Unggah Dokumen PDF</span>
                    </div>
                    <svg class="w-4 h-4 text-purple-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <!-- Action 4: Kelola APBD Transparansi -->
                <a href="{{ route('dashboard.apbd.index') }}" 
                   class="w-full flex items-center justify-between px-4 py-3 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-xl transition duration-200 border border-amber-200/60 group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-600 text-white flex items-center justify-center font-bold text-sm shadow-2xs">
                            %
                        </div>
                        <span class="font-extrabold text-xs">Transparansi Anggaran (APBD)</span>
                    </div>
                    <svg class="w-4 h-4 text-amber-600 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- WIDGET RINGKASAN STATISTIK PENDUDUK (REAL SETTINGS & DATABASE) -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-5 text-white shadow-md relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex items-center justify-between mb-4 border-b border-slate-700/60 pb-3">
                <h3 class="font-black text-sm text-slate-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Statistik Penduduk
                </h3>
                <a href="{{ route('dashboard.demographics.index') }}" class="text-[11px] font-bold text-emerald-400 hover:underline">Monografi →</a>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700/50">
                    <span class="text-[10px] text-slate-400 uppercase font-black tracking-wider block mb-0.5">Total Penduduk</span>
                    <span class="text-xl font-black text-emerald-400">{{ number_format($demographics['total_penduduk']) }}</span>
                    <span class="text-[10px] text-slate-400 ml-1">Jiwa</span>
                </div>
                <div class="bg-slate-800/80 p-3 rounded-xl border border-slate-700/50">
                    <span class="text-[10px] text-slate-400 uppercase font-black tracking-wider block mb-0.5">Kepala Keluarga</span>
                    <span class="text-xl font-black text-teal-300">{{ number_format($demographics['total_kk']) }}</span>
                    <span class="text-[10px] text-slate-400 ml-1">KK</span>
                </div>
            </div>

            <div class="space-y-2.5 text-xs">
                <div>
                    <div class="flex justify-between text-[11px] font-bold mb-1 text-slate-300">
                        <span>Laki-Laki ({{ $demographics['pct_laki'] }}%)</span>
                        <span class="text-emerald-400">{{ number_format($demographics['laki_laki']) }} Jiwa</span>
                    </div>
                    <div class="w-full bg-slate-700/80 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-400 h-2 rounded-full" style="width: {{ $demographics['pct_laki'] }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-[11px] font-bold mb-1 text-slate-300">
                        <span>Perempuan ({{ $demographics['pct_perempuan'] }}%)</span>
                        <span class="text-teal-300">{{ number_format($demographics['perempuan']) }} Jiwa</span>
                    </div>
                    <div class="w-full bg-slate-700/80 rounded-full h-2 overflow-hidden">
                        <div class="bg-teal-400 h-2 rounded-full" style="width: {{ $demographics['pct_perempuan'] }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-700/60 flex justify-between text-xs text-slate-300 font-bold">
                <span>Wilayah Administratif:</span>
                <span class="text-emerald-400">{{ $demographics['total_rt'] }} RT / {{ $demographics['total_rw'] }} RW</span>
            </div>
        </div>

    </div>

</div>
@endsection
