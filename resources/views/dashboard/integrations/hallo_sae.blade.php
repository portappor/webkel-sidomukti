@extends('layouts.admin')

@section('title', 'Kelola Layanan Hallo SAE (WhatsApp Hotline)')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Layanan Hallo SAE (WhatsApp Hotline)</h2>
        <p class="text-slate-500 text-sm">Pengaturan nomor WhatsApp resmi, template salam pembuka, dan tombol menu layanan publik instan.</p>
    </div>
    <div>
        @php
            $waVal = $settings['wa_number'] ?? '6282131001001';
            $waUrl = "https://wa.me/{$waVal}?text=" . urlencode($settings['wa_welcome_text'] ?? 'Halo Admin Kelurahan Sidomukti, saya ingin berkonsultasi mengenai pelayanan administrasi.');
        @endphp
        <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            Uji Coba Kirim WA
        </a>
    </div>
</div>



<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    <!-- Left Column: Form Pengaturan WA -->
    <div class="lg:col-span-7 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Pengaturan Kontak & Jam Layanan WhatsApp</h3>
                        <p class="text-slate-500 text-xs">Nomor utama hotline, nama operator customer service, dan jadwal pelayanan.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('dashboard.settings.update') }}" method="POST" class="p-6 md:p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor WhatsApp Hotline (Format Internasional Tanpa + / Spasi)</label>
                    <input type="text" name="wa_number" value="{{ $settings['wa_number'] ?? '6282131001001' }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs font-mono font-bold text-slate-800" placeholder="Contoh: 6282131001001">
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan kode negara (62 untuk Indonesia). Contoh: 6282131001001.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Customer Service / Operator</label>
                        <input type="text" name="wa_operator_name" value="{{ $settings['wa_operator_name'] ?? 'Petugas Hallo SAE Sidomukti' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: Admin Pelayanan Kelurahan">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jam Layanan WhatsApp</label>
                        <input type="text" name="wa_hours" value="{{ $settings['wa_hours'] ?? 'Senin - Jumat (08:00 - 15:00 WIB)' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: Senin - Jumat (08.00 - 15.00 WIB)">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Template Pesan Otomatis (Salam Pembuka)</label>
                    <textarea name="wa_welcome_text" rows="3" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800">{{ $settings['wa_welcome_text'] ?? 'Halo Admin Hallo SAE Kelurahan Sidomukti, saya warga Sidomukti ingin berkonsultasi mengenai pengurusan surat...' }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Pesan ini otomatis terisi di aplikasi WhatsApp warga ketika menekan tombol hotline.</p>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">Simpan Pengaturan WhatsApp</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Interactive Preview Widget -->
    <div class="lg:col-span-5 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h4 class="font-bold text-slate-800 text-sm mb-2 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Preview Visual Live Floating Widget WhatsApp
            </h4>
            <p class="text-xs text-slate-500 mb-4">Simulasi bagaimana warga melihat tombol layanan Hallo SAE pada portal publik.</p>

            <!-- Card Simulation -->
            <div class="bg-slate-900 text-white rounded-2xl p-5 shadow-xl space-y-4">
                <div class="flex items-center gap-3 border-b border-slate-800 pb-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center font-bold text-white shadow-md">
                        WA
                    </div>
                    <div>
                        <h5 class="font-bold text-sm text-white">{{ $settings['wa_operator_name'] ?? 'Hallo SAE Sidomukti' }}</h5>
                        <p class="text-[11px] text-emerald-400 font-medium">● Online — {{ $settings['wa_hours'] ?? 'Senin - Jumat' }}</p>
                    </div>
                </div>

                <div class="bg-slate-800/80 rounded-xl p-3 text-xs text-slate-300 leading-relaxed border border-slate-700">
                    "{{ $settings['wa_welcome_text'] ?? 'Halo Admin Hallo SAE Kelurahan Sidomukti...' }}"
                </div>

                <div class="pt-2">
                    <a href="https://wa.me/{{ $settings['wa_number'] ?? '6282131001001' }}" target="_blank" class="w-full py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-lg flex items-center justify-center gap-2 transition">
                        Buka Obrolan WhatsApp Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
