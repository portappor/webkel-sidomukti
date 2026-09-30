@props(['yearGroups' => [], 'categoryTitle' => 'Dokumen'])

<div class="mb-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg sm:text-xl font-extrabold text-slate-800 tracking-tight">Pilih Tahun Arsip Dokumen</h3>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Silakan pilih folder tahun untuk melihat daftar berkas {{ $categoryTitle }}.</p>
        </div>
        <div class="hidden sm:flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200/60">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>{{ count($yearGroups) }} Periode Tahun</span>
        </div>
    </div>

    @if(count($yearGroups) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($yearGroups as $group)
                <a href="{{ $group['url'] }}" 
                   class="group relative bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-emerald-500/60 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    <!-- Top subtle accent bar -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div>
                        <!-- Folder Icon & Arrow Badge -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-13 h-13 rounded-2xl bg-amber-50 group-hover:bg-emerald-600 text-amber-500 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-2xs border border-amber-200/60 group-hover:border-emerald-500">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-emerald-50 text-slate-400 group-hover:text-emerald-600 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>

                        <!-- Year Label -->
                        <div class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 mb-0.5">Folder Arsip</div>
                        <h4 class="text-2xl font-extrabold text-slate-800 group-hover:text-emerald-700 transition-colors">
                            Tahun {{ $group['year'] }}
                        </h4>
                    </div>

                    <!-- Bottom Count Pill -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 group-hover:bg-emerald-50 text-slate-600 group-hover:text-emerald-700 font-bold text-xs rounded-full border border-slate-200/80 group-hover:border-emerald-200 transition-colors">
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>{{ $group['count'] }} Berkas</span>
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400 group-hover:text-emerald-600 transition-colors">Lihat Berkas →</span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
            <h4 class="text-base font-bold text-slate-700">Belum Ada Folder Arsip</h4>
            <p class="text-slate-500 text-xs mt-1 max-w-sm mx-auto">Dokumen untuk kategori ini belum tersedia atau sedang dalam proses pengarsipan.</p>
        </div>
    @endif
</div>
