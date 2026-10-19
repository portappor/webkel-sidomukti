@extends('layouts.app')

@section('title', 'Statistik Dasar & Demografi - Kelurahan Sidomukti')

@section('content')
@php
    $valTotal = (int)($settings['demografi_total'] ?? 0);
    $valLaki = (int)($settings['demografi_laki'] ?? 0);
    $valPerempuan = (int)($settings['demografi_perempuan'] ?? 0);
    $pctLaki = $valTotal > 0 ? round(($valLaki / $valTotal) * 100) : 0;
    $pctPerempuan = $valTotal > 0 ? round(($valPerempuan / $valTotal) * 100) : 0;

    // Usia
    $usia = [
        'Balita (0-5 thn)' => (int)($settings['usia_balita'] ?? 0),
        'Anak-anak (6-12 thn)' => (int)($settings['usia_anak'] ?? 0),
        'Remaja (13-17 thn)' => (int)($settings['usia_remaja'] ?? 0),
        'Usia Produktif (18-59 thn)' => (int)($settings['usia_produktif'] ?? 0),
        'Lansia (60+ thn)' => (int)($settings['usia_lansia'] ?? 0),
    ];
    $maxUsia = max($usia) ?: 1;

    // Pendidikan
    $pendidikan = [
        'Belum / Tidak Sekolah' => (int)($settings['pend_belum'] ?? 0),
        'SD / Sederajat' => (int)($settings['pend_sd'] ?? 0),
        'SMP / Sederajat' => (int)($settings['pend_smp'] ?? 0),
        'SMA / SMK / Sederajat' => (int)($settings['pend_sma'] ?? 0),
        'Diploma / Sarjana (D3/S1/S2/S3)' => (int)($settings['pend_diploma'] ?? 0),
    ];
    $maxPend = max($pendidikan) ?: 1;

    // Pekerjaan
    $pekerjaan = [
        'Wiraswasta / Pedagang' => (int)($settings['pek_wiraswasta'] ?? 0),
        'Karyawan Swasta' => (int)($settings['pek_swasta'] ?? 0),
        'ASN / PNS / TNI / Polri' => (int)($settings['pek_asn'] ?? 0),
        'Buruh Harian' => (int)($settings['pek_buruh'] ?? 0),
        'Petani / Peternak' => (int)($settings['pek_petani'] ?? 0),
        'Pelajar / Mahasiswa' => (int)($settings['pek_pelajar'] ?? 0),
        'Belum Bekerja' => (int)($settings['pek_belum'] ?? 0),
        'Lainnya' => (int)($settings['pek_lainnya'] ?? 0),
    ];
    $maxPek = max($pekerjaan) ?: 1;
@endphp

