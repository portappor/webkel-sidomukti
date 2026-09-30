@extends('layouts.app')

@section('title', 'Lembaga Kemasyarakatan - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold truncate">Lembaga Kemasyarakatan</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">Lembaga Kemasyarakatan</h1>
            <p class="text-slate-300 text-base md:text-lg leading-relaxed max-w-4xl">
                Daftar profil dan struktur kepengurusan Lembaga Kemasyarakatan Kelurahan Sidomukti yang berdedikasi melayani masyarakat.
            </p>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 md:py-12 max-w-7xl relative z-20 pb-16">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse min-w-[600px]">
                    <thead class="bg-slate-50 text-slate-600 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-bold w-1/2">Nama Lembaga</th>
                            <th class="px-6 py-4 font-bold w-1/2">Alamat Kantor</th>
                            <th class="px-6 py-4 font-bold text-center w-24">Logo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($lembagas as $lembaga)
                        <tr class="hover:bg-slate-50/50 transition group">
                            <td class="px-6 py-5">
                                <a href="{{ route('lembaga.show', $lembaga->id) }}" class="text-emerald-600 font-bold text-base hover:text-emerald-700 hover:underline block mb-1">
                                    {{ $lembaga->nama_lembaga }}
                                </a>
                                @if($lembaga->singkatan)
                                    <span class="inline-block px-2 py-0.5 bg-emerald-600 text-white text-[10px] font-bold rounded shadow-sm">
                                        {{ $lembaga->singkatan }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-slate-500 font-medium align-top pt-6">
                                {{ $lembaga->alamat_kantor ?: '-' }}
                            </td>
                            <td class="px-6 py-5 align-top">
                                <div class="w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center overflow-hidden mx-auto bg-slate-50">
                                    @if($lembaga->foto_logo_url)
                                        <img src="{{ $lembaga->foto_logo_url }}" alt="{{ $lembaga->nama_lembaga }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400 font-medium">
                                Belum ada data lembaga yang aktif.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
