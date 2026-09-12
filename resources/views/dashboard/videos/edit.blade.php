@extends('layouts.admin')

@section('title', 'Edit Video Dokumentasi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Video Dokumentasi</h2>
        <p class="text-slate-500 text-sm">Perbarui informasi atau link tayangan video dokumentasi.</p>
    </div>
    <a href="{{ route('dashboard.videos.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
    <form action="{{ route('dashboard.videos.update', $video->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Video Dokumentasi <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Kegiatan <span class="text-red-500">*</span></label>
                <select name="category" id="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition bg-white shadow-sm">
                    <option value="pemerintahan" {{ old('category', $video->category) == 'pemerintahan' ? 'selected' : '' }}>Pemerintahan & Pelayanan</option>
                    <option value="pembangunan" {{ old('category', $video->category) == 'pembangunan' ? 'selected' : '' }}>Infrastruktur & Pembangunan</option>
                    <option value="pemberdayaan" {{ old('category', $video->category) == 'pemberdayaan' ? 'selected' : '' }}>Pemberdayaan & UMKM</option>
                    <option value="keagamaan" {{ old('category', $video->category) == 'keagamaan' ? 'selected' : '' }}>Keagamaan & Kemasyarakatan</option>
                    <option value="hut-ri" {{ old('category', $video->category) == 'hut-ri' ? 'selected' : '' }}>Peringatan HUT RI & Seni Budaya</option>
                </select>
            </div>

            <div>
                <label for="duration" class="block text-sm font-bold text-slate-700 mb-2">Durasi Video (Opsional)</label>
                <input type="text" name="duration" id="duration" value="{{ old('duration', $video->duration) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">
            </div>
        </div>

        <div>
            <label for="youtube_url" class="block text-sm font-bold text-slate-700 mb-2">Link / URL Video YouTube <span class="text-red-500">*</span></label>
            <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm font-mono text-xs">
            @error('youtube_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat Video</label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">{{ old('description', $video->description) }}</textarea>
        </div>

        <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
