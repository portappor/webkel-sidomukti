@extends('layouts.app')

@section('title', 'Kontak & Lokasi Pelayanan - Kelurahan Sidomukti')

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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Kontak & Lokasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Pusat Informasi & Pelayanan Warga
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Kontak & Lokasi Pelayanan Kantor
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Informasi alamat kantor, nomor kontak darurat, layanan hotline WhatsApp, jam operasional, serta peta navigasi Kantor Kelurahan Sidomukti.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-8">
            
            <!-- Left Column: Informasi Kontak -->
            <div class="lg:col-span-5 bg-white rounded-2xl p-6 sm:p-7 shadow-sm border border-slate-200">
                <div class="flex items-center gap-2.5 pb-4 mb-6 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <h2 class="font-bold text-base text-slate-900">Informasi Kontak Kantor</h2>
                </div>
                
                <div class="space-y-5">
                    <!-- Alamat -->
                    <div class="flex gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs mb-0.5">Alamat Kantor:</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $settings['alamat'] ?? 'Jl. Raya Sidomukti No. 10, Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo, Jawa Timur 67282' }}</p>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="flex gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs mb-0.5">Telepon / WhatsApp CS:</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                {{ $settings['telepon'] ?? '(0335) 123456' }}
                                @if(!empty($settings['whatsapp'] ?? $settings['wa_number'] ?? $settings['telepon_wa']))
                                    <span class="text-slate-400">/</span> WA: {{ $settings['whatsapp'] ?? $settings['wa_number'] ?? $settings['telepon_wa'] }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs mb-0.5">Email Resmi:</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $settings['email'] ?? 'info@sidomukti.desa.id' }}</p>
                        </div>
                    </div>

                    <!-- Jam Operasional -->
                    <div class="flex gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-xs mb-0.5">Jam Operasional Pelayanan:</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                @php
                                    $jamSeninKamis = $settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB';
                                    $jamJumat = $settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB';
                                @endphp
                                @if($jamSeninKamis === $jamJumat)
                                    Senin - Jumat: {{ $jamSeninKamis }}
                                @else
                                    Senin - Kamis: {{ $jamSeninKamis }}<br>
                                    Jumat: {{ $jamJumat }}
                                @endif
                                <br><span class="text-amber-600 font-semibold">Sabtu, Minggu & Hari Libur Nasional: Tutup</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? $settings['wa_number'] ?? $settings['telepon_wa'] ?? '6281234567890') }}" target="_blank" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981z"/></svg>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Right Column: Peta Lokasi -->
            <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-7 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                    <h2 class="font-bold text-base text-slate-900">Peta Lokasi Kantor Kelurahan</h2>
                    <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">Kraksaan, Probolinggo</span>
                </div>
                
                <div class="w-full h-80 rounded-xl overflow-hidden border border-slate-200 relative bg-slate-100">
                    <iframe 
                        src="{{ $settings['gmaps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15814.159392817812!2d113.407!3d-7.755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd701a5d24d2ab7%3A0x7d0186c478a87ab5!2sSidomukti%2C%20Kraksaan%2C%20Probolinggo%20Regency%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}" 
                        class="w-full h-full border-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="mt-3 flex justify-between items-center text-xs text-slate-500">
                    <span>Koordinat: Wilayah Sentral Kraksaan</span>
                    <a href="{{ $settings['gmaps_link'] ?? 'https://maps.google.com/?q=Kelurahan+Sidomukti+Kraksaan' }}" target="_blank" class="text-emerald-600 font-bold hover:underline">
                        Buka di Google Maps &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
