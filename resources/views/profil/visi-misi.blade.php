@extends('layouts.app')

@section('title', 'Visi & Misi - Kelurahan Sidomukti')

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Visi & Misi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Komitmen & Arah Kebijakan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Visi & Misi Kelurahan Sidomukti
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Pedoman dan landasan utama pelaksanaan pemerintahan, pembangunan infrastruktur, dan pemberdayaan masyarakat Kelurahan Sidomukti, Kecamatan Kraksaan.
                </p>
            </div>
        </div>
    </div>

    @php
        $visiMisiText = !empty($settings['visi_misi']) ? $settings['visi_misi'] : "Visi\nTerwujudnya Kelurahan Sidomukti yang Mandiri, Sejahtera, Transparan, dan Berbudaya Berlandaskan Gotong Royong\n\nMisi\n1. Meningkatkan kualitas tata kelola pemerintahan kelurahan yang transparan, akuntabel, dan responsif dalam memberikan pelayanan prima kepada masyarakat.\n2. Mendorong kemandirian ekonomi warga melalui pengembangan UMKM, pelatihan keterampilan, dan pemanfaatan potensi lokal secara optimal.\n3. Meningkatkan derajat kesehatan dan pendidikan masyarakat serta kepedulian sosial yang berlandaskan asas gotong royong warga.\n4. Mewujudkan pembangunan infrastruktur desa yang memadai dengan tetap menjaga kelestarian lingkungan dan kebersihan tata ruang kelurahan.";
        
        $visi = '';
        $misi = '';
        
        if (stripos($visiMisiText, 'Misi') !== false) {
            $parts = preg_split('/Misi/i', $visiMisiText, 2);
            $visi = trim(str_ireplace('Visi', '', $parts[0]));
            $misi = trim($parts[1]);
        } else {
            $visi = trim(str_ireplace('Visi', '', $visiMisiText));
        }
        
        $visi = preg_replace('/^[\'\"“”‘’:]+|[\'\"“”‘’:]+$/u', '', trim($visi));
        
        $misiArray = [];
        if (!empty($misi)) {
            $lines = explode("\n", $misi);
            foreach($lines as $line) {
                $cleaned = trim(preg_replace('/^[\d\.\-\*:]+/', '', trim($line)));
                if (!empty($cleaned)) {
                    $misiArray[] = $cleaned;
                }
            }
        }
    @endphp

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="space-y-6">

            <!-- Card VISI -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold border border-emerald-100 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-700">Arah & Cita-Cita</span>
                            <h2 class="text-lg md:text-xl font-bold text-slate-900">Visi Kelurahan Sidomukti</h2>
                        </div>
                    </div>

                    <div class="p-5 md:p-6 bg-emerald-50/50 rounded-xl border border-emerald-100/80">
                        <p class="text-slate-800 text-sm md:text-base leading-relaxed font-medium italic text-center md:text-left">
                            "{{ $visi }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card MISI -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-blue-700">Langkah Strategis</span>
                            <h2 class="text-lg md:text-xl font-bold text-slate-900">Misi Kelurahan Sidomukti</h2>
                        </div>
                    </div>

                    <div class="space-y-3.5">
                        @foreach($misiArray as $index => $item)
                        <div class="flex items-start gap-3.5 p-4 rounded-xl bg-slate-50/80 border border-slate-100 hover:border-emerald-200 transition-colors">
                            <span class="w-7 h-7 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs mt-0.5">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-slate-700 text-xs sm:text-sm leading-relaxed font-medium">
                                {{ $item }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bottom Information Box -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500 font-medium">
                <span>Pemerintah Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo</span>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-bold transition">
                    <span>Kembali ke Beranda</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
