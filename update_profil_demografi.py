import os

file_path = r"d:\portal-desa\webkel-sidomukti\resources\views\profil\demografi.blade.php"

new_content = """@extends('layouts.app')

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

<div class="bg-slate-50 min-h-screen pb-16">
    <!-- Header Page -->
    <div class="bg-white border-b border-slate-200 py-6 mb-8">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-start">
                <a href="{{ route('profil.demografi') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-500/20 flex items-center gap-2 transition hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Demografi Penduduk
                </a>
                <a href="#" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-bold text-sm rounded-xl transition flex items-center gap-2 cursor-not-allowed">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Wilayah & Sarpras
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-6xl space-y-6">
        
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
</div>
@endsection
"""

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_content)

print("Updated profil demografi view successfully!")
