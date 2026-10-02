@extends('layouts.app')

@section('content')

<!-- Hero Banner -->
@php
    $heroMode = $settings['hero_banner_mode'] ?? 'slider';
    $rawSlides = isset($settings['hero_slides']) ? json_decode($settings['hero_slides'], true) : [];

    if (empty($rawSlides) || !is_array($rawSlides)) {
        $rawSlides = [
            [
                'tag' => $settings['hero_tag'] ?? 'Program Unggulan Kelurahan',
                'title_1' => $settings['hero_title_1'] ?? 'Pelayanan Publik',
                'title_2' => $settings['hero_title_2'] ?? 'Berbasis Digital Cepat & Transparan',
                'subtitle' => $settings['hero_subtitle'] ?? 'Kini administrasi kependudukan lebih cepat dan transparan melalui integrasi digital.',
                'background' => $settings['hero_background'] ?? '',
            ]
        ];
    }

    $slides = [];
    foreach ($rawSlides as $s) {
        $bgVal = $s['background'] ?? '';
        $bgSrc = !empty($bgVal)
            ? (\Illuminate\Support\Str::startsWith($bgVal, ['http://', 'https://']) ? $bgVal : Storage::url($bgVal))
            : asset('hero-bg.jpg');

        $slides[] = [
            'tag' => $s['tag'] ?? 'Program Unggulan Kelurahan',
            'title_1' => $s['title_1'] ?? 'Pelayanan Publik',
            'title_2' => $s['title_2'] ?? 'Berbasis Digital Cepat & Transparan',
            'subtitle' => $s['subtitle'] ?? '',
            'bg' => $bgSrc,
        ];
    }

    $isSlider = ($heroMode === 'slider' && count($slides) > 1);
@endphp

@if($isSlider)
<!-- Hero Banner Carousel Mode (Multi Slide Auto-play) -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4 md:mt-6 mb-6">
<section class="relative bg-slate-950 h-[520px] md:h-[600px] w-full overflow-hidden rounded-2xl shadow-2xl"
         x-data="{
             activeSlide: 0,
             totalSlides: {{ count($slides) }},
             timer: null,
             init() {
                 this.startAutoPlay();
             },
             startAutoPlay() {
                 this.stopAutoPlay();
                 this.timer = setInterval(() => {
                     this.next();
                 }, 6000);
             },
             stopAutoPlay() {
                 if (this.timer) clearInterval(this.timer);
             },
             next() {
                 this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
             },
             prev() {
                 this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
             },
             goTo(index) {
                 this.activeSlide = index;
             }
         }"
         @mouseenter="stopAutoPlay()"
         @mouseleave="startAutoPlay()">

    @foreach($slides as $index => $slide)
    <div x-show="activeSlide === {{ $index }}"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-105"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute inset-0 w-full h-full"
         x-cloak>

        <!-- Background Image -->
        <img src="{{ $slide['bg'] }}" class="absolute inset-0 w-full h-full object-cover object-center opacity-100 transition-all duration-700" alt="{{ strip_tags($slide['title_1']) }}">

        <!-- Smooth Soft Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/60 via-slate-950/20 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-slate-950/10"></div>

        <div class="container mx-auto px-4 h-full relative z-10 flex items-center">
            <div class="w-full md:w-2/3 lg:w-1/2 text-white">
                @if(!empty($slide['tag']))
                <div class="hero-animate hero-animate-delay-1 inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-green-600 to-[#00A859] text-white text-[11px] font-bold tracking-widest uppercase shadow-lg shadow-green-500/20 mb-6 border-l-4 border-yellow-400 rounded-r-full">
                    {{ $slide['tag'] }}
                </div>
                @endif

                <h2 class="hero-animate hero-animate-delay-2 text-4xl md:text-5xl lg:text-[56px] font-extrabold leading-[1.1] mb-5 text-white tracking-tight">
                    {!! $slide['title_1'] !!}
                    @if(!empty($slide['title_2']))
                    <span class="block text-[#00A859] mt-1">{!! $slide['title_2'] !!}</span>
                    @endif
                </h2>

                <div class="hero-animate hero-animate-delay-3 w-20 h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-500 mb-8 rounded-full shadow-[0_0_10px_rgba(250,204,21,0.4)]"></div>

                @if(!empty($slide['subtitle']))
                <p class="hero-animate hero-animate-delay-3 text-base md:text-lg text-slate-300 mb-8 font-normal leading-relaxed max-w-lg">
                    {{ $slide['subtitle'] }}
                </p>
                @endif
            </div>
        </div>
    </div>
    @endforeach


    <!-- Pagination Dots -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 px-4 py-2 bg-slate-950/40 backdrop-blur-md rounded-full border border-white/10">
        @foreach($slides as $index => $slide)
        <button @click="goTo({{ $index }}); startAutoPlay();"
                aria-label="Ke Slide {{ $index + 1 }}"
                :class="activeSlide === {{ $index }} ? 'w-8 bg-emerald-500' : 'w-2.5 bg-white/50 hover:bg-white'"
                class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
        @endforeach
    </div>

