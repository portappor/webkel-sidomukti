@extends('layouts.admin')

@section('title', 'Kelola Album Galeri')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Album Galeri Foto</h2>
        <p class="text-slate-500 text-sm">Kelola album dan dokumentasi foto kegiatan kelurahan.</p>
    </div>
    <a href="{{ route('dashboard.galleries.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-green-600/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Album Baru
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6">
    <span class="block sm:inline font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    @if($albums->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($albums as $album)
                <div class="group relative bg-slate-50 rounded-xl overflow-hidden border border-slate-200 flex flex-col justify-between hover:shadow-md transition">
                    <div class="relative aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-extrabold uppercase tracking-wider rounded-lg border border-slate-700">
                                {{ ucfirst($album->category) }}
                            </span>
                        </div>
                        <div class="absolute bottom-3 right-3">
                            <span class="px-2 py-0.5 bg-slate-950/90 text-white text-[11px] font-bold rounded-md border border-slate-700">
                                {{ $album->photos_count }} Foto
                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 mb-1">{{ $album->title }}</h3>
                            <p class="text-xs text-slate-500 mb-3">
                                {{ $album->event_date ? $album->event_date->translatedFormat('d F Y') : $album->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between gap-2">
                            <a href="{{ route('galleries.show', $album->slug) }}" target="_blank" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Lihat Publik
                            </a>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('dashboard.galleries.edit', $album->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition" title="Edit Album">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <form action="{{ route('dashboard.galleries.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Hapus album {{ addslashes($album->title) }} beserta seluruh foto di dalamnya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Hapus Album">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($albums->hasPages())
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $albums->links() }}
        </div>
        @endif
    @else
        <div class="py-12 text-center flex flex-col items-center">
            <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Album Foto</h3>
            <p class="text-slate-500 mt-1">Silakan buat album dokumentasi pertama Anda.</p>
        </div>
    @endif
</div>
@endsection
