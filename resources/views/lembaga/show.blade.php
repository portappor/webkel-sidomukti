@extends('layouts.app')

@section('title', $lembaga->nama_lembaga . ' - Kelurahan Sidomukti')

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
                            <a href="{{ route('lembaga.index') }}" class="ml-1.5 text-slate-400 hover:text-emerald-400 transition font-medium">Lembaga Kemasyarakatan</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold truncate">{{ $lembaga->singkatan ?: $lembaga->nama_lembaga }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-3">
                {{ $lembaga->nama_lembaga }}
            </h1>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 md:py-12 max-w-6xl relative z-20 pb-16">

        <div class="bg-white p-6 md:p-8 border border-slate-200 shadow-sm mb-8 flex flex-col md:flex-row gap-8 items-start">
            <!-- Left Side Logo -->
            <div class="w-full md:w-1/4 flex-shrink-0 flex justify-center border border-slate-100 rounded p-2 bg-slate-50">
                @if($lembaga->foto_logo_url)
                    <img src="{{ $lembaga->foto_logo_url }}" alt="{{ $lembaga->nama_lembaga }}" class="w-full h-auto object-contain max-h-48">
                @else
                    <svg class="w-32 h-32 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                @endif
            </div>
            
            <!-- Right Side Information Table -->
            <div class="w-full md:w-3/4">
                <table class="w-full text-sm text-left">
                    <tbody>
                        <tr class="border-b border-slate-100">
                            <td class="py-3 font-semibold text-slate-600 w-1/3 md:w-1/4">Nama Lembaga</td>
                            <td class="py-3 px-2 text-slate-400 w-4">:</td>
                            <td class="py-3 text-slate-800">{{ $lembaga->nama_lembaga }}</td>
                        </tr>
                        <tr class="border-b border-slate-100">
                            <td class="py-3 font-semibold text-slate-600">Singkatan</td>
                            <td class="py-3 px-2 text-slate-400">:</td>
                            <td class="py-3 text-slate-800">{{ $lembaga->singkatan ?: '-' }}</td>
                        </tr>
                        <tr class="border-b border-slate-100">
                            <td class="py-3 font-semibold text-slate-600">Dasar Hukum / SK Pembentukan</td>
                            <td class="py-3 px-2 text-slate-400">:</td>
                            <td class="py-3 text-slate-800">{{ $lembaga->dasar_hukum ?: '-' }}</td>
                        </tr>
                        <tr class="border-b border-slate-100">
                            <td class="py-3 font-semibold text-slate-600">Alamat Kantor</td>
                            <td class="py-3 px-2 text-slate-400">:</td>
                            <td class="py-3 text-slate-800">{{ $lembaga->alamat_kantor ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Profil -->
            <div class="bg-white border border-emerald-600 shadow-sm">
                <div class="bg-emerald-600 px-4 py-3">
                    <h3 class="text-white font-semibold text-sm">Profil {{ $lembaga->singkatan ?: 'Lembaga' }}</h3>
                </div>
                <div class="p-4 md:p-6 text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $lembaga->profil ?: 'Belum ada profil.' }}
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="bg-white border border-emerald-600 shadow-sm">
                <div class="bg-emerald-600 px-4 py-3">
                    <h3 class="text-white font-semibold text-sm">Visi & Misi {{ $lembaga->singkatan ?: 'Lembaga' }}</h3>
                </div>
                <div class="p-4 md:p-6 text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $lembaga->visi_misi ?: 'Belum ada Visi & Misi.' }}
                </div>
            </div>

            <!-- Tupoksi -->
            <div class="bg-white border border-emerald-600 shadow-sm">
                <div class="bg-emerald-600 px-4 py-3">
                    <h3 class="text-white font-semibold text-sm">Tugas Pokok & Fungsi {{ $lembaga->singkatan ?: 'Lembaga' }}</h3>
                </div>
                <div class="p-4 md:p-6 text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $lembaga->tupoksi ?: 'Belum ada data tugas pokok dan fungsi.' }}
                </div>
            </div>

            <!-- Kepengurusan -->
            <div class="bg-white border border-emerald-600 shadow-sm">
                <div class="bg-emerald-600 px-4 py-3">
                    <h3 class="text-white font-semibold text-sm">Kepengurusan {{ $lembaga->singkatan ?: 'Lembaga' }}</h3>
                </div>
                <div class="p-4 md:p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-slate-200">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-600 bg-slate-50">
                                    <th class="px-4 py-3 font-semibold border-r border-slate-200">Nama</th>
                                    <th class="px-4 py-3 font-semibold border-r border-slate-200">Jabatan</th>
                                    <th class="px-4 py-3 font-semibold">Pendidikan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lembaga->members as $member)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-3 text-slate-800 border-r border-slate-200">{{ $member->nama }}</td>
                                    <td class="px-4 py-3 text-slate-600 border-r border-slate-200">{{ $member->jabatan ?: '-' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $member->pendidikan ?: '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-slate-800 border-r border-slate-200">-</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
