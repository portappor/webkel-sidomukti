@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Pengumuman</h2>
        <p class="text-slate-500 text-sm">Tambahkan pengumuman baru untuk ditampilkan di teks berjalan (running text).</p>
    </div>
    <a href="{{ route('dashboard.announcements.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Batal
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
    <form action="{{ route('dashboard.announcements.store') }}" method="POST" class="p-6 md:p-8">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Ringkas <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus class="w-full px-4 py-3 rounded-lg border @error('title') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="Contoh: INFO VAKSINASI">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-bold text-slate-700 mb-2">Isi Pengumuman Lengkap</label>
                <textarea name="content" id="content" rows="4" class="w-full px-4 py-3 rounded-lg border @error('content') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="Contoh: Jadwal Vaksinasi Massal akan diadakan pada hari Minggu, 20 Oktober 2026 di Balai Desa Sidomukti. Diharapkan kehadiran warga dengan membawa KTP.">{{ old('content') }}</textarea>
                <p class="text-xs text-slate-500 mt-1">Gabungan antara Judul dan Isi Pengumuman ini akan dirangkai dan ditampilkan berurutan di tulisan berjalan (Running Text).</p>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center mt-4">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-green-600 bg-slate-100 border-slate-300 rounded focus:ring-green-500 focus:ring-2">
                <label for="is_active" class="ml-3 text-sm font-medium text-slate-700">Tampilkan pengumuman ini secara langsung (Aktif)</label>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-md transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Pengumuman
            </button>
        </div>
    </form>
</div>
@endsection
