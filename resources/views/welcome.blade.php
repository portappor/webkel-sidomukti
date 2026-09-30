@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="relative bg-slate-900 h-[450px] md:h-[550px] overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1596700021663-125026047055?q=80&w=2070&auto=format&fit=crop" alt="Desa Background" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-900/70 to-transparent"></div>
    </div>

    <div class="container mx-auto px-4 h-full relative z-10 flex items-center">
        <div class="w-full md:w-3/5 text-white">
            <div class="inline-block px-3 py-1 bg-green-600/90 text-xs font-semibold uppercase tracking-widest rounded mb-6 shadow-sm">
                Portal Pemerintahan
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-5 text-white">
                Website Resmi <br><span class="text-green-400">Desa Sidomukti</span>
            </h1>
            <p class="text-base md:text-lg text-slate-200 mb-8 max-w-xl font-light leading-relaxed">
                Menyajikan informasi penyelenggaraan pemerintahan, pembangunan, pembinaan kemasyarakatan, dan pemberdayaan masyarakat Desa Sidomukti.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md shadow-lg transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Layanan Surat
                </a>
                <a href="#" class="px-6 py-3 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-600 text-white font-semibold rounded-md backdrop-blur-sm transition duration-200">
                    Jelajahi Profil
                </a>
            </div>
        </div>
        <div class="hidden md:flex w-full md:w-2/5 justify-end items-end h-full pt-16">
            <!-- Portrait placeholder of Kades -->
            <div class="relative h-[95%]">
                <div class="absolute inset-0 bg-green-600 rounded-t-2xl transform translate-x-4 translate-y-4 opacity-20"></div>
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=687&auto=format&fit=crop" alt="Kepala Desa" class="h-full object-cover object-top mask-image-gradient border-x-4 border-t-4 border-slate-700/50 rounded-t-2xl relative z-10">
                
                <div class="absolute bottom-12 -left-12 bg-white p-3 rounded-lg shadow-xl z-20 flex items-center gap-3 border-l-4 border-green-600">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xl">👤</div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">Bapak Sutejo, S.Sos</div>
                        <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Kepala Desa Sidomukti</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Link Cepat / Mitra -->
<section class="bg-white border-b py-8 shadow-sm relative z-20 -mt-2">
    <div class="container mx-auto px-4">
        <p class="text-center text-xs text-slate-400 font-semibold uppercase tracking-widest mb-4">Layanan & Situs Terintegrasi</p>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/4b/Lambang_Kabupaten_Probolinggo.png" alt="Probolinggo" class="h-10 grayscale hover:grayscale-0 transition duration-300">
            <div class="font-bold text-slate-700 hover:text-slate-900 text-lg tracking-widest uppercase transition cursor-pointer">SP4N LAPOR!</div>
            <div class="font-bold text-slate-700 hover:text-slate-900 text-lg tracking-widest uppercase transition cursor-pointer">SATUDATA</div>
            <div class="font-bold text-slate-700 hover:text-slate-900 text-lg tracking-widest uppercase transition cursor-pointer">KEMENDESA</div>
            <div class="font-bold text-slate-700 hover:text-slate-900 text-lg tracking-widest uppercase transition cursor-pointer">INFO JATIM</div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-16 flex flex-col lg:flex-row gap-10">
    
    <!-- Left Column: Berita Utama -->
    <div class="w-full lg:w-2/3">
        <div class="flex justify-between items-end mb-8 border-b-2 border-slate-200 pb-2">
            <h2 class="text-2xl font-bold text-slate-800 border-b-4 border-green-600 pb-2 -mb-[10px] inline-block">Informasi Terbaru</h2>
            <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-800 transition flex items-center gap-1">Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- News Card 1 -->
            <article class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition duration-300 group flex flex-col h-full">
                <div class="relative h-52 overflow-hidden bg-slate-200 shrink-0">
                    <img src="https://images.unsplash.com/photo-1544396821-4dd40b938ad3?q=80&w=2073&auto=format&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <!-- Date Badge -->
                    <div class="absolute top-4 left-4 flex flex-col text-center shadow-lg rounded overflow-hidden">
                        <span class="bg-green-600 text-white font-bold text-xl px-4 py-1.5">24</span>
                        <span class="bg-white text-slate-800 text-[10px] font-bold uppercase px-2 py-1 leading-none tracking-wider">Sep 2025</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="text-xs font-bold text-green-600 mb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Pemerintahan
                    </div>
                    <a href="#">
                        <h3 class="font-bold text-lg md:text-xl text-slate-800 leading-snug mb-3 group-hover:text-green-700 transition">Rapat Koordinasi Persiapan Pemilihan Kepala Desa Serentak</h3>
                    </a>
                    <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-grow">Pemerintah Desa Sidomukti mengadakan rapat koordinasi bersama BPD, tokoh masyarakat dan jajaran perangkat desa untuk menyukseskan Pilkades serentak tahun ini dengan damai dan kondusif.</p>
                    <a href="#" class="text-sm font-semibold text-slate-700 hover:text-green-600 transition flex items-center gap-1 mt-auto">Baca selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
            </article>

            <!-- News Card 2 -->
            <article class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition duration-300 group flex flex-col h-full">
                <div class="relative h-52 overflow-hidden bg-slate-200 shrink-0">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 left-4 flex flex-col text-center shadow-lg rounded overflow-hidden">
                        <span class="bg-green-600 text-white font-bold text-xl px-4 py-1.5">15</span>
                        <span class="bg-white text-slate-800 text-[10px] font-bold uppercase px-2 py-1 leading-none tracking-wider">Sep 2025</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="text-xs font-bold text-green-600 mb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Pembangunan
                    </div>
                    <a href="#">
                        <h3 class="font-bold text-lg md:text-xl text-slate-800 leading-snug mb-3 group-hover:text-green-700 transition">Perbaikan Jalan Poros Desa Sepanjang 2 Kilometer Dimulai</h3>
                    </a>
                    <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-grow">Sebagai tindak lanjut musyawarah rencana pembangunan desa (Musrenbangdes), perbaikan infrastruktur jalan utama desa telah resmi dimulai hari ini untuk mempermudah akses ekonomi warga.</p>
                    <a href="#" class="text-sm font-semibold text-slate-700 hover:text-green-600 transition flex items-center gap-1 mt-auto">Baca selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
            </article>
            
            <!-- News Card 3 -->
            <article class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition duration-300 group flex flex-col h-full">
                <div class="relative h-52 overflow-hidden bg-slate-200 shrink-0">
                    <img src="https://images.unsplash.com/photo-1628191140046-5777713437bb?q=80&w=2070&auto=format&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 left-4 flex flex-col text-center shadow-lg rounded overflow-hidden">
                        <span class="bg-slate-700 text-white font-bold text-xl px-4 py-1.5">08</span>
                        <span class="bg-white text-slate-800 text-[10px] font-bold uppercase px-2 py-1 leading-none tracking-wider">Sep 2025</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-500 inline-block"></span> Sosial
                    </div>
                    <a href="#">
                        <h3 class="font-bold text-lg md:text-xl text-slate-800 leading-snug mb-3 group-hover:text-green-700 transition">Penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Tahap III</h3>
                    </a>
                    <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-grow">Penyaluran BLT Dana Desa berjalan lancar dengan tetap mematuhi protokol kesehatan dan diserahkan langsung oleh Kepala Desa kepada keluarga penerima manfaat.</p>
                    <a href="#" class="text-sm font-semibold text-slate-700 hover:text-green-600 transition flex items-center gap-1 mt-auto">Baca selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
            </article>

            <!-- News Card 4 -->
            <article class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition duration-300 group flex flex-col h-full">
                <div class="relative h-52 overflow-hidden bg-slate-200 shrink-0">
                    <img src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?q=80&w=2070&auto=format&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 left-4 flex flex-col text-center shadow-lg rounded overflow-hidden">
                        <span class="bg-slate-700 text-white font-bold text-xl px-4 py-1.5">01</span>
                        <span class="bg-white text-slate-800 text-[10px] font-bold uppercase px-2 py-1 leading-none tracking-wider">Sep 2025</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-500 inline-block"></span> Kesehatan
                    </div>
                    <a href="#">
                        <h3 class="font-bold text-lg md:text-xl text-slate-800 leading-snug mb-3 group-hover:text-green-700 transition">Kegiatan Posyandu Balita dan Lansia Rutin Bulanan</h3>
                    </a>
                    <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-grow">Untuk memastikan kesehatan warga, kader Posyandu Desa Sidomukti kembali melaksanakan pelayanan kesehatan gratis bagi balita dan lansia di Balai Desa.</p>
                    <a href="#" class="text-sm font-semibold text-slate-700 hover:text-green-600 transition flex items-center gap-1 mt-auto">Baca selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
            </article>
        </div>
    </div>

    <!-- Right Column: Sidebar Widgets -->
    <aside class="w-full lg:w-1/3 flex flex-col gap-8">
        
        <!-- Widget: Profil Kades -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="h-24 bg-slate-800 w-full relative">
                <!-- decorative pattern -->
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 10px 10px;"></div>
            </div>
            <div class="px-6 pb-6 text-center relative">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=687&auto=format&fit=crop" alt="Kepala Desa" class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-white shadow-md -mt-14 mb-4 relative z-10 bg-white">
                <h3 class="font-bold text-xl text-slate-800">Bapak Sutejo, S.Sos</h3>
                <p class="text-sm text-green-600 font-bold mb-4 uppercase tracking-wider">Kepala Desa Sidomukti</p>
                <p class="text-sm text-slate-500 italic bg-slate-50 p-4 rounded-lg border border-slate-100 relative">
                    <span class="absolute top-2 left-2 text-3xl text-slate-200 leading-none">"</span>
                    Melayani dengan Hati, Membangun Desa yang Lebih Maju, Mandiri, dan Transparan demi kesejahteraan bersama.
                    <span class="absolute bottom-[-10px] right-2 text-3xl text-slate-200 leading-none">"</span>
                </p>
                <a href="#" class="inline-block mt-4 text-sm font-semibold text-slate-600 hover:text-green-600 transition border-b border-transparent hover:border-green-600">Selengkapnya Profil Kades</a>
            </div>
        </div>

        <!-- Widget: Maklumat Pelayanan -->
        <div class="bg-slate-800 rounded-xl shadow-sm overflow-hidden text-white relative h-64 group cursor-pointer">
             <img src="https://images.unsplash.com/photo-1450101499163-c8848c66cb85?q=80&w=2070&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay group-hover:scale-105 transition duration-700">
             <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 to-transparent"></div>
             <div class="absolute inset-0 p-6 flex flex-col justify-end items-center text-center">
                 <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 border border-white/30">
                     <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                 </div>
                 <h3 class="font-bold text-2xl mb-2 text-white">Maklumat Pelayanan</h3>
                 <p class="text-xs text-slate-200">Kami siap memberikan pelayanan publik dengan cepat, tepat, dan transparan.</p>
             </div>
        </div>

        <!-- Widget: Info SKM -->
        <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl shadow-sm p-8 text-white text-center relative overflow-hidden">
             <!-- decorative circles -->
             <div class="absolute -right-10 -top-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
             <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-white opacity-10 rounded-full"></div>
             
             <h3 class="font-bold text-lg mb-1 relative z-10">Indeks Kepuasan Masyarakat</h3>
             <p class="text-sm text-green-100 mb-5 relative z-10 font-medium">Tahun 2025</p>
             <div class="text-6xl font-extrabold mb-3 relative z-10 tracking-tight">89.4</div>
             <div class="inline-block px-4 py-1.5 bg-white text-green-800 rounded-full text-sm font-bold uppercase relative z-10 shadow-md tracking-wider">Sangat Baik</div>
        </div>

        <!-- Widget: Pengaduan (LAPOR) -->
        <a href="#" class="block bg-white rounded-xl shadow-sm border border-slate-100 p-5 hover:border-red-400 hover:shadow-md transition group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-red-600 group-hover:text-white transition duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-slate-800 group-hover:text-red-600 transition">Layanan Pengaduan</h3>
                    <p class="text-sm text-slate-500 mt-1">Sampaikan keluhan dan aspirasi Anda secara online</p>
                </div>
            </div>
        </a>

    </aside>
</div>
@endsection
