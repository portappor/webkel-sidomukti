import os

view_path = r"d:\portal-desa\webkel-sidomukti\resources\views\dashboard\demographics\index.blade.php"

new_index = """@extends('layouts.admin')

@section('title', 'Statistik & Demografi Warga')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Statistik & Demografi Warga</h2>
        <p class="text-slate-500 text-sm mt-1">Mengatur data statistik penduduk, pekerjaan, dan pendidikan.</p>
    </div>
    <div class="text-right">
        <div class="text-sm font-bold text-slate-700">{{ now()->translatedFormat('l, d F Y') }}</div>
        <div class="text-xs text-slate-500">{{ now()->format('H:i:s') }} WIB</div>
        <a href="{{ url('/') }}" target="_blank" class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg text-xs font-bold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Website
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl relative mb-6 shadow-xs flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    <span class="font-semibold text-sm">{{ session('success') }}</span>
</div>
@endif

<form action="{{ route('dashboard.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Kartu Statistik Beranda -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 flex flex-col md:flex-row">
        <div class="md:w-1/3 bg-slate-50/50 p-6 md:p-8 border-b md:border-b-0 md:border-r border-slate-100 flex flex-col justify-center">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <h3 class="text-xl font-extrabold text-slate-800 mb-2 leading-tight">Kartu<br>Statistik<br>Beranda</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">Mengelola daftar kartu statistik (seperti Jumlah Penduduk, KK) yang tampil di beranda.</p>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Simpan Kartu
            </button>
        </div>
        <div class="md:w-2/3 p-6 md:p-8">
            <div class="grid grid-cols-[1.5fr_1fr_1fr_1fr] gap-4 mb-4 text-xs font-bold text-slate-400 uppercase tracking-wider px-4">
                <div>Ikon & Judul</div>
                <div>Nilai / Angka</div>
                <div>Warna Tema</div>
                <div>Status Tampil</div>
            </div>
            
            <div class="space-y-3">
                <!-- Item 1 -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[37.5%] flex items-center gap-3">
                        <div class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                        <span class="font-bold text-slate-700 text-sm">Jumlah Penduduk</span>
                    </div>
                    <div class="w-[25%] font-bold text-emerald-600 text-sm">
                        <input type="text" name="demografi_total" value="{{ $settings['demografi_total'] ?? '0' }}" class="w-full bg-transparent border-0 p-0 focus:ring-0 text-emerald-600 font-bold" readonly>
                    </div>
                    <div class="w-[25%]">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded uppercase tracking-wide">Emerald</span>
                    </div>
                    <div class="w-[12.5%] flex items-center justify-between">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_penduduk" value="1" class="sr-only peer" {{ ($settings['show_penduduk'] ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[37.5%] flex items-center gap-3">
                        <div class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg></div>
                        <span class="font-bold text-slate-700 text-sm">Kepala Keluarga</span>
                    </div>
                    <div class="w-[25%] font-bold text-emerald-600 text-sm">
                        <input type="text" name="demografi_kk" value="{{ $settings['demografi_kk'] ?? '0' }}" class="w-20 bg-transparent border-0 p-0 focus:ring-0 text-emerald-600 font-bold border-b border-dashed border-emerald-300">
                    </div>
                    <div class="w-[25%]">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded uppercase tracking-wide">Emerald</span>
                    </div>
                    <div class="w-[12.5%] flex items-center justify-between">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_kk" value="1" class="sr-only peer" {{ ($settings['show_kk'] ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[37.5%] flex items-center gap-3">
                        <div class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0v5"></path></svg></div>
                        <span class="font-bold text-slate-700 text-sm">Wilayah RT / RW</span>
                    </div>
                    <div class="w-[25%] font-bold text-emerald-600 text-sm flex items-center gap-1">
                        <input type="text" name="wilayah_rt" value="{{ $settings['wilayah_rt'] ?? '0' }}" class="w-10 bg-transparent border-0 p-0 focus:ring-0 text-emerald-600 font-bold border-b border-dashed border-emerald-300 text-center"> / 
                        <input type="text" name="wilayah_rw" value="{{ $settings['wilayah_rw'] ?? '0' }}" class="w-10 bg-transparent border-0 p-0 focus:ring-0 text-emerald-600 font-bold border-b border-dashed border-emerald-300 text-center">
                    </div>
                    <div class="w-[25%]">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded uppercase tracking-wide">Emerald</span>
                    </div>
                    <div class="w-[12.5%] flex items-center justify-between">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_wilayah" value="1" class="sr-only peer" {{ ($settings['show_wilayah'] ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[37.5%] flex items-center gap-3">
                        <div class="text-emerald-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg></div>
                        <span class="font-bold text-slate-700 text-sm">Luas Wilayah</span>
                    </div>
                    <div class="w-[25%] font-bold text-emerald-600 text-sm flex items-center gap-1">
                        <input type="text" name="luas_wilayah" value="{{ $settings['luas_wilayah'] ?? '0' }}" class="w-16 bg-transparent border-0 p-0 focus:ring-0 text-emerald-600 font-bold border-b border-dashed border-emerald-300">
                        <span class="text-emerald-600 text-xs">km&sup2;</span>
                    </div>
                    <div class="w-[25%]">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded uppercase tracking-wide">Emerald</span>
                    </div>
                    <div class="w-[12.5%] flex items-center justify-between">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_luas" value="1" class="sr-only peer" {{ ($settings['show_luas'] ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Demografi Penduduk Warga -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-800">Demografi Penduduk Warga</h3>
                <p class="text-xs text-slate-500">Total penduduk otomatis dihitung dari Laki-laki + Perempuan.</p>
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition text-xs">Simpan Demografi</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex justify-between">
                    Total Populasi Penduduk
                    <span class="text-[9px] bg-slate-100 px-1.5 py-0.5 rounded text-slate-500">OTOMATIS</span>
                </label>
                <input type="text" name="demografi_total" id="calc_total" value="{{ $settings['demografi_total'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 font-bold" readonly>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Laki-laki</label>
                <input type="number" name="demografi_laki" id="calc_laki" value="{{ $settings['demografi_laki'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Perempuan</label>
                <input type="number" name="demografi_perempuan" id="calc_perempuan" value="{{ $settings['demografi_perempuan'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500" required>
            </div>
        </div>
    </div>

    <!-- Kelola Data Kelompok Usia -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-800">Kelola Data Kelompok Usia</h3>
                <p class="text-xs text-slate-500">Klasifikasi usia warga untuk statistik.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-xs text-slate-500 font-medium">Total Terisi: <span id="total_usia" class="text-emerald-600 font-bold">0</span> / <span class="calc_display_total">0</span> Jiwa</div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition text-xs">Simpan</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Balita (0-5 thn)</label>
                <input type="number" name="usia_balita" value="{{ $settings['usia_balita'] ?? '0' }}" class="usia-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Anak-anak (6-12 thn)</label>
                <input type="number" name="usia_anak" value="{{ $settings['usia_anak'] ?? '0' }}" class="usia-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Remaja (13-17 thn)</label>
                <input type="number" name="usia_remaja" value="{{ $settings['usia_remaja'] ?? '0' }}" class="usia-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Usia Produktif (18-59 thn)</label>
                <input type="number" name="usia_produktif" value="{{ $settings['usia_produktif'] ?? '0' }}" class="usia-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Lansia (60+ thn)</label>
                <input type="number" name="usia_lansia" value="{{ $settings['usia_lansia'] ?? '0' }}" class="usia-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>
    </div>

    <!-- Kelola Data Tingkat Pendidikan -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-800">Kelola Data Tingkat Pendidikan</h3>
                <p class="text-xs text-slate-500">Distribusi pendidikan warga.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-xs text-slate-500 font-medium">Total Terisi: <span id="total_pend" class="text-emerald-600 font-bold">0</span> / <span class="calc_display_total">0</span> Jiwa</div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition text-xs">Simpan</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Belum / Tidak Sekolah</label>
                <input type="number" name="pend_belum" value="{{ $settings['pend_belum'] ?? '0' }}" class="pend-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">SD / Sederajat</label>
                <input type="number" name="pend_sd" value="{{ $settings['pend_sd'] ?? '0' }}" class="pend-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">SMP / Sederajat</label>
                <input type="number" name="pend_smp" value="{{ $settings['pend_smp'] ?? '0' }}" class="pend-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">SMA / SMK / Sederajat</label>
                <input type="number" name="pend_sma" value="{{ $settings['pend_sma'] ?? '0' }}" class="pend-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Diploma / Sarjana (D3/S1/S2/S3)</label>
                <input type="number" name="pend_diploma" value="{{ $settings['pend_diploma'] ?? '0' }}" class="pend-input w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>
    </div>

    <!-- Kelola Data Mata Pencaharian / Pekerjaan -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-800">Kelola Data Mata Pencaharian / Pekerjaan</h3>
                <p class="text-xs text-slate-500">Anda dapat mengatur angka profesi warga.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-xs text-slate-500 font-medium">Total Terisi: <span id="total_pek" class="text-emerald-600 font-bold">0</span> / <span class="calc_display_total">0</span> Jiwa</div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition text-xs">Simpan</button>
            </div>
        </div>
        <div class="space-y-4 max-w-3xl">
            @php
                $pekerjaan = [
                    'Wiraswasta / Pedagang' => 'pek_wiraswasta',
                    'Karyawan Swasta' => 'pek_swasta',
                    'ASN / PNS / TNI / Polri' => 'pek_asn',
                    'Buruh Harian' => 'pek_buruh',
                    'Petani / Peternak' => 'pek_petani',
                    'Pelajar / Mahasiswa' => 'pek_pelajar',
                    'Belum Bekerja' => 'pek_belum',
                    'Lainnya' => 'pek_lainnya'
                ];
            @endphp
            @foreach($pekerjaan as $label => $key)
            <div class="flex items-center gap-4">
                <div class="w-2/3">
                    <input type="text" value="{{ $label }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm font-semibold" readonly>
                </div>
                <div class="flex-1">
                    <input type="number" name="{{ $key }}" value="{{ $settings[$key] ?? '0' }}" class="pek-input w-full px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Kelola Distribusi Wilayah (RT & RW) -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-8 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-extrabold text-slate-800">Kelola Distribusi Wilayah (RT & RW)</h3>
                <p class="text-xs text-slate-500">Informasi batas, fasilitas, dan pembagian RW.</p>
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-xl shadow-md transition text-xs">Simpan Wilayah</button>
        </div>
        
        <h4 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Umum Wilayah</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jumlah RW</label>
                <input type="number" name="wilayah_rw" value="{{ $settings['wilayah_rw'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jumlah RT</label>
                <input type="number" name="wilayah_rt" value="{{ $settings['wilayah_rt'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Batas Utara</label>
                <input type="text" name="batas_utara" value="{{ $settings['batas_utara'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Batas Timur</label>
                <input type="text" name="batas_timur" value="{{ $settings['batas_timur'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Batas Selatan</label>
                <input type="text" name="batas_selatan" value="{{ $settings['batas_selatan'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Batas Barat</label>
                <input type="text" name="batas_barat" value="{{ $settings['batas_barat'] ?? '' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>

        <h4 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Fasilitas Umum</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Sekolah</label>
                <input type="number" name="fas_sekolah" value="{{ $settings['fas_sekolah'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Tempat Ibadah</label>
                <input type="number" name="fas_ibadah" value="{{ $settings['fas_ibadah'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Fasilitas Kesehatan</label>
                <input type="number" name="fas_kesehatan" value="{{ $settings['fas_kesehatan'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Pasar / Pertokoan</label>
                <input type="number" name="fas_pasar" value="{{ $settings['fas_pasar'] ?? '0' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500">
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calcLaki = document.getElementById('calc_laki');
    const calcPerempuan = document.getElementById('calc_perempuan');
    const calcTotal = document.getElementById('calc_total');
    const displayTotals = document.querySelectorAll('.calc_display_total');

    function updateTotal() {
        const laki = parseInt(calcLaki.value) || 0;
        const pr = parseInt(calcPerempuan.value) || 0;
        const total = laki + pr;
        calcTotal.value = total;
        
        displayTotals.forEach(el => el.innerText = total.toLocaleString('id-ID'));
        
        const kartus = document.getElementsByName('demografi_total');
        if(kartus.length > 0) kartus[0].value = total.toLocaleString('id-ID');
    }

    calcLaki.addEventListener('input', updateTotal);
    calcPerempuan.addEventListener('input', updateTotal);

    function sumInputs(selector, targetId) {
        const inputs = document.querySelectorAll(selector);
        const target = document.getElementById(targetId);
        function calc() {
            let sum = 0;
            inputs.forEach(i => sum += (parseInt(i.value) || 0));
            target.innerText = sum.toLocaleString('id-ID');
        }
        inputs.forEach(i => i.addEventListener('input', calc));
        calc();
    }

    sumInputs('.usia-input', 'total_usia');
    sumInputs('.pend-input', 'total_pend');
    sumInputs('.pek-input', 'total_pek');
    updateTotal();
});
</script>
@endsection
"""

with open(view_path, 'w', encoding='utf-8') as f:
    f.write(new_index)

print("Updated demographics view successfully!")
