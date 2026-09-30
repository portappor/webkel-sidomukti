@extends('layouts.admin')

@section('title', 'Kelola SP4N-LAPOR! & Pengaduan Warga')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola SP4N-LAPOR! & Pengaduan Warga</h2>
        <p class="text-slate-500 text-sm">Kelola konfigurasi layanan aduan SP4N-LAPOR! serta petunjuk alur layanan pengaduan masyarakat Kelurahan Sidomukti.</p>
    </div>
    <div>
        <a href="https://www.lapor.go.id/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Portal Resmi SP4N-LAPOR!
        </a>
    </div>
</div>



<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Left Column: Form Konfigurasi SP4N-LAPOR! -->
    <div class="lg:col-span-7 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Pengaturan Kelola Portal SP4N-LAPOR!</h3>
                        <p class="text-slate-500 text-xs">Konfigurasi tautan dan petunjuk pengaduan resmi nasional Kemendagri / Pemkab.</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('dashboard.settings.update') }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tautan / Link Portal SP4N-LAPOR!</label>
                        <input type="url" name="lapor_link" value="{{ $settings['lapor_link'] ?? 'https://www.lapor.go.id/' }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-mono text-slate-800" placeholder="https://www.lapor.go.id/">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kode / Nama Instansi Pengaduan</label>
                        <input type="text" name="lapor_instansi" value="{{ $settings['lapor_instansi'] ?? 'Pemerintah Kabupaten Probolinggo - Kelurahan Sidomukti' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-medium text-slate-800" placeholder="Contoh: Pemkab Probolinggo">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Petunjuk & Panduan Alur Layanan Pengaduan Warga</label>
                    <textarea name="lapor_guide" rows="3" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-medium text-slate-800">{{ $settings['lapor_guide'] ?? 'Masyarakat Kelurahan Sidomukti dapat menyampaikan aspirasi, pengaduan pelayanan publik, dan laporan infrastruktur melalui kanal resmi SP4N-LAPOR! atau formulir pengaduan langsung kantor kelurahan.' }}</textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">Simpan Konfigurasi SP4N-LAPOR!</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Interactive Preview Widget -->
    <div class="lg:col-span-5 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h4 class="font-bold text-slate-800 text-sm mb-2 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Preview Visual Live Banner SP4N-LAPOR!
            </h4>
            <p class="text-xs text-slate-500 mb-4">Simulasi bagaimana warga melihat banner kelola layanan pengaduan pada portal publik.</p>

            <!-- Card Simulation -->
            <div class="bg-slate-900 text-white rounded-2xl p-5 shadow-xl space-y-4">
                <div class="flex items-center gap-3 border-b border-slate-800 pb-3">
                    <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center font-bold text-white shadow-md shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    </div>
                    <div>
                        <h5 class="font-bold text-sm text-white">Portal SP4N-LAPOR!</h5>
                        <p class="text-[11px] text-red-400 font-medium">● Layanan Pengaduan Resmi</p>
                    </div>
                </div>

                <div class="bg-slate-800/80 rounded-xl p-3 text-xs text-slate-300 leading-relaxed border border-slate-700 space-y-2">
                    <div class="font-bold text-white text-xs">{{ $settings['lapor_instansi'] ?? 'Pemerintah Kabupaten Probolinggo - Kelurahan Sidomukti' }}</div>
                    <p class="italic text-[11px] text-slate-400">"{{ $settings['lapor_guide'] ?? 'Masyarakat Kelurahan Sidomukti dapat menyampaikan aspirasi, pengaduan pelayanan publik, dan laporan infrastruktur melalui kanal resmi SP4N-LAPOR!...' }}"</p>
                </div>

                <div class="pt-2">
                    <a href="{{ $settings['lapor_link'] ?? 'https://www.lapor.go.id/' }}" target="_blank" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-lg flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Kirim Pengaduan Ke SP4N-LAPOR!
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