</section>
</div>
@else
<!-- Hero Banner Mode Statis (Single Slide) -->
@php $staticSlide = $slides[0] ?? [
    'tag' => 'Program Unggulan Kelurahan',
    'title_1' => 'Pelayanan Publik',
    'title_2' => 'Berbasis Digital Cepat & Transparan',
    'subtitle' => 'Kini administrasi kependudukan lebih cepat dan transparan melalui integrasi digital.',
    'bg' => asset('hero-bg.jpg')
]; @endphp
<div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4 md:mt-6 mb-6">
<section class="relative bg-slate-950 h-[520px] md:h-[600px] w-full overflow-hidden rounded-2xl shadow-2xl">
    <!-- Background Image -->
    <img src="{{ $staticSlide['bg'] }}" class="absolute inset-0 w-full h-full object-cover object-center opacity-100 transition-opacity duration-500" alt="Pelayanan Publik Digital Kelurahan Sidomukti">

    <!-- Smooth Soft Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/60 via-slate-950/20 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-slate-950/10"></div>

    <div class="container mx-auto px-4 h-full relative z-10 flex items-center">
        <div class="w-full md:w-2/3 lg:w-1/2 text-white">
            @if(!empty($staticSlide['tag']))
            <div class="hero-animate hero-animate-delay-1 inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-green-600 to-[#00A859] text-white text-[11px] font-bold tracking-widest uppercase shadow-lg shadow-green-500/20 mb-6 border-l-4 border-yellow-400 rounded-r-full">
                {{ $staticSlide['tag'] }}
            </div>
            @endif

            <h2 class="hero-animate hero-animate-delay-2 text-4xl md:text-5xl lg:text-[56px] font-extrabold leading-[1.1] mb-5 text-white tracking-tight">
                {!! $staticSlide['title_1'] !!}
                @if(!empty($staticSlide['title_2']))
                <span class="block text-[#00A859] mt-1">{!! $staticSlide['title_2'] !!}</span>
                @endif
            </h2>

            <div class="hero-animate hero-animate-delay-3 w-20 h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-500 mb-8 rounded-full shadow-[0_0_10px_rgba(250,204,21,0.4)]"></div>

            @if(!empty($staticSlide['subtitle']))
            <p class="hero-animate hero-animate-delay-3 text-base md:text-lg text-slate-300 mb-8 font-normal leading-relaxed max-w-lg">
                {{ $staticSlide['subtitle'] }}
            </p>
            @endif
        </div>
    </div>
</section>
</div>
@endif