<div class="bg-slate-50 min-h-screen pb-16" x-data="{ activeTab: 'demografi' }">

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Statistik & Monografi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Statistik & Monografi Resmi
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Statistik & Monografi Kependudukan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Data agregat kependudukan, sebaran jenis kelamin, mata pencaharian, serta pembagian wilayah RT/RW di Kelurahan Sidomukti.
                </p>
            </div>
        </div>
    </div>

    <!-- Header Page -->
    <div class="bg-white border-b border-slate-200 py-6 mb-8">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-start">
                <button @click="activeTab = 'demografi'" :class="activeTab === 'demografi' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20 hover:-translate-y-0.5' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900'" class="px-5 py-2.5 font-bold text-sm rounded-xl transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Demografi Penduduk
                </button>
                <button @click="activeTab = 'wilayah'" :class="activeTab === 'wilayah' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20 hover:-translate-y-0.5' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900'" class="px-5 py-2.5 font-bold text-sm rounded-xl transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Wilayah & Sarpras
                </button>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-6xl space-y-6" x-show="activeTab === 'demografi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        


        <!-- Komposisi Gender -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Komposisi Gender</h3>
                </div>
                <div class="text-xs font-semibold text-slate-400">Total: {{ number_format($valTotal, 0, ',', '.') }} Jiwa</div>
            </div>
            
            <div class="flex justify-between text-sm font-bold mb-2">
                <div class="text-blue-500 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Laki-Laki ({{ number_format($valLaki, 0, ',', '.') }})
                </div>
                <div class="text-pink-500 flex items-center gap-1.5">
                    Perempuan ({{ number_format($valPerempuan, 0, ',', '.') }})
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </div>
            
            <div class="h-6 w-full rounded-full flex overflow-hidden">
                <div class="bg-blue-500 h-full flex items-center justify-center text-[10px] font-bold text-white transition-all duration-1000" style="width: {{ $pctLaki }}%">{{ $pctLaki }}%</div>
                <div class="bg-pink-500 h-full flex items-center justify-center text-[10px] font-bold text-white transition-all duration-1000" style="width: {{ $pctPerempuan }}%">{{ $pctPerempuan }}%</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Kelompok Umur -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-amber-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Kelompok Umur</h3>
                </div>
                
                <div class="space-y-5">
                    @foreach($usia as $label => $val)
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1.5">
                            <span class="text-slate-600">{{ $label }}</span>
                            <span class="text-slate-800">{{ number_format($val, 0, ',', '.') }} Jiwa</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $maxUsia > 0 ? ($val / $maxUsia * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tingkat Pendidikan -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-sky-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Tingkat Pendidikan</h3>
                </div>
                
                <div class="space-y-5">
                    @foreach($pendidikan as $label => $val)
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1.5">
                            <span class="text-slate-600">{{ $label }}</span>
                            <span class="text-slate-800">{{ number_format($val, 0, ',', '.') }} Jiwa</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-sky-500 rounded-full" style="width: {{ $maxPend > 0 ? ($val / $maxPend * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Jenis Pekerjaan -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-indigo-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Jenis Pekerjaan</h3>
                </div>
                
                <div class="space-y-5">
                    @foreach($pekerjaan as $label => $val)
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1.5">
                            <span class="text-slate-600">{{ $label }}</span>
                            <span class="text-slate-800">{{ number_format($val, 0, ',', '.') }} Jiwa</span>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $maxPek > 0 ? ($val / $maxPek * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Profil Wilayah & Sarpras -->
    <div class="container mx-auto px-4 max-w-6xl space-y-6" x-show="activeTab === 'wilayah'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Batas Wilayah Administrasi -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Batas Wilayah Administrasi</h3>
                </div>

                <div class="space-y-0 divide-y divide-slate-100 border border-slate-100 rounded-2xl overflow-hidden">
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">UTARA</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_utara'] ?? 'Desa Kalibuntu' }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">TIMUR</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_timur'] ?? 'Kelurahan Kraksaan Wetan' }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">SELATAN</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_selatan'] ?? 'Desa Alassumur Kulon' }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">BARAT</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_barat'] ?? 'Desa Sidomukti' }}</span>
                    </div>
                </div>
            </div>

            <!-- Inventaris Sarana & Prasarana Umum -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Inventaris Sarana & Prasarana Umum</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-emerald-50/50 rounded-2xl p-5 text-center border border-emerald-100 flex flex-col items-center justify-center">
                        <div class="text-emerald-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-emerald-700 mb-1">{{ $settings['fas_sekolah'] ?? '9' }}</div>
                        <div class="text-[10px] font-bold text-emerald-600/80 uppercase tracking-widest">Sekolah (SD/SMP/SMA)</div>
                    </div>
                    <div class="bg-blue-50/50 rounded-2xl p-5 text-center border border-blue-100 flex flex-col items-center justify-center">
                        <div class="text-blue-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-blue-700 mb-1">{{ $settings['fas_ibadah'] ?? '12' }}</div>
                        <div class="text-[10px] font-bold text-blue-600/80 uppercase tracking-widest">Masjid & Musholla</div>
                    </div>
                    <div class="bg-pink-50/50 rounded-2xl p-5 text-center border border-pink-100 flex flex-col items-center justify-center">
                        <div class="text-pink-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-pink-700 mb-1">{{ $settings['fas_kesehatan'] ?? '8' }}</div>
                        <div class="text-[10px] font-bold text-pink-600/80 uppercase tracking-widest">Posyandu & Polindes</div>
                    </div>
                    <div class="bg-amber-50/50 rounded-2xl p-5 text-center border border-amber-100 flex flex-col items-center justify-center">
                        <div class="text-amber-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-amber-700 mb-1">{{ $settings['fas_pasar'] ?? '2' }}</div>
                        <div class="text-[10px] font-bold text-amber-600/80 uppercase tracking-widest">Pasar Tradisional</div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 text-sm text-slate-500 leading-relaxed border border-slate-100">
                    <p class="font-bold text-slate-700 mb-1">Informasi Pemekaran Lingkungan:</p>
                    <p>Kelurahan terbagi ke dalam <span class="font-bold text-slate-800">{{ $settings['wilayah_rw'] ?? '0' }} Rukun Warga (RW)</span> dan <span class="font-bold text-slate-800">{{ $settings['wilayah_rt'] ?? '0' }} Rukun Tetangga (RT)</span> yang aktif menyelenggarakan rembug warga dan kegiatan poskamling swakarsa secara berkesinambungan.</p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
