@extends('layouts.admin')

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

    <!-- Kartu Statistik Beranda & Ringkasan Demografi -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 flex flex-col md:flex-row">
        <div class="md:w-1/3 bg-slate-50/50 p-6 md:p-8 border-b md:border-b-0 md:border-r border-slate-100 flex flex-col justify-center">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <h3 class="text-xl font-extrabold text-slate-800 mb-2 leading-tight">Ringkasan<br>Statistik Warga</h3>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">Kelola 4 indikator utama: Jumlah Penduduk, KK, Laki-Laki, dan Perempuan. Terintegrasi langsung dengan kartu beranda dan menu Statistik & Monografi.</p>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Simpan Data
            </button>
        </div>
        <div class="md:w-2/3 p-6 md:p-8">
            <div class="grid grid-cols-[1.5fr_1fr_1fr] gap-4 mb-4 text-xs font-bold text-slate-400 uppercase tracking-wider px-4">
                <div>Ikon & Indikator</div>
                <div>Nilai (Jiwa / KK)</div>
                <div>Keterangan</div>
            </div>
            
            <div class="space-y-3">
                <!-- Item 1: Jumlah Penduduk -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[45%] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 text-sm block">Jumlah Penduduk</span>
                            <span class="text-[10px] text-slate-400">Total Populasi</span>
                        </div>
                    </div>
                    <div class="w-[30%]">
                        <input type="number" name="demografi_total" id="calc_total" value="{{ $settings['demografi_total'] ?? ($settings['jumlah_penduduk'] ?? '0') }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 bg-slate-50 text-emerald-700 font-extrabold" readonly>
                    </div>
                    <div class="w-[25%] flex items-center">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-lg uppercase tracking-wide">Otomatis (L+P)</span>
                    </div>
                </div>

                <!-- Item 2: Kepala Keluarga -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[45%] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 text-sm block">Kepala Keluarga (KK)</span>
                            <span class="text-[10px] text-slate-400">Jumlah KK</span>
                        </div>
                    </div>
                    <div class="w-[30%]">
                        <input type="number" name="demografi_kk" value="{{ $settings['demografi_kk'] ?? '0' }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:ring-2 focus:ring-blue-500 font-bold text-slate-800" required>
                    </div>
                    <div class="w-[25%] flex items-center">
                        <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-lg uppercase tracking-wide">Tampil Beranda</span>
                    </div>
                </div>

                <!-- Item 3: Laki-Laki -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[45%] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 text-sm block">Laki-Laki</span>
                            <span class="text-[10px] text-slate-400">Jenis Kelamin Laki-Laki</span>
                        </div>
                    </div>
                    <div class="w-[30%]">
                        <input type="number" name="demografi_laki" id="calc_laki" value="{{ $settings['demografi_laki'] ?? '0' }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500 font-bold text-slate-800" required>
                    </div>
                    <div class="w-[25%] flex items-center">
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-lg uppercase tracking-wide">Tampil Beranda</span>
                    </div>
                </div>

                <!-- Item 4: Perempuan -->
                <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white">
                    <div class="w-[45%] flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 text-sm block">Perempuan</span>
                            <span class="text-[10px] text-slate-400">Jenis Kelamin Perempuan</span>
                        </div>
                    </div>
                    <div class="w-[30%]">
                        <input type="number" name="demografi_perempuan" id="calc_perempuan" value="{{ $settings['demografi_perempuan'] ?? '0' }}" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-200 focus:ring-2 focus:ring-pink-500 font-bold text-slate-800" required>
                    </div>
                    <div class="w-[25%] flex items-center">
                        <span class="px-2.5 py-1 bg-pink-50 text-pink-700 text-[10px] font-bold rounded-lg uppercase tracking-wide">Tampil Beranda</span>
                    </div>
                </div>

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