<!-- Sambutan Pimpinan / Lurah -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <div class="w-full lg:w-1/3 flex justify-center reveal fade-right">
                <div class="relative w-64">
                    @php
                        $kadinVal = $settings['kadin_photo'] ?? $settings['foto_lurah'] ?? null;
                        $kadinPhoto = !empty($kadinVal)
                            ? (\Illuminate\Support\Str::startsWith($kadinVal, ['http://', 'https://']) ? $kadinVal : Storage::url($kadinVal))
                            : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $kadinPhoto }}"
                         alt="Pimpinan Kelurahan" class="w-full h-80 object-cover rounded-2xl shadow-lg border border-slate-100">
                    <div class="absolute -bottom-4 inset-x-4 bg-white border border-slate-100 py-3 px-4 rounded-xl shadow-sm text-center">
                        <h4 class="font-bold text-sm text-slate-800">{{ $settings['kadin_name'] ?? $settings['nama_lurah'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}</h4>
                        <p class="text-[10px] text-green-600 font-semibold uppercase mt-0.5">{{ $settings['kadin_title'] ?? 'LURAH SIDOMUKTI' }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3 space-y-5 text-center lg:text-left reveal fade-left">
                <div class="inline-flex items-center gap-2 text-green-600 text-xs font-bold uppercase tracking-widest">
                    {{ $settings['sambutan_subtitle'] ?? ('Sambutan ' . ($settings['jabatan_lurah'] ?? $settings['kadin_title'] ?? 'LURAH SIDOMUKTI')) }}
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                    {{ $settings['sambutan_title'] ?? 'Melayani Warga Sepenuh Hati Menuju Kelurahan yang Maju, Sejahtera & Mandiri' }}
                </h2>
                <div class="text-slate-600 text-sm leading-relaxed max-w-3xl space-y-3 prose prose-slate">
                    @if(!empty($settings['sambutan_isi']))
                        {!! $settings['sambutan_isi'] !!}
                    @else
                        <p>Selamat Datang di Portal Resmi <strong>{{ $settings['agency_name'] ?? 'KELURAHAN SIDOMUKTI' }} {{ $settings['regency_name'] ?? 'Kecamatan Kraksaan, Kabupaten Probolinggo' }}</strong>. Kami berkomitmen menyajikan pelayanan publik prima, kemudahan administrasi kependudukan dan pengurusan surat keterangan, transparansi kinerja kelurahan, serta pemberdayaan potensi ekonomi warga lokal.</p>
                    @endif
                </div>
                <div class="pt-4 flex flex-wrap gap-4 items-center justify-center lg:justify-start">
                    <a href="{{ route('profil.visi-misi') }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                        Visi & Misi Kami <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($featuredProfileMenus) && $featuredProfileMenus->count() > 0)
<!-- Sekilas Profil & Informasi Kelurahan (Dinamis dari Navigation Menu) -->
<section id="profil-unggulan" class="py-16 bg-slate-50 border-b border-slate-100 relative z-10">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10 reveal fade-up">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-50 text-emerald-700 text-[11px] font-extrabold tracking-widest uppercase rounded-full mb-4 border border-emerald-200/60 shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M9 8h.01M15 16h.01M15 12h.01M15 8h.01"></path></svg>
                Informasi & Profil Utama
            </span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#111827]">Sekilas Profil Kelurahan Sidomukti</h2>
            <p class="text-slate-500 mt-3 font-medium max-w-xl mx-auto">Mengenal lebih dekat visi misi, struktur organisasi, dan sejarah pelayanan publik Kelurahan Sidomukti.</p>
            <div class="w-20 h-[3px] bg-[#008c5f] mx-auto mt-4"></div>
        </div>

        <style>
            .hide-scrollbar::-webkit-scrollbar { display: none; }
            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
        <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory hide-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
            @foreach($featuredProfileMenus as $index => $item)
                @php
                    $itemUrl = $item->url ?: '#';
                    $itemTitle = $item->title;
                    $itemDesc = $item->description;

                    if (empty($itemDesc)) {
                        $lowerTitle = strtolower($itemTitle);
                        if (str_contains($lowerTitle, 'visi')) {
                            $itemDesc = 'Komitmen, arah kebijakan strategis, dan sasaran prioritas pembangunan Kelurahan Sidomukti.';
                        } elseif (str_contains($lowerTitle, 'struktur') || str_contains($lowerTitle, 'aparatur')) {
                            $itemDesc = 'Bagan tata kerja susunan organisasi dan aparatur pemerintahan Kelurahan Sidomukti.';
                        } elseif (str_contains($lowerTitle, 'sejarah')) {
                            $itemDesc = 'Naskah histori, sejarah berdiri, rekam jejak kepemimpinan, dan perkembangan wilayah.';
                        } else {
                            $itemDesc = 'Informasi resmi mengenai profil, pelayanan, serta program kerja Kelurahan Sidomukti.';
                        }
                    }

                    $lowerT = strtolower($itemTitle);
                    $iconClass = 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M9 16h.01M9 12h.01M9 8h.01M15 16h.01M15 12h.01M15 8h.01';
                    $bgColor = 'bg-emerald-50 text-emerald-600 border-emerald-200/80 hover:border-emerald-400';
                    $btnColor = 'bg-slate-50 border-emerald-500/30 text-emerald-700 hover:bg-emerald-600 hover:text-white';

                    if (str_contains($lowerT, 'visi')) {
                        $iconClass = 'M13 10V3L4 14h7v7l9-11h-7z';
                        $bgColor = 'bg-emerald-50 text-emerald-600 border-emerald-200/80 hover:border-emerald-400';
                    } elseif (str_contains($lowerT, 'struktur')) {
                        $iconClass = 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10';
                        $bgColor = 'bg-blue-50 text-blue-600 border-blue-200/80 hover:border-blue-400';
                        $btnColor = 'bg-slate-50 border-blue-500/30 text-blue-700 hover:bg-blue-600 hover:text-white';
                    } elseif (str_contains($lowerT, 'sejarah')) {
                        $iconClass = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                        $bgColor = 'bg-purple-50 text-purple-600 border-purple-200/80 hover:border-purple-400';
                        $btnColor = 'bg-slate-50 border-purple-500/30 text-purple-700 hover:bg-purple-600 hover:text-white';
                    } elseif (str_contains($lowerT, 'prestasi') || str_contains($lowerT, 'penghargaan')) {
                        $iconClass = 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z';
                        $bgColor = 'bg-amber-50 text-amber-600 border-amber-200/80 hover:border-amber-400';
                        $btnColor = 'bg-slate-50 border-amber-500/30 text-amber-700 hover:bg-amber-600 hover:text-white';
                    }
                @endphp

                <div class="reveal fade-up flex-none w-[85%] sm:w-[320px] lg:w-[350px] snap-center h-auto" data-delay="{{ $index * 100 }}">
                    <div class="bg-white border-2 border-slate-100 hover:shadow-xl rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-2 group h-full">
                        <div>
                            <div class="w-12 h-12 rounded-2xl {{ $bgColor }} border shadow-xs flex items-center justify-center transition-all duration-300 mb-5 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconClass }}"></path></svg>
                            </div>

                            <h3 class="font-extrabold text-lg text-slate-800 mb-2.5 group-hover:text-emerald-700 transition line-clamp-1">{{ $itemTitle }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-6 font-medium">{{ $itemDesc }}</p>
                        </div>

                        <a href="{{ $itemUrl }}" target="{{ $item->target }}" class="w-full py-2.5 px-4 border-2 rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2 group-hover:shadow-md {{ $btnColor }}">
                            <span>Selengkapnya</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Floating Stats Bar -->
<section class="relative z-20 py-12 bg-slate-50 border-t border-slate-100">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden flex flex-col items-center">
            <div class="w-full grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-6 md:gap-0 p-3 sm:p-6 md:p-0 md:divide-x divide-slate-100">
                <div class="p-2 md:p-6 text-center group reveal fade-up" data-delay="0">
                    <div class="inline-flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-green-50 text-green-600 mb-1 sm:mb-3 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-base sm:text-2xl md:text-3xl font-extrabold text-slate-800" data-count-to="{{ $settings['demografi_total'] ?? ($settings['jumlah_penduduk'] ?? '2776') }}" data-count-suffix="">0</div>
                    <p class="text-[8px] sm:text-xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5 sm:mt-1">Jumlah Penduduk</p>
                </div>
                <div class="p-2 md:p-6 text-center group reveal fade-up" data-delay="100">
                    <div class="inline-flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-blue-50 text-blue-600 mb-1 sm:mb-3 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div class="text-base sm:text-2xl md:text-3xl font-extrabold text-slate-800" data-count-to="{{ $settings['demografi_kk'] ?? '850' }}" data-count-suffix="">0</div>
                    <p class="text-[8px] sm:text-xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5 sm:mt-1">Kepala Keluarga (KK)</p>
                </div>
                <div class="p-2 md:p-6 text-center group reveal fade-up" data-delay="200">
                    <div class="inline-flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-indigo-50 text-indigo-600 mb-1 sm:mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="text-base sm:text-2xl md:text-3xl font-extrabold text-slate-800" data-count-to="{{ $settings['demografi_laki'] ?? '1402' }}" data-count-suffix="">0</div>
                    <p class="text-[8px] sm:text-xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5 sm:mt-1">Laki-Laki</p>
                </div>
                <div class="p-2 md:p-6 text-center group reveal fade-up" data-delay="300">
                    <div class="inline-flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-pink-50 text-pink-600 mb-1 sm:mb-3 group-hover:bg-pink-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="text-base sm:text-2xl md:text-3xl font-extrabold text-slate-800" data-count-to="{{ $settings['demografi_perempuan'] ?? '1374' }}" data-count-suffix="">0</div>
                    <p class="text-[8px] sm:text-xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5 sm:mt-1">Perempuan</p>
                </div>
            </div>

            <!-- Tombol Selengkapnya ke Statistik & Monografi -->
            <div class="w-full py-2.5 sm:py-3.5 px-3 sm:px-6 text-center border-t border-slate-100 bg-slate-50/70 flex items-center justify-center reveal fade-up" data-delay="400">
                <a href="{{ route('profil.demografi') }}" class="inline-flex items-center justify-center gap-1.5 sm:gap-2 px-4 sm:px-6 py-2 sm:py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-extrabold text-[8px] sm:text-xs uppercase tracking-wider rounded-lg sm:rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group cursor-pointer text-center max-w-full">
                    <span>Lihat Selengkapnya Statistik & Monografi</span>
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Standar Pelayanan & SOP (Grid) -->
<section id="layanan" class="py-16 bg-white relative z-10 border-b border-slate-100" x-data="{
    searchQuery: '',
    scrollLeft() { $refs.sopSlider.scrollBy({ left: -340, behavior: 'smooth' }) },
    scrollRight() { $refs.sopSlider.scrollBy({ left: 340, behavior: 'smooth' }) }
}">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10 reveal fade-up">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold tracking-widest uppercase rounded-full mb-3 border border-emerald-200/60 shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Standar Pelayanan Publik
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-[#111827]">Standar Operasional Prosedur (SOP)</h2>
                <p class="text-slate-500 mt-2 font-medium text-sm leading-relaxed">
                    Panduan resmi alur kepengurusan administrasi dan berkas persyaratan pelayanan masyarakat di Kelurahan Sidomukti.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                {{-- <div class="flex items-center gap-1.5">
                    <button @click="scrollLeft" class="w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center transition shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="scrollRight" class="w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 flex items-center justify-center transition shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div> --}}
                <a href="{{ route('services.index') }}" class="hidden sm:inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm text-sm">
                    Semua SOP
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <div x-ref="sopSlider" class="flex flex-nowrap overflow-x-auto gap-4 md:gap-6 pb-6 pt-2 snap-x snap-mandatory scroll-smooth hide-scrollbar" style="scrollbar-width: thin; scrollbar-color: #10b981 #f1f5f9;">
            @if(isset($services) && $services->count() > 0)
                @foreach($services as $index => $service)
                <div class="w-[260px] sm:w-[280px] shrink-0 snap-start reveal fade-up" data-delay="{{ $index * 80 }}">
                    <div class="bg-white border-2 border-slate-100 hover:border-emerald-400 hover:shadow-xl rounded-2xl p-6 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-1.5 group h-full justify-between">
                        <div>
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl shadow-sm flex items-center justify-center text-emerald-700 group-hover:bg-gradient-to-br group-hover:from-emerald-600 group-hover:to-teal-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-600/30 transition-all duration-300 mb-4 mx-auto font-bold text-sm">
                                {{ $loop->iteration }}
                            </div>
                            <h3 class="font-bold text-sm text-slate-800 mb-2 group-hover:text-emerald-700 transition line-clamp-2">{{ $service->title }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-4">{{ $service->description ?? 'Pedoman operasional standar pelayanan administrasi masyarakat kelurahan.' }}</p>
                        </div>
                        <a href="{{ route('services.show', $service->slug) }}" class="mt-2 w-full py-2.5 bg-slate-50 border-2 border-emerald-500/30 text-emerald-700 font-bold text-xs uppercase tracking-wider rounded-xl group-hover:bg-emerald-600 group-hover:border-emerald-600 group-hover:text-white transition-all duration-300 block hover:shadow-lg hover:shadow-emerald-600/20">Lihat Dokumen SOP</a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <div class="mt-8 text-center sm:hidden reveal fade-up">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-600 hover:text-white font-extrabold rounded-xl transition-all duration-300 shadow hover:-translate-y-1 uppercase tracking-wide text-sm w-full justify-center">
                Semua SOP
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- Feed Informasi Berita & Maklumat Pelayanan (Sejajar) -->
<section id="berita" class="py-16 bg-slate-50 border-b border-slate-200/80">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Kolom Kiri: Berita & Informasi (lg:col-span-7) -->
            <div class="lg:col-span-7 flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-end mb-6 pb-2 border-b-2 border-slate-200 reveal fade-up">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 text-[10px] font-bold tracking-widest uppercase rounded-full mb-2 border border-green-200/60">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                Kabar Terkini
                            </span>
                            <h2 class="text-2xl font-extrabold text-slate-800 border-b-4 border-green-600 pb-2 -mb-[10px] inline-block">Berita & Informasi</h2>
                        </div>
                        <a href="{{ route('posts.index') }}" class="hidden sm:flex text-xs font-bold text-green-700 hover:text-green-800 transition items-center gap-1 uppercase tracking-wide bg-green-50 px-3.5 py-1.5 rounded-lg hover:bg-green-100 border border-green-200">
                            Indeks Berita <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    @if(isset($posts) && $posts->count() > 0)
                    <div class="grid grid-cols-2 gap-2 sm:gap-5">
                        @foreach($posts->take(4) as $index => $post)
                        <article class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full reveal fade-up" data-delay="{{ $index * 80 }}">
                            <div class="relative h-24 sm:h-40 overflow-hidden bg-slate-200 shrink-0">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 flex flex-col text-center shadow-lg rounded-lg overflow-hidden">
                                    <span class="bg-green-600 text-white font-extrabold text-[10px] sm:text-base px-1.5 sm:px-2.5 py-0.5">{{ \Carbon\Carbon::parse($post->published_at)->format('d') }}</span>
                                    <span class="bg-white text-slate-800 text-[7px] sm:text-[9px] font-bold uppercase px-1 sm:px-2 py-0.5 leading-none tracking-wider">{{ \Carbon\Carbon::parse($post->published_at)->format('M Y') }}</span>
                                </div>
                                @if($index === 0)
                                <div class="absolute top-1.5 right-1.5 sm:top-3 sm:right-3">
                                    <span class="bg-yellow-500 text-slate-900 text-[7px] sm:text-[9px] font-extrabold px-1 sm:px-2 py-0.5 rounded-full uppercase tracking-wider shadow">Terbaru</span>
                                </div>
                                @endif
                            </div>
                            <div class="p-2 sm:p-4 flex flex-col flex-grow">
                                <span class="inline-flex items-center gap-1 text-[7px] sm:text-[10px] font-bold text-green-600 uppercase tracking-wider mb-1 sm:mb-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> {{ $post->category_name }}
                                </span>
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    <h3 class="font-bold text-[10px] sm:text-sm text-slate-800 leading-snug mb-1 sm:mb-2 group-hover:text-green-700 transition line-clamp-2">{{ $post->title }}</h3>
                                </a>
                                <p class="text-[8px] sm:text-xs text-slate-500 line-clamp-2 mb-2 sm:mb-3 flex-grow leading-relaxed">{{ Str::limit(strip_tags(html_entity_decode($post->excerpt ?? $post->content)), 75) }}</p>
                                <div class="mt-auto pt-2 sm:pt-2.5 border-t border-slate-100 flex items-center justify-between">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-1 text-[9px] sm:text-xs font-bold text-green-600 hover:text-green-700 transition">
                                        Baca Selengkapnya <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @else
                    <div class="grid grid-cols-2 gap-2 sm:gap-5">
                        @foreach([1, 2, 3, 4] as $index => $i)
                        <article class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-xl transition duration-300 group flex flex-col h-full reveal fade-up" data-delay="{{ $index * 80 }}">
                            <div class="relative h-24 sm:h-40 overflow-hidden bg-slate-200 shrink-0">
                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop&sig={{$i}}" alt="Berita Dummy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 flex flex-col text-center shadow-lg rounded-lg overflow-hidden">
                                    <span class="bg-green-600 text-white font-extrabold text-[10px] sm:text-base px-1.5 sm:px-2.5 py-0.5">{{ 10 + $i }}</span>
                                    <span class="bg-white text-slate-800 text-[7px] sm:text-[9px] font-bold uppercase px-1 sm:px-2 py-0.5 leading-none tracking-wider">Sep 2026</span>
                                </div>
                            </div>
                            <div class="p-2 sm:p-4 flex flex-col flex-grow">
                                <span class="inline-flex items-center gap-1 text-[7px] sm:text-[10px] font-bold text-green-600 uppercase tracking-wider mb-1 sm:mb-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Informasi Publik
                                </span>
                                <a href="#"><h3 class="font-bold text-[10px] sm:text-sm text-slate-800 leading-snug mb-1 sm:mb-2 group-hover:text-green-700 transition line-clamp-2">Rapat Koordinasi Kelurahan Terkait Pelayanan {{$i}}</h3></a>
                                <p class="text-[8px] sm:text-xs text-slate-500 line-clamp-2 mb-2 sm:mb-3 flex-grow leading-relaxed">Kelurahan Sidomukti mengadakan rapat koordinasi bersama tokoh masyarakat...</p>
                                <div class="mt-auto pt-2 sm:pt-2.5 border-t border-slate-100">
                                    <a href="#" class="inline-flex items-center gap-1 text-[9px] sm:text-xs font-bold text-green-600 hover:text-green-800 transition">Baca Selengkapnya <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="mt-6 text-center sm:hidden">
                    <a href="{{ route('posts.index') }}" class="inline-flex text-xs font-bold text-white transition items-center gap-2 uppercase tracking-wide bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-xl shadow">Semua Berita <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
            </div>

            <!-- Kolom Kanan: Maklumat Pelayanan (lg:col-span-5) -->
            <div class="lg:col-span-5 flex flex-col h-full reveal fade-up" data-delay="150">
                <div class="flex justify-between items-end mb-6 pb-2 border-b-2 border-slate-200">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold tracking-widest uppercase rounded-full mb-2 border border-emerald-200/60">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Komitmen Layanan Publik
                        </span>
                        <h2 class="text-2xl font-extrabold text-slate-800 border-b-4 border-emerald-600 pb-2 -mb-[10px] inline-block">Maklumat Pelayanan</h2>
                    </div>
                </div>

                @if(isset($maklumat) && $maklumat)
                <!-- Executive Light Style Maklumat Card -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 text-slate-800 shadow-sm hover:shadow-xl border border-slate-200/90 relative overflow-hidden flex flex-col justify-between flex-grow group transition duration-300">
                    <!-- Top Decorative Accent Bar -->
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

                    <!-- Background Watermark Pattern -->
                    <div class="absolute -right-8 -bottom-8 opacity-[0.04] pointer-events-none group-hover:scale-105 transition-transform duration-700">
                        <img src="{{ $app_logo }}" class="w-64 h-64 object-contain filter grayscale" alt="Logo Watermark">
                    </div>

                    <div class="relative z-10">
                        <!-- Header Logo & Badge -->
                        <div class="flex items-center justify-between gap-3 mb-5 border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 p-1.5 bg-emerald-50 rounded-xl shadow-xs border border-emerald-100 shrink-0 flex items-center justify-center">
                                    <img src="{{ $app_logo }}" class="w-full h-full object-contain" alt="Logo Probolinggo">
                                </div>
                                <div>
                                    <span class="block text-[10px] font-black text-emerald-700 uppercase tracking-widest leading-none">Pemerintah Kab. Probolinggo</span>
                                    <span class="block text-xs font-bold text-slate-800 uppercase tracking-wider mt-0.5">Kelurahan Sidomukti</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200/80 tracking-wider">
                                Resmi
                            </span>
                        </div>

                        <!-- Maklumat Title & Subtitle -->
                        <h3 class="text-xl font-extrabold text-slate-900 tracking-tight leading-snug mb-4">
                            {{ $maklumat->title }}
                        </h3>

                        @if($maklumat->image)
                        <div class="mt-2 w-full overflow-hidden rounded-xl border border-slate-100 shadow-sm bg-slate-50 relative z-10">
                            <img src="{{ asset('storage/' . $maklumat->image) }}" alt="Maklumat Pelayanan" class="w-full h-auto object-contain rounded-xl">
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="bg-white rounded-3xl p-8 text-center border-2 border-dashed border-slate-200 text-slate-400 flex-grow flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-xs font-semibold">Data Maklumat Pelayanan Belum Diatur</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- Section Galeri & Album Kegiatan (2 Album + 2 Video) -->
<section id="galeri" class="py-16 bg-slate-50 border-b border-slate-200/80" x-data="{
    lightboxOpen: false,
    lightboxSrc: '',
    lightboxTitle: '',
    lightboxSlug: '',
    videoOpen: false,
    videoEmbedUrl: '',
    videoTitle: ''
}">
    <div class="container mx-auto px-4">
        <!-- Header Seksi Galeri & Video -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 pb-4 border-b border-slate-200/80 reveal fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-slate-100 text-slate-800 text-[11px] font-extrabold tracking-widest uppercase rounded-full mb-3 border border-slate-200 shadow-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Dokumentasi Visual & Video
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Galeri Album & Video Kegiatan</h2>
                <p class="text-slate-500 mt-2 text-sm sm:text-base font-medium max-w-xl">Dokumentasi resmi foto program serta video kegiatan warga Kelurahan Sidomukti.</p>
            </div>
            <div class="hidden md:flex flex-wrap items-center gap-3 mt-5 md:mt-0">
                <a href="{{ route('galleries.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 px-4 py-2.5 rounded-xl transition-all shadow-xs hover:shadow group">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Semua Album Foto</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('videos.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/80 px-4 py-2.5 rounded-xl transition-all shadow-xs hover:shadow group">
                    <svg class="w-3.5 h-3.5 text-rose-600 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    <span>Semua Video Dokumentasi</span>
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-6">
            <!-- 1. DUA ALBUM FOTO (2 Cards) -->
            @php
                $albumsList = (isset($galleries) && $galleries->count() > 0) ? $galleries->take(2) : collect([]);
            @endphp

            @if($albumsList->count() > 0)
                @foreach($albumsList as $index => $gallery)
                @php
                    $coverUrl = method_exists($gallery, 'getCoverUrlAttribute') ? $gallery->cover_url : (Str::startsWith($gallery->cover_image ?? $gallery->image_path, ['http://', 'https://']) ? ($gallery->cover_image ?? $gallery->image_path) : Storage::url($gallery->cover_image ?? $gallery->image_path));
                    $photoCount = $gallery->photos_count ?? (isset($gallery->photos) ? $gallery->photos->count() : 1);
                    $albumSlug = $gallery->slug ?? null;
                @endphp
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ $index * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <!-- Cover Image Container -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                            <img src="{{ $coverUrl }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-95 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <!-- Category Badge Top-Left -->
                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ ucfirst($gallery->category ?? 'Pemberdayaan') }}
                                </span>
                            </div>

                            <!-- Count Badge Bottom-Right -->
                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[8px] sm:text-[11px] font-bold rounded-md sm:rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                                    <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $photoCount }} Foto
                                </span>
                            </div>

                            <!-- Hover Overlay Preview Button -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-slate-950/40 backdrop-blur-xs">
                                <button @click.prevent="lightboxSrc = '{{ addslashes($coverUrl) }}'; lightboxTitle = '{{ addslashes($gallery->title) }}'; lightboxSlug = '{{ $albumSlug }}'; lightboxOpen = true;" class="bg-white/95 hover:bg-white text-slate-900 font-bold py-2 px-4 rounded-full text-xs shadow-xl transition transform group-hover:scale-105 flex items-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Perbesar Cover
                                </button>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-2 sm:p-5">
                            @if($albumSlug)
                            <a href="{{ route('galleries.show', $albumSlug) }}">
                                <h3 class="font-bold text-xs sm:text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-1 sm:mb-2">
                                    {{ $gallery->title }}
                                </h3>
                            </a>
                            @else
                            <h3 class="font-bold text-xs sm:text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-1 sm:mb-2">
                                {{ $gallery->title }}
                            </h3>
                            @endif
                            <p class="text-[9px] sm:text-xs text-slate-500 font-normal flex items-center gap-1">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $gallery->event_date ? \Carbon\Carbon::parse($gallery->event_date)->translatedFormat('d F Y') : 'Dokumentasi Kelurahan' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-2 pb-2 sm:px-5 sm:pb-5 pt-0">
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            @if($albumSlug)
                            <a href="{{ route('galleries.show', $albumSlug) }}" class="inline-flex items-center gap-1 sm:gap-1.5 text-[9px] sm:text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all">
                                <span>Lihat Album</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            @else
                            <button @click.prevent="lightboxSrc = '{{ addslashes($coverUrl) }}'; lightboxTitle = '{{ addslashes($gallery->title) }}'; lightboxOpen = true;" class="inline-flex items-center gap-1 sm:gap-1.5 text-[9px] sm:text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <span>Perbesar</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback 2 Dummy Album Cards if DB empty -->
                @foreach([
                    ['title' => 'Pelatihan & Pemberdayaan UMKM Kripik Warga Sidomukti', 'date' => '12 August 2026', 'cat' => 'Pemberdayaan', 'img' => 'https://images.unsplash.com/photo-1542744100-8a38a7611dc8?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Peresmian Drainase Lingkungan & Gotong Royong RW 03', 'date' => '28 July 2026', 'cat' => 'Pembangunan', 'img' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop']
                ] as $index => $dummyAlbum)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ $index * 80 }}">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950">
                            <img src="{{ $dummyAlbum['img'] }}" alt="{{ $dummyAlbum['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-95">
                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-slate-700/80">{{ $dummyAlbum['cat'] }}</span>
                            </div>
                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-emerald-600/90 backdrop-blur-md text-white text-[8px] sm:text-[11px] font-bold rounded-md sm:rounded-lg shadow-md flex items-center gap-1 border border-white/20">
                                    <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    4 Foto
                                </span>
                            </div>
                        </div>
                        <div class="p-2 sm:p-5">
                            <h3 class="font-bold text-xs sm:text-base text-slate-900 leading-snug group-hover:text-emerald-700 transition line-clamp-2 mb-1 sm:mb-2">{{ $dummyAlbum['title'] }}</h3>
                            <p class="text-[9px] sm:text-xs text-slate-500 font-normal flex items-center gap-1">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $dummyAlbum['date'] }}
                            </p>
                        </div>
                    </div>
                    <div class="px-2 pb-2 sm:px-5 sm:pb-5 pt-0">
                        <div class="pt-3 border-t border-slate-100">
                            <button @click.prevent="lightboxSrc = '{{ addslashes($dummyAlbum['img']) }}'; lightboxTitle = '{{ addslashes($dummyAlbum['title']) }}'; lightboxOpen = true;" class="inline-flex items-center gap-1 sm:gap-1.5 text-[9px] sm:text-xs font-bold text-emerald-600 hover:text-emerald-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <span>Perbesar Cover</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            <!-- 2. DUA VIDEO DOKUMENTASI (2 Cards) -->
            @php
                $videosList = (isset($videos) && $videos->count() > 0) ? $videos->take(2) : collect([]);
            @endphp

            @if($videosList->count() > 0)
                @foreach($videosList as $index => $video)
                @php
                    $vThumb = $video->thumbnail_url;
                    $vEmbed = $video->embed_url;
                @endphp
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ ($index + 2) * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <!-- Thumbnail Container with Play Button -->
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950 cursor-pointer" @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;">
                            <img src="{{ $vThumb }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <!-- Category Badge Top-Left -->
                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-rose-600/90 backdrop-blur-md text-white text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-rose-400/40 shadow-xs flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    {{ ucfirst($video->category ?? 'Video Kegiatan') }}
                                </span>
                            </div>

                            <!-- Duration Badge Bottom-Right -->
                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/90 backdrop-blur-md text-slate-200 text-[7px] sm:text-[10px] font-bold rounded-md sm:rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ $video->duration ?? 'Video Dok.' }}
                                </span>
                            </div>

                            <!-- Center Glowing Play Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-rose-600 text-white shadow-lg shadow-rose-600/40 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-500 transition duration-300 border border-white/90 sm:border-2">
                                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5 fill-current ml-0.5 sm:ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-2 sm:p-5">
                            <h3 @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;" class="font-bold text-xs sm:text-base text-slate-900 leading-snug group-hover:text-rose-600 transition line-clamp-2 mb-1 sm:mb-2 cursor-pointer">
                                {{ $video->title }}
                            </h3>
                            <p class="text-[9px] sm:text-xs text-slate-500 font-normal line-clamp-1 sm:line-clamp-2">
                                {{ $video->description ?? 'Video Liputan Resmi Kelurahan Sidomukti' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-2 pb-2 sm:px-5 sm:pb-5 pt-0">
                        <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="videoEmbedUrl = '{{ addslashes($vEmbed) }}'; videoTitle = '{{ addslashes($video->title) }}'; videoOpen = true;" class="inline-flex items-center gap-1 sm:gap-1.5 text-[9px] sm:text-xs font-bold text-rose-600 hover:text-rose-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span>Putar Video</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Fallback 2 Dummy Video Cards if DB empty -->
                @foreach([
                    ['title' => 'Video Profil & Potensi Kelurahan Sidomukti 2026', 'cat' => 'Pemerintahan', 'dur' => '05:30', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'thumb' => 'https://images.unsplash.com/photo-1574626003295-d868953930b8?q=80&w=600&auto=format&fit=crop'],
                    ['title' => 'Dokumentasi Peresmian Drainase Lingkungan & Gotong Royong RW 03', 'cat' => 'Pembangunan', 'dur' => '04:15', 'embed' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', 'thumb' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=600&auto=format&fit=crop']
                ] as $index => $dummyVid)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative reveal fade-up" data-delay="{{ ($index + 2) * 80 }}">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20"></div>

                    <div>
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-950 cursor-pointer" @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;">
                            <img src="{{ $dummyVid['thumb'] }}" alt="{{ $dummyVid['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>

                            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-rose-600/90 backdrop-blur-md text-white text-[7px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md sm:rounded-lg border border-rose-400/40 shadow-xs flex items-center gap-1">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    {{ $dummyVid['cat'] }}
                                </span>
                            </div>

                            <div class="absolute bottom-1.5 right-1.5 sm:bottom-3 sm:right-3 z-10">
                                <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/90 backdrop-blur-md text-slate-200 text-[7px] sm:text-[10px] font-bold rounded-md sm:rounded-lg border border-slate-700/80 shadow-xs">
                                    {{ $dummyVid['dur'] }}
                                </span>
                            </div>

                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-rose-600 text-white shadow-lg shadow-rose-600/40 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-500 transition duration-300 border border-white/90 sm:border-2">
                                    <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 sm:p-5">
                            <h3 @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;" class="font-bold text-xs sm:text-base text-slate-900 leading-snug group-hover:text-rose-600 transition line-clamp-2 mb-1 sm:mb-2 cursor-pointer">
                                {{ $dummyVid['title'] }}
                            </h3>
                            <p class="text-[9px] sm:text-xs text-slate-500 font-normal line-clamp-1 sm:line-clamp-2">Gambaran umum pelayanan publik, tata kelola...</p>
                        </div>
                    </div>

                    <div class="px-2 pb-2 sm:px-5 sm:pb-5 pt-0">
                        <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" @click="videoEmbedUrl = '{{ addslashes($dummyVid['embed']) }}'; videoTitle = '{{ addslashes($dummyVid['title']) }}'; videoOpen = true;" class="inline-flex items-center gap-1 sm:gap-1.5 text-[9px] sm:text-xs font-bold text-rose-600 hover:text-rose-700 group-hover:translate-x-1 transition-all cursor-pointer">
                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                <span>Putar Video</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Mobile Nav Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 md:hidden">
            <a href="{{ route('galleries.index') }}" class="w-full sm:w-auto inline-flex justify-center text-xs font-bold text-emerald-800 transition items-center gap-2 uppercase tracking-wide bg-emerald-50 hover:bg-emerald-100 px-5 py-3 rounded-xl border border-emerald-200/80 shadow-xs">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Semua Album Foto</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('videos.index') }}" class="w-full sm:w-auto inline-flex justify-center text-xs font-bold text-rose-800 transition items-center gap-2 uppercase tracking-wide bg-rose-50 hover:bg-rose-100 px-5 py-3 rounded-xl border border-rose-200/80 shadow-xs">
                <svg class="w-4 h-4 text-rose-700 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <span>Semua Video Dokumentasi</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>

    <!-- Seksi Kemitraan Strategis & Mitra Kerja -->
    <section id="kemitraan" class="pt-16 pb-0 -mb-12 sm:pt-20 sm:pb-0 sm:-mb-16 bg-slate-50/50 relative z-10 border-t border-slate-200/60" x-data="{
        scrollLeft() { $refs.slider.scrollBy({ left: -340, behavior: 'smooth' }) },
        scrollRight() { $refs.slider.scrollBy({ left: 340, behavior: 'smooth' }) }
    }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 reveal fade-up">
                <div class="max-w-2xl mx-auto">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 text-emerald-800 text-[10px] font-extrabold tracking-widest uppercase rounded-full mb-3 border border-emerald-200/80 shadow-xs">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Sinergi & Kolaborasi
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Instansi Terkait</h2>
                    <p class="text-slate-500 mt-2 font-medium text-sm leading-relaxed">
                        Kelurahan Sidomukti menjalin kerjasama berkelanjutan dengan instansi pemerintah, BUMN/BUMD, lembaga pendidikan, dan sektor swasta demi kemajuan warga.
                    </p>
                </div>
            </div>

            @if(isset($partnerships) && $partnerships->count() > 0)
            <div x-ref="slider" class="flex flex-nowrap overflow-x-auto gap-6 pb-2 pt-2 snap-x snap-mandatory scroll-smooth max-w-fit mx-auto" style="scrollbar-width: thin; scrollbar-color: #10b981 #f1f5f9;">
                @foreach($partnerships as $index => $partner)
                <div class="relative w-[240px] shrink-0 snap-start bg-white rounded-xl p-3 flex items-center gap-3.5 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 hover:border-emerald-200/60 transition-all duration-300 group reveal fade-up" data-delay="{{ $index * 40 }}">
                    <div class="w-10 h-10 p-1 flex items-center justify-center shrink-0">
                        <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain mix-blend-multiply grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 group-hover:scale-105 transition-all duration-300">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-[12px] text-slate-800 truncate group-hover:text-emerald-700 transition-colors">
                            @if($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" class="focus:outline-none before:absolute before:inset-0">
                                    {{ $partner->name }}
                                </a>
                            @else
                                {{ $partner->name }}
                            @endif
                        </h3>
                        @if($partner->category)
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest truncate mt-0.5">{{ $partner->category }}</p>
                        @endif
                    </div>
                    @if($partner->website)
                    <div class="pr-1 text-slate-300 group-hover:text-emerald-500 transition-colors shrink-0">
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-100 text-slate-400 text-xs">
                Belum ada data kemitraan aktif yang ditampilkan.
            </div>
            @endif
        </div>
    </section>

    <!-- 1. Lightbox Modal Foto -->
    <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 lightbox-overlay bg-slate-950/80 backdrop-blur-md" style="display: none;">
        <div class="relative max-w-4xl w-full max-h-[85vh] bg-white rounded-2xl overflow-hidden shadow-2xl border border-slate-200">
            <button @click="lightboxOpen = false" class="absolute top-4 right-4 z-10 w-10 h-10 bg-slate-900/80 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-red-600 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img :src="lightboxSrc" :alt="lightboxTitle" class="w-full max-h-[70vh] object-contain bg-slate-950">
            <div class="p-5 bg-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h3 class="text-slate-900 font-bold text-base md:text-lg" x-text="lightboxTitle"></h3>
                    <p class="text-slate-500 text-xs mt-0.5">Kelurahan Sidomukti — Dokumentasi Galeri Album</p>
                </div>
                <template x-if="lightboxSlug">
                    <a :href="'/galeri/' + lightboxSlug" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-xs transition inline-flex items-center gap-1.5">
                        Buka Album Full
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <!-- 2. Lightbox Modal Video Embed YouTube -->
    <div x-show="videoOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md" style="display: none;" x-cloak>
        <div class="relative max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800">
            <div class="flex items-center justify-between px-5 py-3 border-b border-slate-800 text-white">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <h3 class="font-bold text-sm truncate max-w-lg" x-text="videoTitle"></h3>
                </div>
                <button @click="videoOpen = false; videoEmbedUrl = ''" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="relative aspect-video w-full bg-black">
                <template x-if="videoEmbedUrl">
                    <iframe :src="videoEmbedUrl + (videoEmbedUrl.includes('?') ? '&' : '?') + 'autoplay=1'" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </div>
@endsection
