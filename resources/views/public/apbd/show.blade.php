@extends('layouts.app')

@section('title', $apbd->title . ' - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen pb-16">

    <!-- Page Header (Deep Dark Theme matching portal standard) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-10 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400 mb-6" aria-label="Breadcrumb">
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
                            <a href="{{ route('apbd.index') }}" class="ml-1.5 text-slate-400 hover:text-emerald-400 transition font-medium">Transparansi Anggaran</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold truncate max-w-[200px] sm:max-w-xs md:max-w-md">Tahun {{ $apbd->year }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">{{ $apbd->title }}</h1>
            <div class="flex flex-wrap items-center gap-3 text-slate-300 font-medium mb-6">
                <span class="flex items-center gap-1.5 bg-slate-800 border border-slate-700 px-3 py-1.5 rounded-lg text-sm shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Rilis: {{ \Carbon\Carbon::parse($apbd->date)->translatedFormat('d F Y') }}</span>
                <span class="flex items-center gap-1.5 bg-slate-800 border border-slate-700 px-3 py-1.5 rounded-lg text-sm shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Tahun Anggaran {{ $apbd->year }}</span>
            </div>
            @if($apbd->description)
                <p class="text-slate-300 text-base md:text-lg leading-relaxed max-w-4xl mt-6">{{ $apbd->description }}</p>
            @endif
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="space-y-8">
            <!-- 1. Pendapatan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-lg shadow-inner">1</div>
                    <h2 class="text-xl font-bold text-slate-800">Pendapatan Desa / Kelurahan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse min-w-[800px]">
                        <thead class="bg-emerald-600 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-5/12">Uraian / Akun</th>
                                <th class="px-6 py-4 font-semibold text-right w-2/12">Anggaran / Rencana</th>
                                <th class="px-6 py-4 font-semibold text-right w-2/12">Realisasi</th>
                                <th class="px-6 py-4 font-semibold text-right w-3/12">Lebih / Kurang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($pendapatanGrouped as $kategori => $items)
                                <tr class="bg-slate-50">
                                    <td colspan="4" class="px-6 py-3 font-bold text-emerald-700 uppercase tracking-wider text-xs">{{ $kategori ?: 'PENDAPATAN LAINNYA' }}</td>
                                </tr>
                                @foreach($items as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 pl-10 text-slate-700 font-medium">{{ $item->uraian }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->selisih, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                            @if($pendapatanItems->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada rincian pendapatan.</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-emerald-50 border-t border-emerald-200">
                            <tr>
                                <td class="px-6 py-4 font-extrabold text-slate-800 text-right uppercase tracking-wider text-sm">Total Pendapatan</td>
                                <td class="px-6 py-4 text-right font-extrabold text-emerald-700 font-mono text-base">Rp {{ number_format($totalPendapatanAnggaran, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-emerald-700 font-mono text-base">Rp {{ number_format($totalPendapatanRealisasi, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-emerald-700 font-mono text-base">Rp {{ number_format($totalPendapatanRealisasi - $totalPendapatanAnggaran, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 2. Belanja -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-black text-lg shadow-inner">2</div>
                    <h2 class="text-xl font-bold text-slate-800">Belanja Desa / Kelurahan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse min-w-[800px]">
                        <thead class="bg-rose-600 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-5/12">Uraian / Akun</th>
                                <th class="px-6 py-4 font-semibold text-right w-2/12">Anggaran / Rencana</th>
                                <th class="px-6 py-4 font-semibold text-right w-2/12">Realisasi</th>
                                <th class="px-6 py-4 font-semibold text-right w-3/12">Lebih / Kurang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($belanjaGrouped as $kategori => $items)
                                <tr class="bg-slate-50">
                                    <td colspan="4" class="px-6 py-3 font-bold text-rose-700 uppercase tracking-wider text-xs">{{ $kategori ?: 'BELANJA LAINNYA' }}</td>
                                </tr>
                                @foreach($items as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 pl-10 text-slate-700 font-medium">{{ $item->uraian }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->selisih, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                            @if($belanjaItems->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada rincian belanja.</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-rose-50 border-t border-rose-200">
                            <tr>
                                <td class="px-6 py-4 font-extrabold text-slate-800 text-right uppercase tracking-wider text-sm">Total Belanja</td>
                                <td class="px-6 py-4 text-right font-extrabold text-rose-700 font-mono text-base">Rp {{ number_format($totalBelanjaAnggaran, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-rose-700 font-mono text-base">Rp {{ number_format($totalBelanjaRealisasi, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-rose-700 font-mono text-base">Rp {{ number_format($totalBelanjaAnggaran - $totalBelanjaRealisasi, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- 3. Pembiayaan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-lg shadow-inner">3</div>
                    <h2 class="text-xl font-bold text-slate-800">Pembiayaan Desa / Kelurahan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse min-w-[800px]">
                        <thead class="bg-sky-600 text-white">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-5/12">Uraian / Akun</th>
                                <th class="px-6 py-4 font-semibold text-right w-2/12">Anggaran / Rencana</th>
                                <th class="px-6 py-4 font-semibold text-right w-2/12">Realisasi</th>
                                <th class="px-6 py-4 font-semibold text-right w-3/12">Lebih / Kurang</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($pembiayaanGrouped as $kategori => $items)
                                <tr class="bg-slate-50">
                                    <td colspan="4" class="px-6 py-3 font-bold text-sky-700 uppercase tracking-wider text-xs">{{ $kategori ?: 'PEMBIAYAAN LAINNYA' }}</td>
                                </tr>
                                @foreach($items as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 pl-10 text-slate-700 font-medium">{{ $item->uraian }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 font-mono">Rp {{ number_format($item->selisih, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                            @if($pembiayaanItems->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada rincian pembiayaan.</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-sky-50 border-t border-sky-200">
                            <tr>
                                <td class="px-6 py-4 font-extrabold text-slate-800 text-right uppercase tracking-wider text-sm">Pembiayaan Netto</td>
                                <td class="px-6 py-4 text-right font-extrabold text-sky-700 font-mono text-base">Rp {{ number_format($totalPembiayaanAnggaran, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-sky-700 font-mono text-base">Rp {{ number_format($totalPembiayaanRealisasi, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right font-extrabold text-sky-700 font-mono text-base"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <!-- Summary Dashboard (SILPA) -->
            <div class="bg-slate-800 rounded-2xl overflow-hidden shadow-lg border border-slate-700 mt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-700">
                    <div class="p-8 md:p-10 flex flex-col justify-center text-center relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-slate-700/50 rounded-full blur-2xl pointer-events-none"></div>
                        <p class="text-slate-400 uppercase tracking-widest text-sm font-bold mb-3 relative z-10">Surplus / Defisit Realisasi</p>
                        <h3 class="text-3xl md:text-4xl font-black {{ $surplusDefisitRealisasi >= 0 ? 'text-emerald-400' : 'text-rose-400' }} font-mono relative z-10">
                            Rp {{ number_format(abs($surplusDefisitRealisasi), 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-8 md:p-10 flex flex-col justify-center text-center relative overflow-hidden">
                        <div class="absolute -left-10 -top-10 w-40 h-40 bg-slate-700/50 rounded-full blur-2xl pointer-events-none"></div>
                        <p class="text-slate-400 uppercase tracking-widest text-sm font-bold mb-3 relative z-10">SILPA Tahun Berjalan</p>
                        <h3 class="text-3xl md:text-4xl font-black text-sky-400 font-mono relative z-10">
                            Rp {{ number_format($silpaRealisasi, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            @if($apbd->document)
            <!-- File Download Section -->
            <div class="mt-8 flex justify-center pb-8">
                <a href="{{ route('apbd.download', $apbd->id) }}" class="inline-flex items-center gap-4 px-8 py-4 bg-white border border-slate-200 hover:border-[#008c5f] hover:shadow-lg rounded-2xl group transition-all duration-300 w-full md:w-auto text-left relative overflow-hidden">
                    <div class="w-14 h-14 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-rose-100 transition-transform relative z-10">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2H7v-2h2V9h2v7zm4 0h-2v-7h2v7z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-lg font-bold text-slate-800 group-hover:text-[#008c5f] transition-colors">Unduh Dokumen Lengkap APBD</h4>
                        <p class="text-slate-500 text-sm mt-0.5">Format PDF - File Laporan Transparansi Tahun {{ $apbd->year }}</p>
                    </div>
                    <div class="ml-4 pl-4 border-l border-slate-200 text-slate-400 group-hover:text-[#008c5f] transition-colors hidden md:block relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
