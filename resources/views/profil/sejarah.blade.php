@extends('layouts.app')

@section('title', 'Sejarah Kelurahan - Kelurahan Sidomukti')

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
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-slate-400">Profil</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Sejarah</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-950/60 border border-amber-500/30 rounded-full text-amber-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    Asal Usul & Perkembangan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Sejarah Kelurahan Sidomukti
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Perjalanan sejarah pembentukan, nilai filosofis, dan transformasi Kelurahan Sidomukti di Kecamatan Kraksaan, Kabupaten Probolinggo.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        @php
            $sejarahImg = !empty($settings['foto_sejarah']) 
                ? (\Illuminate\Support\Str::startsWith($settings['foto_sejarah'], ['http://', 'https://']) 
                    ? $settings['foto_sejarah'] 
                    : Storage::url($settings['foto_sejarah']))
                : 'https://images.unsplash.com/photo-1544396821-4dd40b938ad3?q=80&w=1000&auto=format&fit=crop';
        @endphp

        <div class="flex flex-col md:flex-row gap-6 lg:gap-8 items-start">
            
            {{-- Left Side: Separate Card Box for Image --}}
            <div class="w-full md:w-5/12 shrink-0 md:sticky md:top-24">
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/90">
                    <div class="relative rounded-xl overflow-hidden shadow-xs border border-slate-100 bg-slate-100 group">
                        <img src="{{ $sejarahImg }}" alt="Foto Sejarah Kelurahan Sidomukti" class="w-full h-72 md:h-96 object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none"></div>
                        <div class="absolute bottom-3 left-3 right-3 text-white text-xs font-semibold px-3 py-1.5 bg-slate-900/60 backdrop-blur-md rounded-lg flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="truncate">Dokumentasi Sejarah Sidomukti</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Separate Card Box for History Text --}}
            <div class="w-full md:w-7/12 flex-1">
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200/90">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Filosofi & Asal Usul Nama</span>
                    </div>
                    
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-slate-900 mb-5 leading-snug">
                        Makna & Sejarah Kelurahan Sidomukti
                    </h2>
                    
                    @if(!empty($settings['sejarah']))
                    <div class="prose prose-slate prose-base max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-emerald-600 hover:prose-a:text-emerald-700 text-slate-700 leading-relaxed space-y-4">
                        {!! \Illuminate\Support\Str::startsWith(trim($settings['sejarah']), '<') ? $settings['sejarah'] : \Illuminate\Support\Str::markdown($settings['sejarah']) !!}
                    </div>
                    @else
                    <div class="space-y-4 text-sm sm:text-base text-slate-700 leading-relaxed">
                        <p>
                            Nama <strong>Sidomukti</strong> berasal dari kata bahasa Jawa; <em>Sido</em> yang berarti "jadi" atau "terwujud", dan <em>Mukti</em> yang bermakna "kebahagiaan", "kemakmuran", atau "kesejahteraan". Secara harfiah, Sidomukti mengandung doa dan harapan agar masyarakat di wilayah ini senantiasa mencapai kemakmuran dan kesejahteraan hidup lahir batin.
                        </p>
                        <p>
                            Pada masa penjajahan Hindia Belanda, wilayah ini dulunya adalah area perkebunan dan pertanian subur yang dikelola oleh para pamong dan tetua desa. Seiring perkembangan kependudukan dan pemekaran wilayah administratif pasca kemerdekaan, Sidomukti resmi ditetapkan sebagai kelurahan definitif di wilayah sentral Kecamatan Kraksaan.
                        </p>
                        <p>
                            Hingga saat ini, Sidomukti terus mengalami perkembangan pesat baik dari segi infrastruktur, pelayanan digital, maupun perekonomian warga, tanpa melupakan nilai-nilai luhur kearifan lokal gotong royong.
                        </p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
