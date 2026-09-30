@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Pengumuman</h2>
        <p class="text-slate-500 text-sm">Perbarui informasi teks berjalan.</p>
    </div>
    <a href="{{ route('dashboard.announcements.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Batal
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
    <form action="{{ route('dashboard.announcements.update', $announcement->id) }}" method="POST" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Ringkas <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required class="w-full px-4 py-3 rounded-lg border @error('title') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-bold text-slate-700 mb-2">Isi Pengumuman Lengkap</label>
                <textarea name="content" id="content" rows="4" class="w-full px-4 py-3 rounded-lg border @error('content') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">{{ old('content', $announcement->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center mt-4">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="is_active" class="ml-3 text-sm font-medium text-slate-700">Tampilkan pengumuman ini secara langsung (Aktif)</label>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Perbarui Pengumuman
            </button>
        </div>
    </form>
</div>
@endsection
