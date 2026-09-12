@extends('layouts.admin')

@section('title', 'Kelola & Unggah Dokumen PDF')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4" x-data="{ uploadModal: false }">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola & Unggah Dokumen PDF</h1>
        <p class="text-sm text-slate-500 mt-1">Manajemen arsip dokumen resmi kelurahan (Musrenbang, Renstra & Renja, SK Kelembagaan).</p>
    </div>

    <button @click="uploadModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
        + Unggah Dokumen PDF
    </button>

    <!-- Modal Form Unggah Dokumen PDF -->
    <div x-show="uploadModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="uploadModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs"
         style="display: none;">
        
        <div @click.away="uploadModal = false" class="relative max-w-lg w-full bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
            <div class="p-5 bg-slate-900 text-white flex items-center justify-between">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    Unggah Berkas PDF Baru
                </h3>
                <button @click="uploadModal = false" class="text-slate-400 hover:text-white transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('dashboard.documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                <div>
                    <label for="title" class="block text-xs font-bold text-slate-700 mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Contoh: Berita Acara Musrenbang 2026">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="category" class="block text-xs font-bold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" id="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition bg-white">
                            <option value="musrenbang">Musrenbang</option>
                            <option value="renstra_renja">Renstra & Renja</option>
                            <option value="sk_kelembagaan">SK Kelembagaan</option>
                        </select>
                    </div>

                    <div>
                        <label for="published_date" class="block text-xs font-bold text-slate-700 mb-1">Tanggal Dokumen</label>
                        <input type="date" name="published_date" id="published_date" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                    </div>
                </div>

                <div>
                    <label for="organization" class="block text-xs font-bold text-slate-700 mb-1">Organisasi / Lembaga (Opsional)</label>
                    <input type="text" name="organization" id="organization" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Contoh: RT / RW, TP-PKK, LPMK">
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Ringkasan isi dokumen..."></textarea>
                </div>

                <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 bg-slate-50 space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Opsi A: Upload Berkas PDF (Maks. 10 MB)</label>
                        <input type="file" name="document_file" id="document_file" accept=".pdf,application/pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer">
                    </div>

                    <div class="text-[10px] text-slate-400 text-center font-bold uppercase">atau link tautan online</div>

                    <div>
                        <input type="url" name="file_url" id="file_url" placeholder="https://example.com/dokumen.pdf" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2">
                    <button type="button" @click="uploadModal = false" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">Unggah Berkas</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6">
    <span class="block sm:inline font-medium text-xs">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6">
    <span class="block sm:inline font-medium text-xs">{{ session('error') }}</span>
</div>
@endif

<!-- Filter Kategori Tabs -->
<div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-3">
    <a href="{{ route('dashboard.documents.index', ['category' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $categoryFilter === 'all' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Semua Dokumen
    </a>
    <a href="{{ route('dashboard.documents.index', ['category' => 'musrenbang']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $categoryFilter === 'musrenbang' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Musrenbang
    </a>
    <a href="{{ route('dashboard.documents.index', ['category' => 'renstra_renja']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $categoryFilter === 'renstra_renja' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Renstra & Renja
    </a>
    <a href="{{ route('dashboard.documents.index', ['category' => 'sk_kelembagaan']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $categoryFilter === 'sk_kelembagaan' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        SK Kelembagaan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    @forelse($documents as $doc)
    <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 hover:shadow-md transition flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3">
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                    {{ $doc->category_label }}
                </span>
                <span class="text-xs font-mono text-slate-400 font-semibold">{{ $doc->file_size }}</span>
            </div>
            <h3 class="font-bold text-slate-800 text-sm mb-1.5 leading-snug line-clamp-2">{{ $doc->title }}</h3>
            <p class="text-xs text-slate-500 line-clamp-2 mb-4 leading-relaxed">{{ $doc->description }}</p>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-[11px] text-slate-400 font-medium">
                {{ $doc->published_date ? $doc->published_date->translatedFormat('d M Y') : $doc->created_at->translatedFormat('d M Y') }}
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.documents.download', $doc->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-lg text-xs font-bold transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    PDF
                </a>

                <form action="{{ route('dashboard.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen PDF {{ addslashes($doc->title) }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition" title="Hapus Dokumen">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center text-slate-400 font-medium bg-white rounded-2xl border border-slate-200">
        Tidak ada dokumen ditemukan untuk kategori ini.
    </div>
    @endforelse
</div>

@if($documents->hasPages())
<div class="mt-6">
    {{ $documents->links() }}
</div>
@endif

@endsection
