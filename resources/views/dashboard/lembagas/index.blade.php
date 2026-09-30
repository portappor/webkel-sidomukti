@extends('layouts.admin')

@section('title', 'Kelola Lembaga Kemasyarakatan')

@section('content')
<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Lembaga Kemasyarakatan</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen profil dan struktur pengurus lembaga kemasyarakatan kelurahan.</p>
        </div>

        <a href="{{ route('dashboard.lembagas.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Tambah Lembaga Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabel Lembaga -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Nama Lembaga</th>
                        <th class="px-6 py-4">Singkatan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lembagas as $lembaga)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ $lembaga->nama_lembaga }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold">{{ $lembaga->singkatan ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($lembaga->status)
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold border border-emerald-200">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold border border-rose-200">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('dashboard.lembagas.edit', $lembaga->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors" title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('dashboard.lembagas.destroy', $lembaga->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus lembaga ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-colors" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="font-medium text-slate-500">Belum ada data lembaga kemasyarakatan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
