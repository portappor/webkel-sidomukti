@extends('layouts.app')

@section('title', $service->title . ' - Standar Pelayanan & SOP Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

    <!-- Page Header (Deep Dark Theme matching portal standard) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
        <!-- Subtle Glow -->
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-10 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400 mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1.5 md:space-x-2 flex-wrap">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-emerald-400 transition font-medium">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('services.index') }}" class="ml-1.5 hover:text-emerald-400 transition font-medium">Standar Pelayanan & SOP</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold truncate max-w-[200px] sm:max-w-xs md:max-w-md">{{ $service->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Title & Meta Header Block -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        {{ $service->kategoriLayanan->nama_kategori ?? 'Standar Operasional Prosedur (SOP)' }}
                    </div>
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                        {{ $service->title }}
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                        {{ $service->description ?? 'Dokumen pedoman resmi mengenai alur, persyaratan, dan standar waktu penyelesaian pelayanan di Kelurahan Sidomukti.' }}
                    </p>

                    <!-- Meta Tags Row -->
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 mt-4 text-[11px] text-slate-400">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Pembaruan: {{ $service->updated_at ? $service->updated_at->isoFormat('D MMMM Y') : 'Terbaru' }}
                        </span>
                        <span class="text-slate-700">•</span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Format PDF Resmi
                        </span>
                        <span class="text-slate-700">•</span>
                        <span class="inline-flex items-center gap-1 text-emerald-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Berlaku Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8">

        

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            <!-- Left Column: PDF Viewer Container (8 cols) -->
            <div class="lg:col-span-8 space-y-4">

                <!-- Main Viewer Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-7 flex flex-col gap-6">

                    <!-- Header Judul SOP & Deskripsi -->
                    <div class="flex items-start gap-3.5">
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2.5 py-1 rounded-md uppercase tracking-wide shrink-0">
                            PDF
                        </span>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-800 leading-tight">
                                {{ $service->title }}
                            </h2>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                {{ $service->description ?? 'Surat keterangan untuk keperluan legalitas warga Kelurahan Sidomukti.' }}
                            </p>
                        </div>
                    </div>

                    <!-- 1. Persyaratan Dokumen -->
                    @php
                        $rawReqs = $service->requirements ?? 'Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW';
                        if (str_contains($rawReqs, "\n")) {
                            $reqItems = array_map('trim', explode("\n", $rawReqs));
                        } else {
                            $reqItems = array_map('trim', preg_split('/[,;]+/', $rawReqs));
                        }
                        $reqItems = array_values(array_filter($reqItems, fn($i) => !empty($i)));
                    @endphp

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center">
                                    1
                                </span>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Persyaratan Dokumen
                                </span>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/60 flex items-center gap-1">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ count($reqItems) }} Berkas Wajib
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($reqItems as $req)
                                <div class="bg-white border border-slate-200/90 hover:border-emerald-300 rounded-xl p-3.5 shadow-2xs hover:shadow-xs transition duration-150 flex items-start gap-3 group">
                                    <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-700 leading-snug group-hover:text-slate-900 transition-colors">
                                        {{ $req }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 2. Ketentuan Pelayanan -->
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center">
                                2
                            </span>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-600">
                                Ketentuan Pelayanan
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Jam Operasional -->
                            <div class="bg-slate-50/80 border border-slate-200/80 rounded-xl p-4">
                                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide block">
                                    Jam Operasional
                                </span>
                                <span class="text-sm font-bold text-slate-800 mt-0.5 block">
                                    {{ $service->operating_hours ?? 'Senin - Jumat (07.30 - 15.30 WIB)' }}
                                </span>
                                <span class="text-[11px] text-slate-500">
                                    Jam Kerja
                                </span>
                            </div>

                            <!-- Estimasi Waktu -->
                            <div class="bg-slate-50/80 border border-slate-200/80 rounded-xl p-4">
                                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide block">
                                    Estimasi Waktu
                                </span>
                                <span class="text-sm font-bold text-slate-800 mt-0.5 block">
                                    {{ $service->processing_time ?? '1 Hari Kerja (1x24 Jam)' }}
                                </span>
                                <span class="text-[11px] text-slate-500">
                                    Hari Kerja
                                </span>
                            </div>

                            <!-- Biaya Pelayanan -->
                            <div class="bg-emerald-50/60 border border-emerald-200/70 rounded-xl p-4 sm:col-span-2">
                                <span class="text-[11px] font-semibold text-emerald-700 uppercase tracking-wide block">
                                    Biaya Pelayanan
                                </span>
                                <span class="text-sm font-bold text-emerald-700 mt-0.5 block">
                                    {{ $service->cost ?? 'GRATIS' }}
                                </span>
                                <span class="text-[11px] text-emerald-600">
                                    Bebas Pungutan
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Baca Dokumen SOP (PDF) -->
                    <div class="pt-2">
                        @if($service->file_path && Storage::disk('public')->exists($service->file_path))
                            <a href="{{ Storage::url($service->file_path) }}" target="_blank" class="inline-flex items-center justify-center px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
                                Baca Dokumen SOP (PDF)
                            </a>
                        @else
                            <button type="button" disabled class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-200 text-slate-400 text-xs font-semibold rounded-xl cursor-not-allowed">
                                Dokumen PDF Belum Tersedia
                            </button>
                        @endif
                    </div>

                </div>

                <!-- Info Box: Maklumat Bebas Biaya & Ketentuan Layanan -->
                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-start gap-3.5">
                    <div class="p-2 rounded-xl bg-emerald-50 text-emerald-600 shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-xs sm:text-sm mb-1">Maklumat Pelayanan Bebas Biaya (GRATIS)</h4>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Seluruh pengurusan surat keterangan dan administrasi kependudukan di Kelurahan Sidomukti <strong>tidak dipungut biaya apapun (GRATIS)</strong>. Pastikan Anda membawa berkas persyaratan lengkap saat datang ke kantor kelurahan.
                        </p>
                    </div>
                </div>

            </div>

            <!-- Right Column: Navigation Sidebar (4 cols - Standardized Template) -->
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

                <!-- Search Box Widget (Standardized Portal Design) -->
                <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200">
                    <form action="{{ route('services.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="q" placeholder="Cari SOP / Layanan..." value="{{ request('q') }}" class="w-full px-4 py-2.5 text-xs sm:text-sm border border-slate-200 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-700 bg-slate-50/50 placeholder-slate-400 transition">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-r-xl transition-colors flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Sidebar Widget: Daftar SOP -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Daftar Standar Pelayanan & SOP</h3>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                            {{ $allServices->count() }} Dokumen
                        </span>
                    </div>

                    <div class="space-y-1.5 max-h-[480px] overflow-y-auto pr-1">
                        @foreach($allServices as $item)
                            @php
                                $isActive = ($item->slug === $service->slug);
                            @endphp
                            <a href="{{ route('services.show', $item->slug) }}"
                               class="group flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs transition duration-150 {{ $isActive ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'hover:bg-slate-50 text-slate-700 font-medium' }}">
                                <span class="w-5 h-5 rounded-md flex items-center justify-center shrink-0 text-[10px] font-bold {{ $isActive ? 'bg-emerald-700/80 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-700' }}">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="leading-tight line-clamp-2 {{ $isActive ? 'text-white' : 'text-slate-700 group-hover:text-slate-900' }}">
                                    {{ $item->title }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Sidebar Widget: Kategori Layanan -->
                @if(isset($categories) && $categories->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3.5 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Kategori Layanan</h3>
                        </div>
                    </div>
                    <div class="space-y-1">
                        @foreach($categories as $cat)
                            <a href="{{ route('services.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition">
                                <span>{{ $cat->nama_kategori }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    {{ $cat->services_count ?? $cat->services->count() }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Sidebar Widget: Hotline Bantuan -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6">
                    <div class="flex items-center gap-2.5 mb-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-xs sm:text-sm">Bantuan & Informasi</h4>
                    </div>
                    <p class="text-[11.5px] text-slate-500 leading-relaxed mb-4">
                        Butuh bantuan mengenai persyaratan atau alur pelayanan administrasi kelurahan? Silakan hubungi kami via WhatsApp.
                    </p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['wa_number'] ?? '6281234567890') }}" target="_blank" class="w-full py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs rounded-xl transition flex items-center justify-center gap-2 border border-emerald-200/60 shadow-2xs">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981z"/></svg>
                        Hubungi WhatsApp Kelurahan
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection
