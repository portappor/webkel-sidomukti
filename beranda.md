<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings['site_title'] ?? 'Website Resmi | DKUPP Kabupaten Probolinggo' }}</title>
    <meta name="description" content="{{ $settings['site_description'] ?? 'Website Resmi Dinas Koperasi, Usaha Mikro, Perdagangan dan Perindustrian Kabupaten Probolinggo' }}">
    <link rel="icon" type="image/png" href="{{ $settings['logo_frontend'] ?? '' }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome & Tailwind CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#022c22',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        .high-contrast { filter: contrast(150%) brightness(95%); }

        @keyframes runningLineAnim {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-running-line {
            animation: runningLineAnim 1.2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-700 font-sans antialiased min-h-screen flex flex-col selection:bg-emerald-600 selection:text-white overflow-x-hidden w-full max-w-full"
      x-data="{ 
          mobileMenu: false, 
          highContrast: false, 
          fontSize: 100, 
          activeSlide: 0,
          activePhoto: null,
          totalSlides: {{ count($sliders ?? []) ?: 1 }},
          nextSlide() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides },
          prevSlide() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides }
      }"
      :class="{ 'high-contrast': highContrast }"
      :style="`font-size: ${fontSize}%`"
      x-init="if(totalSlides > 1) setInterval(() => nextSlide(), 7000)">

    @include('partials.public_header')

    <!-- Main Content -->
    <main class="flex-grow">
        
        <!-- Hero Slider (Clean & 100% Clear Background Image) -->
        <section class="relative bg-slate-950 overflow-hidden min-h-[380px] sm:min-h-[460px] lg:min-h-[520px] flex items-center">
            @foreach($sliders as $index => $slide)
                <div x-show="activeSlide === {{ $index }}"
                     x-transition:enter="transition opacity duration-700 ease-out"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition opacity duration-500 ease-in"
                     class="absolute inset-0 w-full h-full">
                    
                    <!-- Background Banner Image (Full Brightness, No Dark Boxes) -->
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-10000"
                         style="background-image: url('{{ $slide->image_url }}');">
                        <!-- Ultra subtle bottom gradient ONLY for text contrast without blocking photo -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20"></div>
                    </div>

                    <!-- Content Container (Moved lower to the bottom of the banner) -->
                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end z-10 pb-10 sm:pb-12 pt-24 sm:pt-36">
                        <div class="max-w-xl text-white space-y-1.5 sm:space-y-2.5 drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)] mb-2">
                            <!-- Minimalist Title with Animated Running Line -->
                            <div class="space-y-2.5">
                                <h1 class="text-lg sm:text-2xl font-extrabold tracking-tight text-white leading-snug drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)]">
                                    {{ $slide->title }}
                                </h1>
                                
                                <!-- Garis Berjalan / Animated Running Line Under Banner Title -->
                                <div class="h-1 max-w-sm w-full bg-slate-800/80 rounded-full overflow-hidden relative shadow-md">
                                    <div class="h-full w-full bg-gradient-to-r from-emerald-500 via-teal-300 to-emerald-600 rounded-full animate-running-line shadow-lg"></div>
                                </div>

                                <!-- Minimalist Subtitle with Text Shadow -->
                                <p class="text-xs sm:text-sm text-white/90 font-bold leading-relaxed drop-shadow-[0_1px_3px_rgba(0,0,0,0.9)]">
                                    {{ $slide->subtitle }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Slider Controls (Minimalist Dots) -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                @foreach($sliders as $index => $slide)
                    <button @click="activeSlide = {{ $index }}" class="h-2 rounded-full transition-all duration-300 shadow-md"
                            :class="activeSlide === {{ $index }} ? 'w-8 bg-emerald-500' : 'w-2 bg-white/60 hover:bg-white'"></button>
                @endforeach
            </div>
        </section>

        <!-- Sambutan Kadin (Lebih Bersih) -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-12 items-center">
                    <div class="w-full lg:w-1/3 flex justify-center">
                        <div class="relative w-64">
                            <img src="{{ $settings['kadin_photo'] ?? 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop' }}" 
                                 alt="Lurah Kandang Jati Kulon Kraksaan" class="w-full h-80 object-cover rounded-2xl shadow-lg border border-slate-100">
                            <div class="absolute -bottom-4 inset-x-4 bg-white border border-slate-100 py-3 px-4 rounded-xl shadow-sm text-center">
                                <h4 class="font-bold text-sm text-slate-800">{{ $settings['kadin_name'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}</h4>
                                <p class="text-[10px] text-emerald-600 font-semibold uppercase mt-0.5">{{ $settings['kadin_title'] ?? 'LURAH KANDANG JATI KULON Kraksaan' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-2/3 space-y-5 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 text-emerald-600 text-xs font-bold uppercase tracking-widest">
                            Sambutan {{ $settings['kadin_title'] ?? 'LURAH KANDANG JATI KULON Kraksaan' }}
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                            Melayani Warga Sepenuh Hati Menuju KELURAHAN KANDANG JATI KULON yang Maju, Sejahtera & Mandiri
                        </h2>
                        <p class="text-slate-600 text-sm leading-relaxed max-w-3xl">
                            Selamat Datang di Portal Resmi <strong>{{ $settings['agency_name'] ?? 'KELURAHAN KANDANG JATI KULON' }} {{ $settings['regency_name'] ?? 'Kecamatan Kraksaan, Kabupaten Probolinggo' }}</strong>. Kami berkomitmen menyajikan pelayanan publik prima, kemudahan administrasi kependudukan dan pengurusan surat keterangan, transparansi kinerja kelurahan, serta pemberdayaan potensi ekonomi warga lokal.
                        </p>
                        <div class="pt-4 flex flex-wrap gap-4 items-center justify-center lg:justify-start">
                            <a href="{{ route('page', 'visi-misi') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold text-sm transition-colors">
                                Visi & Misi Kami <i class="fas fa-arrow-right ms-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BANNER & HIGHLIGHT APPDES KELURAHAN KANDANG JATI KULON -->
        <section class="py-12 bg-gradient-to-r from-emerald-950 via-emerald-900 to-slate-900 text-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">
                
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-3 text-center md:text-left max-w-2xl">
                        <span class="px-3.5 py-1 bg-emerald-700/60 border border-emerald-500/40 text-emerald-200 text-[11px] font-extrabold rounded-full uppercase tracking-wider inline-flex items-center gap-1.5 shadow-sm">
                            <i class="fas fa-mobile-alt text-emerald-300"></i> {{ $settings['appdes_badge'] ?? 'AppDes KELURAHAN KANDANG JATI KULON' }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white leading-snug">
                            {{ $settings['appdes_title'] ?? 'Portal AppDes (Aplikasi Pelayanan Kelurahan Digital)' }}
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                            {{ $settings['appdes_desc'] ?? 'Akses sistem informasi pelayanan kependudukan digital, integrasi data RT/RW, dan kemudahan pengurusan administrasi warga KELURAHAN KANDANG JATI KULON Kraksaan.' }}
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
                        <a href="{{ $settings['appdes_url'] ?? 'https://appdes.probolinggokab.go.id/' }}" target="_blank" class="px-6 py-3.5 bg-emerald-400 hover:bg-emerald-300 text-slate-950 font-black text-xs rounded-2xl shadow-xl hover:shadow-emerald-400/30 transition-all hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-external-link-alt text-xs"></i> Buka Portal AppDes Kandang Jati Kulon
                        </a>
                        @if(!empty($settings['dana_desa_file']))
                            <a href="{{ asset($settings['dana_desa_file']) }}" target="_blank" class="px-5 py-3.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs rounded-2xl shadow-xl hover:shadow-amber-400/30 transition-all hover:scale-105 flex items-center gap-2">
                                <i class="fas fa-file-pdf text-rose-700 text-sm"></i> Unduh Transparansi Dana Desa (PDF)
                            </a>
                        @else
                            <a href="{{ route('surat.form') }}" class="px-5 py-3.5 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-extrabold text-xs rounded-2xl backdrop-blur-md transition-all flex items-center gap-2">
                                <i class="fas fa-file-signature text-xs text-emerald-300"></i> Permohonan Surat Online
                            </a>
                        @endif
                    </div>
                </div>

                <!-- STATISTIK / NILAI REAL-TIME KELURAHAN -->
                <div class="pt-8 border-t border-emerald-800/50 space-y-6" x-data="{ showMonthlyModal: false }">
                    
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="space-y-1 text-center sm:text-left">
                            <span class="text-[10px] font-extrabold text-emerald-300/90 uppercase tracking-widest bg-emerald-900/60 px-3 py-0.5 rounded-full border border-emerald-500/30 inline-block">
                                Transparansi Data & Kinerja Kelurahan
                            </span>
                            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                                Data & Statistik Pelayanan Kandang Jati Kulon
                            </h3>
                        </div>
                        <button @click="showMonthlyModal = true" class="px-4 py-2 bg-emerald-900/50 hover:bg-emerald-800/70 border border-emerald-500/30 text-emerald-200 hover:text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                            <i class="fas fa-table text-emerald-400"></i> Rekap Pelayanan Bulanan
                        </button>
                    </div>

                    <!-- GRID 9 CARD STATISTIK UTAMA -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
                        
                        <!-- Card Dana Desa -->
                        <a href="{{ !empty($settings['dana_desa_file']) ? asset($settings['dana_desa_file']) : route('dokumen') }}" @if(!empty($settings['dana_desa_file'])) target="_blank" @endif class="group col-span-2 sm:col-span-1 lg:col-span-1 p-4 bg-emerald-900/40 hover:bg-emerald-800/60 backdrop-blur-md border border-amber-400/40 hover:border-amber-300/80 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-base sm:text-lg font-black text-amber-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-coins text-amber-400 text-base group-hover:rotate-12 transition-transform"></i>
                                    <span>{{ $settings['dana_desa_amount'] ?? 'Rp 1.250.000.000,-' }}</span>
                                </div>
                                <p class="text-[11px] font-extrabold text-amber-200/90 uppercase tracking-wider">
                                    Dana Desa {{ $settings['dana_desa_year'] ?? date('Y') }}
                                </p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-extrabold text-amber-300/90 group-hover:text-white transition-colors">
                                <i class="fas fa-file-pdf text-amber-400"></i>
                                <span>Transparansi (PDF)</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 1: Jumlah Penduduk -->
                        <a href="{{ route('statistik') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-users text-lg sm:text-xl text-emerald-400 group-hover:rotate-6 transition-transform"></i>
                                    <span>{{ $stats['jumlah_penduduk'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">JUMLAH PENDUDUK</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Data Terkini</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 2: Jumlah KK -->
                        <a href="{{ route('statistik') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-house-user text-lg sm:text-xl text-emerald-400 group-hover:-rotate-6 transition-transform"></i>
                                    <span>{{ $stats['jumlah_kk'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">JUMLAH KK</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Data Keluarga</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 3: Jumlah RT/RW -->
                        <a href="{{ route('statistik') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-xl sm:text-2xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-sitemap text-lg sm:text-xl text-emerald-400 group-hover:rotate-6 transition-transform"></i>
                                    <span>{{ $stats['jumlah_rt_rw'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">JUMLAH RT / RW</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Struktur Wilayah</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 4: Surat Masuk -->
                        <a href="{{ route('dokumen') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-inbox text-lg sm:text-xl text-emerald-400 group-hover:-rotate-6 transition-transform"></i>
                                    <span>{{ $stats['surat_masuk'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">SURAT MASUK</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Buku Agenda</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 5: Surat Keluar -->
                        <a href="{{ route('dokumen') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-paper-plane text-lg sm:text-xl text-emerald-400 group-hover:rotate-6 transition-transform"></i>
                                    <span>{{ $stats['surat_keluar'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">SURAT KELUAR</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Buku Keluar</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 6: Permohonan Surat -->
                        <a href="{{ route('surat.form') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-envelope-open-text text-lg sm:text-xl text-emerald-400 group-hover:rotate-6 transition-transform"></i>
                                    <span>{{ $stats['permohonan_surat'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">PERMOHONAN SURAT</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Ajukan Surat</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 7: Pengaduan Masyarakat -->
                        <a href="{{ route('pengaduan.form') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-bullhorn text-lg sm:text-xl text-emerald-400 group-hover:-rotate-6 transition-transform"></i>
                                    <span>{{ $stats['pengaduan_masyarakat'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">PENGADUAN MASYARAKAT</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Buat Lapor</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 8: Permohonan Diproses -->
                        <a href="{{ route('surat.track') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-spinner fa-spin text-lg sm:text-xl text-emerald-400"></i>
                                    <span>{{ $stats['permohonan_proses'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">SEDANG DIPROSES</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Cek Status</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                        <!-- Item 9: Permohonan Selesai -->
                        <a href="{{ route('surat.track') }}" class="group p-4 bg-emerald-900/35 hover:bg-emerald-800/50 backdrop-blur-md border border-emerald-500/20 hover:border-emerald-400/50 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col justify-between text-center space-y-2 relative overflow-hidden">
                            <div class="space-y-1">
                                <div class="text-2xl sm:text-3xl font-black text-emerald-300 tracking-tight flex items-center justify-center gap-1.5 group-hover:scale-105 transition-transform">
                                    <i class="fas fa-check-circle text-lg sm:text-xl text-emerald-400 group-hover:rotate-12 transition-transform"></i>
                                    <span>{{ $stats['permohonan_selesai'] }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider">PERMOHONAN SELESAI</p>
                            </div>
                            <div class="pt-1 flex items-center justify-center gap-1 text-[10px] font-bold text-emerald-300/80 group-hover:text-white transition-colors">
                                <span>Cek Resi</span>
                                <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </a>

                    </div>

                    <!-- ITEM 11: GRAFIK JUMLAH PELAYANAN -->
                    <div class="bg-emerald-950/60 backdrop-blur-md border border-emerald-500/20 rounded-3xl p-5 sm:p-6 space-y-4 shadow-xl relative overflow-hidden">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-b border-emerald-800/50 pb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-900/60 border border-emerald-500/30 text-emerald-300 flex items-center justify-center text-lg shrink-0">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <span class="text-[10px] font-extrabold text-emerald-400/90 uppercase tracking-widest">Item 11 Data Statistik</span>
                                    <h4 class="font-extrabold text-white text-sm sm:text-base">Grafik Jumlah Pelayanan Kandang Jati Kulon</h4>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-emerald-300/90 bg-emerald-900/60 px-3 py-1 rounded-full border border-emerald-700/50">
                                    Tahun {{ date('Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Responsive SVG Bar Chart -->
                        @php
                            $maxVal = max(array_values($stats['monthly']) ?: [1]);
                            if ($maxVal <= 0) $maxVal = 1;
                        @endphp
                        <div class="pt-2">
                            <div class="grid grid-cols-12 gap-1.5 sm:gap-3 items-end h-44 sm:h-52 pt-6 px-1 border-b border-emerald-800/50">
                                @foreach($stats['monthly'] as $mName => $mValue)
                                    @php
                                        $heightPercent = round(($mValue / $maxVal) * 100);
                                        if ($heightPercent < 8) $heightPercent = 8;
                                    @endphp
                                    <div class="flex flex-col items-center h-full justify-end group cursor-pointer relative">
                                        <!-- Tooltip on hover -->
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity absolute -top-8 bg-slate-900 text-emerald-300 text-[10px] font-black px-2 py-0.5 rounded shadow-lg border border-emerald-500/30 whitespace-nowrap z-20 pointer-events-none">
                                            {{ $mValue }} Pelayanan
                                        </div>

                                        <!-- Value Badge above bar -->
                                        <span class="text-[9px] sm:text-[10px] font-extrabold text-emerald-300/90 mb-1 group-hover:scale-105 transition-transform">
                                            {{ $mValue }}
                                        </span>

                                        <!-- Bar Element -->
                                        <div class="w-full max-w-[28px] sm:max-w-[36px] bg-gradient-to-t from-emerald-700/90 via-emerald-500/80 to-emerald-300/90 group-hover:from-emerald-600 group-hover:to-amber-300 rounded-t-md transition-all duration-300"
                                             style="height: {{ $heightPercent }}%;"></div>
                                        
                                        <!-- Month Name Label -->
                                        <span class="text-[9px] sm:text-[11px] font-bold text-emerald-200/80 uppercase tracking-wider mt-2 group-hover:text-white transition-colors">
                                            {{ $mName }}
                                        </span>
                                    </div>
                                @endforeach
                        </div>
                    </div>

                    <!-- ITEM 10: MODAL STATISTIK PELAYANAN PER BULAN -->
                    <div x-show="showMonthlyModal" x-cloak class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
                        <div @click.away="showMonthlyModal = false" class="bg-slate-900 rounded-3xl p-6 max-w-2xl w-full border border-emerald-500/30 shadow-2xl text-white space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-extrabold text-emerald-400 uppercase tracking-widest block">Item 10 Data Statistik</span>
                                        <h4 class="font-extrabold text-white text-base">Statistik Pelayanan Per Bulan</h4>
                                    </div>
                                </div>
                                <button @click="showMonthlyModal = false" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="bg-slate-950 text-emerald-300 uppercase tracking-wider border-b border-slate-800">
                                            <th class="py-2.5 px-4 font-extrabold">Bulan</th>
                                            <th class="py-2.5 px-4 font-extrabold text-center">Jumlah Pelayanan</th>
                                            <th class="py-2.5 px-4 font-extrabold text-right">Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800 text-slate-300 font-semibold">
                                        @php $sumVal = array_sum($stats['monthly']) ?: 1; @endphp
                                        @foreach($stats['monthly'] as $mName => $mValue)
                                            <tr class="hover:bg-emerald-950/40 transition-colors">
                                                <td class="py-2.5 px-4 font-bold text-white flex items-center gap-2">
                                                    <i class="fas fa-calendar-day text-emerald-400 text-xs"></i>
                                                    {{ $mName }}
                                                </td>
                                                <td class="py-2.5 px-4 text-center font-extrabold text-emerald-300">{{ number_format($mValue) }}</td>
                                                <td class="py-2.5 px-4 text-right text-slate-400 font-bold">{{ round(($mValue / $sumVal) * 100, 1) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-emerald-950 text-emerald-200 font-black border-t-2 border-emerald-600">
                                            <td class="py-3 px-4">TOTAL PELAYANAN ANNUALLY</td>
                                            <td class="py-3 px-4 text-center text-amber-300 text-sm">{{ number_format($sumVal) }}</td>
                                            <td class="py-3 px-4 text-right">100%</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="pt-2 flex justify-end">
                                <button @click="showMonthlyModal = false" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-500 text-slate-950 font-black text-xs rounded-xl shadow transition-colors">
                                    Tutup Rekapitulasi
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="absolute -right-10 -bottom-10 opacity-10 text-white text-9xl pointer-events-none">
                <i class="fas fa-laptop-code"></i>
            </div>
        </section>

        <!-- Berita & Sidebar Minimalis -->
        <section class="py-8 sm:py-12 bg-slate-50 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
                    
                    <!-- Left: Latest News -->
                    <div class="lg:col-span-8 space-y-4 sm:space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-2.5">
                            <h2 class="text-base sm:text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                                <i class="far fa-newspaper text-emerald-600"></i> Info Terkini
                            </h2>
                            <a href="{{ route('informasi') }}" class="text-[11px] sm:text-xs font-bold text-emerald-700 hover:underline flex items-center gap-1">
                                Lihat Semua <i class="fas fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>

                        <div class="grid grid-cols-2 gap-3 sm:gap-5">
                            @foreach(collect($latestNews ?? [])->take(2) as $news)
                                <article class="group bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                                    <div>
                                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                            <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            <span class="absolute top-2 right-2 bg-slate-900/85 text-white text-[8px] sm:text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-xs">
                                                {{ $news->category }}
                                            </span>
                                        </div>
                                        <div class="p-2.5 sm:p-4 space-y-1">
                                            <div class="text-[9px] sm:text-[11px] font-semibold text-slate-400 flex items-center gap-1">
                                                <i class="far fa-calendar text-emerald-500"></i> {{ \Carbon\Carbon::parse($news->published_at)->translatedFormat('d M Y') }}
                                            </div>
                                            <h3 class="font-extrabold text-xs sm:text-sm text-slate-900 leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2">
                                                <a href="{{ route('news.detail', $news->slug) }}">{{ $news->title }}</a>
                                            </h3>
                                            <p class="text-[11px] sm:text-xs text-slate-500 line-clamp-2 leading-relaxed hidden sm:block">{{ $news->summary }}</p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Sidebar -->
                    <aside class="lg:col-span-4 w-full flex flex-col justify-start">
                        
                        <!-- Maklumat Pelayanan -->
                        <div x-data="{ showMaklumatModal: false }" class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between items-center text-center w-full space-y-3.5 sm:space-y-4">
                            <div class="flex flex-col items-center text-center space-y-2 w-full">
                                <div class="w-11 h-11 sm:w-13 sm:h-13 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-2xl flex items-center justify-center text-xl sm:text-2xl shadow-2xs shrink-0">
                                    <i class="fas fa-file-signature"></i>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Maklumat Pelayanan</h3>
                                    <p class="text-xs text-slate-500 leading-relaxed max-w-sm mx-auto">
                                        Komitmen pelayanan publik sesuai standar secara profesional, transparan, dan bebas KKN.
                                    </p>
                                </div>
                            </div>
                            <button @click="showMaklumatModal = true" 
                                    class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs transition-all shadow-xs active:scale-95 group">
                                <span>Baca Maklumat Resmi</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </button>

                            <!-- Interactive Modal Popup Maklumat Pelayanan -->
                            <div x-show="showMaklumatModal" x-cloak class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
                                <div @click.away="showMaklumatModal = false" class="bg-white rounded-3xl p-5 sm:p-7 max-w-xl w-full space-y-4 shadow-2xl text-left border border-slate-100 relative max-h-[90vh] overflow-y-auto my-auto">
                                    <button @click="showMaklumatModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 transition-colors z-10">
                                        <i class="fas fa-times text-base"></i>
                                    </button>
                                    
                                    <div class="flex items-center gap-3 border-b border-slate-100 pb-3">
                                        <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg shrink-0">
                                            <i class="fas fa-file-signature"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-slate-900 text-base">Maklumat Pelayanan Resmi</h4>
                                            <p class="text-[11px] text-emerald-700 font-bold uppercase tracking-wider">DKUPP Kabupaten Probolinggo</p>
                                        </div>
                                    </div>

                                    @if(!empty($settings['maklumat_image']))
                                        <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs bg-slate-50">
                                            <img src="{{ $settings['maklumat_image'] }}" alt="Dokumen Maklumat Pelayanan" class="w-full h-auto object-contain max-h-[500px]">
                                        </div>
                                    @endif

                                    <div class="space-y-3 text-xs text-slate-600 leading-relaxed bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-100">
                                        <p class="font-extrabold text-slate-800 text-xs sm:text-sm text-center leading-snug">
                                            "{{ $settings['maklumat_text'] ?? 'DENGAN INI, KAMI MENYATAKAN SANGGUP MENYELENGGARAKAN PELAYANAN SESUAI STANDAR PELAYANAN YANG TELAH DITETAPKAN DAN APABILA TIDAK MENEPATI JANJI, KAMI SIAP MENERIMA SANKSI SESUAI PERATURAN PERUNDANG-UNDANGAN YANG BERLAKU.' }}"
                                        </p>
                                        <div class="pt-2 border-t border-slate-200 text-slate-500 space-y-0.5 text-center font-medium text-[11px]">
                                            <p>Kepala {{ $settings['agency_name'] ?? 'Dinas Koperasi, Usaha Mikro, Perdagangan dan Perindustrian' }}</p>
                                            <strong class="text-slate-900 block font-bold text-xs">{{ $settings['regency_name'] ?? 'Kabupaten Probolinggo' }}</strong>
                                        </div>
                                    </div>

                                    <div class="pt-1 flex justify-end">
                                        <button @click="showMaklumatModal = false" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-bold text-xs shadow transition-colors">
                                            Tutup Maklumat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </aside>
                </div>
            </div>

        <!-- Logo Instansi Mitra & Tautan Terkait -->
        <section class="py-8 sm:py-10 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
                <div class="text-center space-y-0.5">
                    <span class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-widest bg-emerald-50 px-2.5 py-0.5 rounded-full inline-block border border-emerald-200/60">Sinergi Instansi</span>
                    <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">Tautan & Logo Instansi Resmi</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 max-w-3xl mx-auto">
                    @foreach($relatedLinks ?? [] as $link)
                        <a href="{{ $link->url }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="group bg-white p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition-all duration-200 flex items-center gap-2.5 sm:gap-3 active:scale-98">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-slate-50 border border-slate-200/80 p-1 flex items-center justify-center shrink-0 group-hover:scale-105 group-hover:bg-emerald-50/50 group-hover:border-emerald-300 transition-all overflow-hidden">
                                <img src="{{ $link->image_url }}" 
                                     alt="{{ $link->title }}" 
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="font-extrabold text-slate-900 group-hover:text-emerald-700 text-xs sm:text-sm leading-tight block transition-colors line-clamp-1 sm:line-clamp-2">
                                    {{ $link->title }}
                                </span>
                                <span class="text-[9px] sm:text-[10px] text-slate-400 font-semibold group-hover:text-emerald-600 flex items-center gap-1 mt-0.5">
                                    <span>Website Resmi</span>
                                    <i class="fas fa-external-link-alt text-[8px]"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Unified Documentation Gallery -->
        <section class="py-10 bg-white border-t border-slate-100" x-data="{ activePhoto: null, activeVideo: null }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                
                <!-- Section Header Banner with View All Link -->
                <div class="bg-slate-50 p-4.5 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5 text-center sm:text-left">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-emerald-100/80 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                            <i class="fas fa-photo-video text-emerald-700"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-0.5 rounded-full bg-emerald-100/80 text-emerald-800 border border-emerald-200/60 inline-block">
                                Dokumentasi Visual Resmi
                            </span>
                            <h2 class="text-base sm:text-xl font-extrabold text-slate-900 mt-1">Galeri Foto & Video Kegiatan</h2>
                            <p class="text-xs text-slate-500 mt-0.5 hidden sm:block">Dokumentasi kegiatan pelayanan, bimbingan UMKM, tera ulang, dan acara resmi DKUPP.</p>
                        </div>
                    </div>

                    <a href="{{ route('galeri') }}" 
                       class="w-full sm:w-auto px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl sm:rounded-2xl font-extrabold text-xs shadow-xs transition-all flex items-center justify-center gap-2 hover:scale-105 shrink-0">
                        <span>Buka Semua Galeri</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Side-by-Side Layout -->
                <div class="grid grid-cols-2 gap-2.5 sm:gap-6 items-start">
                    
                    <!-- SISI KIRI: FOTO KEGIATAN -->
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                            <h3 class="font-extrabold text-slate-900 text-[11px] sm:text-sm flex items-center gap-1.5 truncate">
                                <i class="fas fa-camera text-emerald-600 text-xs sm:text-sm shrink-0"></i> 
                                <span class="truncate">Foto Kegiatan</span>
                            </h3>
                            <a href="{{ route('galeri') }}" class="text-[9px] sm:text-xs font-bold text-emerald-700 hover:underline flex items-center gap-0.5 shrink-0">
                                <span>Lihat Semua</span> <i class="fas fa-arrow-right text-[8px]"></i>
                            </a>
                        </div>

                        @if(isset($photoGalleries) && $photoGalleries->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                                @foreach(collect($photoGalleries)->take(2) as $img)
                                    <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-200 group flex flex-col justify-between cursor-pointer hover:-translate-y-0.5"
                                         @click="activePhoto = {{ json_encode(['title' => $img->title, 'caption' => $img->caption, 'file_path' => $img->file_path]) }}">
                                        <div class="aspect-[4/3] bg-slate-100 overflow-hidden relative">
                                            <img src="{{ $img->file_path }}" alt="{{ $img->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white p-1.5">
                                                <span class="px-2 py-0.5 bg-emerald-600/90 rounded-md text-[9px] font-extrabold shadow-sm flex items-center gap-1">
                                                    <i class="fas fa-search-plus"></i> Perbesar
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-2 sm:p-3.5 space-y-0.5">
                                            <h4 class="font-extrabold text-slate-900 text-[11px] sm:text-xs line-clamp-1 sm:line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">{{ $img->title }}</h4>
                                            @if($img->caption)
                                                <p class="text-[10px] sm:text-[11px] text-slate-500 line-clamp-1 leading-relaxed hidden sm:block">{{ $img->caption }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 sm:p-6 bg-slate-50 rounded-2xl border border-slate-200/80 text-center text-slate-400 text-[10px] sm:text-xs">
                                <i class="fas fa-images text-emerald-500 text-xl sm:text-2xl mb-1 block"></i>
                                Belum ada foto kegiatan.
                            </div>
                        @endif
                    </div>

                    <!-- SISI KANAN: VIDEO KEGIATAN -->
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200/80 pb-2">
                            <h3 class="font-extrabold text-slate-900 text-[11px] sm:text-sm flex items-center gap-1.5 truncate">
                                <i class="fab fa-youtube text-red-600 text-xs sm:text-sm shrink-0"></i> 
                                <span class="truncate">Video Kegiatan</span>
                            </h3>
                            <a href="{{ route('galeri') }}" class="text-[9px] sm:text-xs font-bold text-red-600 hover:underline flex items-center gap-0.5 shrink-0">
                                <span>Lihat Semua</span> <i class="fas fa-arrow-right text-[8px]"></i>
                            </a>
                        </div>

                        @if(isset($videos) && $videos->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                                @foreach(collect($videos)->take(2) as $vid)
                                    @php
                                        $ytId = '';
                                        if ($vid->youtube_url) {
                                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/))([\w-]{11})/', $vid->youtube_url, $matches);
                                            $ytId = $matches[1] ?? '';
                                        }
                                        $ytThumb = $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : '';
                                        $embedUrl = $ytId ? "https://www.youtube.com/embed/{$ytId}?autoplay=1&rel=0" : '';
                                    @endphp
                                    <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group cursor-pointer hover:-translate-y-0.5"
                                         @click="activeVideo = {{ json_encode(['title' => $vid->title, 'caption' => $vid->caption, 'embedUrl' => $embedUrl, 'file_path' => $vid->file_path, 'ytId' => $ytId, 'youtube_url' => $vid->youtube_url]) }}">
                                        <div class="relative aspect-[4/3] bg-slate-950 overflow-hidden">
                                            @if($ytThumb)
                                                <img src="{{ $ytThumb }}" alt="{{ $vid->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90 group-hover:opacity-100">
                                            @elseif($vid->file_path)
                                                <video src="{{ $vid->file_path }}" class="w-full h-full object-cover"></video>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-600 bg-slate-900">
                                                    <i class="fas fa-video text-xl sm:text-2xl"></i>
                                                </div>
                                            @endif

                                            <!-- Play Overlay Button -->
                                            <div class="absolute inset-0 bg-slate-950/40 group-hover:bg-slate-950/20 transition-all flex items-center justify-center">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-red-600 group-hover:bg-red-700 text-white flex items-center justify-center text-xs sm:text-sm shadow-md transition-all transform group-hover:scale-110">
                                                    <i class="fas fa-play ms-0.5"></i>
                                                </div>
                                            </div>

                                            <span class="absolute bottom-1.5 right-1.5 bg-slate-950/85 backdrop-blur-xs text-white text-[8px] sm:text-[9px] font-extrabold px-1.5 py-0.5 rounded flex items-center gap-1">
                                                <i class="fab fa-youtube text-red-500"></i> Video
                                            </span>
                                        </div>
                                        <div class="p-2 sm:p-3.5 space-y-0.5">
                                            <h4 class="font-extrabold text-slate-900 text-[11px] sm:text-xs line-clamp-1 sm:line-clamp-2 leading-snug group-hover:text-red-600 transition-colors">
                                                {{ $vid->title }}
                                            </h4>
                                            @if($vid->caption)
                                                <p class="text-[10px] sm:text-[11px] text-slate-500 line-clamp-1 leading-relaxed hidden sm:block">{{ $vid->caption }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 sm:p-6 bg-slate-50 rounded-2xl border border-slate-200/80 text-center text-slate-400 text-[10px] sm:text-xs">
                                <i class="fab fa-youtube text-red-500 text-xl sm:text-2xl mb-1 block"></i>
                                Belum ada video.
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Photo Lightbox Modal Popup -->
                <div x-show="activePhoto !== null" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="fixed inset-0 z-50 p-3 sm:p-6 flex items-center justify-center bg-slate-950/90 backdrop-blur-md">
                    
                    <div @click.away="activePhoto = null" class="bg-slate-900 rounded-3xl max-w-5xl w-full max-h-[92vh] border border-slate-800 shadow-2xl flex flex-col overflow-hidden relative">
                        <div class="p-4 sm:p-5 bg-slate-950 text-white flex items-center justify-between gap-4 border-b border-slate-800 shrink-0">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg shrink-0">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <div class="truncate">
                                    <span class="text-[10px] font-extrabold text-emerald-400 uppercase tracking-widest block">Dokumentasi Foto Kegiatan</span>
                                    <h3 class="font-extrabold text-xs sm:text-sm text-white truncate" x-text="activePhoto ? activePhoto.title : ''"></h3>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <a :href="activePhoto ? activePhoto.file_path : '#'" target="_blank" download class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center gap-1.5 transition-colors shadow-xs">
                                    <i class="fas fa-download text-[10px]"></i> <span class="hidden sm:inline">Unduh Foto</span>
                                </a>
                                <button @click="activePhoto = null" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex-grow bg-slate-950 p-3 sm:p-6 relative overflow-auto flex flex-col justify-center items-center">
                            <template x-if="activePhoto">
                                <img :src="activePhoto.file_path" :alt="activePhoto.title" class="max-h-[70vh] w-auto max-w-full rounded-2xl object-contain shadow-2xl border border-slate-800 mx-auto">
                            </template>
                            <div class="mt-4 text-center max-w-2xl px-2" x-show="activePhoto && activePhoto.caption">
                                <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed" x-text="activePhoto ? activePhoto.caption : ''"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Lightbox & Enlarged Player Modal Popup -->
                <div x-show="activeVideo !== null" 
                     x-cloak 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="fixed inset-0 z-50 p-3 sm:p-6 flex items-center justify-center bg-slate-950/90 backdrop-blur-md">
                    
                    <div @click.away="activeVideo = null" class="bg-slate-900 rounded-3xl max-w-5xl w-full max-h-[95vh] border border-slate-800 shadow-2xl flex flex-col overflow-hidden relative">
                        <!-- Modal Header -->
                        <div class="p-4 sm:p-5 bg-slate-950 text-white flex items-center justify-between gap-4 border-b border-slate-800 shrink-0">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-9 h-9 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center text-lg shrink-0">
                                    <i class="fab fa-youtube"></i>
                                </div>
                                <div class="truncate">
                                    <span class="text-[10px] font-extrabold text-red-400 uppercase tracking-widest block">Video Kegiatan Resmi DKUPP</span>
                                    <h3 class="font-extrabold text-xs sm:text-sm text-white truncate" x-text="activeVideo ? activeVideo.title : ''"></h3>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <template x-if="activeVideo && activeVideo.youtube_url">
                                    <a :href="activeVideo.youtube_url" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold text-xs flex items-center gap-1.5 transition-colors shadow-xs">
                                        <i class="fab fa-youtube"></i> <span class="hidden sm:inline">Buka di YouTube</span>
                                    </a>
                                </template>
                                <button @click="activeVideo = null" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Video Player Screen -->
                        <div class="flex-grow bg-slate-950 p-2 sm:p-6 relative overflow-auto flex flex-col justify-center items-center">
                            <div class="w-full max-w-4xl aspect-video rounded-2xl overflow-hidden shadow-2xl bg-black border border-slate-800">
                                <template x-if="activeVideo && activeVideo.embedUrl">
                                    <iframe :src="activeVideo.embedUrl" title="YouTube Video Player"
                                            class="w-full h-full border-0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                            allowfullscreen></iframe>
                                </template>
                                <template x-if="activeVideo && !activeVideo.embedUrl && activeVideo.file_path">
                                    <video :src="activeVideo.file_path" controls autoplay class="w-full h-full object-contain"></video>
                                </template>
                            </div>
                            <div class="mt-4 text-center max-w-2xl px-2" x-show="activeVideo && activeVideo.caption">
                                <p class="text-xs sm:text-sm text-slate-300 font-medium leading-relaxed" x-text="activeVideo ? activeVideo.caption : ''"></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer Resmi -->
    @include('partials.public_footer')

    @include('partials.tts_widget')
</body>
</html>