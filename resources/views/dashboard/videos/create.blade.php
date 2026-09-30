@extends('layouts.admin')

@section('title', 'Tambah Video Dokumentasi Baru')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Video Dokumentasi</h2>
        <p class="text-slate-500 text-sm">Tambahkan tayangan video baru dari YouTube ke halaman dokumentasi publik.</p>
    </div>
    <a href="{{ route('dashboard.videos.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Batal
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
    <form action="{{ route('dashboard.videos.store') }}" method="POST" onsubmit="return validateYoutubeUrlForm(this)" class="p-6 md:p-8 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Video Dokumentasi <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus class="w-full px-4 py-3 rounded-xl border @error('title') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 transition shadow-sm" placeholder="Contoh: Liputan Jalan Sehat & Semarak HUT RI 2026">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Kegiatan <span class="text-red-500">*</span></label>
                <select name="category" id="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition bg-white shadow-sm">
                    <option value="">-- Pilih Kategori Video --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ old('category') == $cat->slug || old('category') == $cat->name ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="duration" class="block text-sm font-bold text-slate-700 mb-2">Durasi Video (Opsional)</label>
                <input type="text" name="duration" id="duration" value="{{ old('duration') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm" placeholder="Contoh: 04:15">
            </div>
        </div>

        <div>
            <label for="youtube_url" class="block text-sm font-bold text-slate-700 mb-2">Link / URL Video YouTube <span class="text-red-500">*</span></label>
            <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url') }}" required onchange="validateYoutubeUrlInput(this)" class="w-full px-4 py-3 rounded-xl border @error('youtube_url') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 transition shadow-sm font-mono text-xs" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ atau https://youtu.be/...">
            @error('youtube_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-xs text-slate-500 mt-1.5">Sistem akan secara otomatis mengambil thumbnail gambar dan mengaktifkan pemutar video YouTube.</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat Video</label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm" placeholder="Tuliskan ringkasan isi video dokumentasi ini..."></textarea>
        </div>

        <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Simpan Video
            </button>
        </div>
    </form>
</div>

<script>
function validateYoutubeUrlInput(input) {
    const url = (input.value || '').trim();
    if (!url) return true;
    
    const isYoutube = /^(https?:\/\/)?(www\.|m\.)?(youtube\.com\/(watch\?.*v=|embed\/|v\/|shorts\/)|youtu\.be\/)[a-zA-Z0-9_-]+/i.test(url);
    if (!isYoutube) {
        input.value = '';
        alert('🚫 AKSES DITOLAK!\n\nLink \'' + url + '\' bukan merupakan link dari YOUTUBE.\n\nSistem secara otomatis menolak tautan selain dari YouTube. Silakan masukkan Link / URL Video resmi YouTube (contoh: https://www.youtube.com/watch?v=... atau https://youtu.be/...).');
        setTimeout(() => input.focus(), 100);
        return false;
    }
    return true;
}

function validateYoutubeUrlForm(form) {
    const input = form.querySelector('[name="youtube_url"]');
    if (input) {
        return validateYoutubeUrlInput(input);
    }
    return true;
}
</script>
@endsection
