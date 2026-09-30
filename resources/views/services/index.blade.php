@extends('layouts.app')

@section('title', 'Standar Pelayanan Publik & SOP - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen" x-data="{ searchQuery: '', selectedCategory: 'all' }">

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
                            <span class="ml-1.5 text-emerald-400 font-semibold">Standar Pelayanan & SOP</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Repositori Dokumen Pelayanan Publik
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Standar Pelayanan & SOP Kelurahan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Pusat pedoman resmi Standar Operasional Prosedur (SOP) dan tata cara kepengurusan surat keterangan administrasi masyarakat di Kelurahan Sidomukti.
                </p>

                <!-- Search Input -->
                <div class="mt-5 max-w-md relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Cari jenis SOP (misal: SKU, SKTM, Domisili, Nikah)..." 
                        class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-700 bg-slate-800/80 text-white placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-inner">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8">
        
        <!-- Category Filter Pills -->
        @if(isset($categories) && $categories->count() > 0)
        <div class="mb-6 flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <button 
                type="button"
                @click="selectedCategory = 'all'"
                :class="selectedCategory === 'all' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 font-medium'"
                class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition cursor-pointer flex items-center gap-1.5">
                <span>Semua Kategori</span>
                <span :class="selectedCategory === 'all' ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-500'" class="px-1.5 py-0.5 rounded-full text-[10px]">
                    {{ $services->count() }}
                </span>
            </button>
            @foreach($categories as $category)
            <button 
                type="button"
                @click="selectedCategory = '{{ $category->id }}'"
                :class="selectedCategory == '{{ $category->id }}' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 font-medium'"
                class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition cursor-pointer flex items-center gap-1.5">
                <span>{{ $category->nama_kategori }}</span>
                <span :class="selectedCategory == '{{ $category->id }}' ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-500'" class="px-1.5 py-0.5 rounded-full text-[10px]">
                    {{ $category->services_count ?? $category->services->count() }}
                </span>
            </button>
            @endforeach
        </div>
        @endif

        <!-- SOP Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
            @forelse($services as $service)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md hover:border-emerald-400 transition-all duration-200 p-5 flex flex-col justify-between group h-full"
                 x-show="(selectedCategory === 'all' || selectedCategory == '{{ $service->kategori_layanan_id }}') && (searchQuery === '' || '{{ strtolower($service->title) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower($service->description ?? '') }}'.includes(searchQuery.toLowerCase()))"
                 x-transition>
                
                <div>
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 font-extrabold text-xs flex items-center justify-center border border-emerald-100">
                            {{ $service->order ?? $loop->iteration }}
                        </span>
                        
                        <!-- Dynamic Category Badge -->
                        @if($service->kategoriLayanan)
                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                                {{ $service->kategoriLayanan->nama_kategori }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-medium text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                                Layanan Publik
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('services.show', $service->slug) }}">
                        <h3 class="font-bold text-slate-800 text-sm leading-snug mb-2 group-hover:text-emerald-700 transition-colors line-clamp-2">
                            {{ $service->title }}
                        </h3>
                    </a>

                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-5">
                        {{ $service->description ?? 'Pedoman operasional standar pelayanan administrasi masyarakat kelurahan.' }}
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                    <a href="{{ route('services.show', $service->slug) }}" class="flex-grow py-2 px-3 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white font-bold text-xs rounded-xl text-center transition duration-150 flex items-center justify-center gap-1.5">
                        <span>Buka Dokumen</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @if($service->file_path && Storage::disk('public')->exists($service->file_path))
                        <a href="{{ route('services.download', $service->slug) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition" title="Unduh PDF">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    @endif
                </div>

            </div>
            @empty
            <div class="col-span-full py-16 text-center text-slate-400 bg-white rounded-2xl border border-slate-200 p-8">
                <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="font-bold text-slate-700 text-sm mb-1">Belum Ada Dokumen SOP</h3>
                <p class="text-xs text-slate-500">Dokumen standar pelayanan sedang dipersiapkan oleh administrator.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
