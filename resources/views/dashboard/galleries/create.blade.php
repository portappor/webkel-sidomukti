@extends('layouts.admin')

@section('title', 'Buat Album Galeri Baru')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Buat Album Foto Baru</h2>
        <p class="text-slate-500 text-sm">Tambahkan album dokumentasi kegiatan kelurahan beserta foto-fotonya.</p>
    </div>
    <a href="{{ route('dashboard.galleries.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Batal
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-4xl">
    <form action="{{ route('dashboard.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Judul Album -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Album Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus class="w-full px-4 py-3 rounded-xl border @error('title') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 transition shadow-sm" placeholder="Contoh: Pelatihan UMKM & Kewirausahaan Warga Sidomukti 2026">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori Album -->
            <div>
                <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Kegiatan <span class="text-red-500">*</span></label>
                <select name="category" id="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition bg-white shadow-sm">
                    <option value="pemerintahan" {{ old('category') == 'pemerintahan' ? 'selected' : '' }}>Pemerintahan & Pelayanan</option>
                    <option value="pembangunan" {{ old('category') == 'pembangunan' ? 'selected' : '' }}>Infrastruktur & Pembangunan</option>
                    <option value="pemberdayaan" {{ old('category') == 'pemberdayaan' ? 'selected' : '' }}>Pemberdayaan & UMKM</option>
                    <option value="keagamaan" {{ old('category') == 'keagamaan' ? 'selected' : '' }}>Keagamaan & Kemasyarakatan</option>
                    <option value="hut-ri" {{ old('category') == 'hut-ri' ? 'selected' : '' }}>Peringatan HUT RI & Seni Budaya</option>
                </select>
            </div>

            <!-- Tanggal Kegiatan -->
            <div>
                <label for="event_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pelaksanaan Kegiatan</label>
                <input type="date" name="event_date" id="event_date" value="{{ old('event_date', date('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">
            </div>

            <!-- Deskripsi Album -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi / Narasi Album Dokumentasi</label>
                <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm" placeholder="Jelaskan secara singkat latar belakang atau ringkasan kegiatan ini..."></textarea>
            </div>
        </div>

        <hr class="border-slate-200">

        <!-- Foto Sampul Album (Thumbnail) -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Foto Sampul (Thumbnail Album) <span class="text-red-500">*</span></label>
            <div class="space-y-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div id="coverPreviewContainer" class="hidden mb-2">
                    <p class="text-xs text-slate-500 mb-2 font-semibold">Preview Sampul Album (Rasio 16:9):</p>
                    <img id="previewCoverImg" src="" alt="Preview Sampul" class="max-h-56 aspect-video rounded-xl border border-slate-200 shadow-sm mx-auto object-cover">
                </div>
                <div class="flex items-center gap-3">
                    <input type="file" name="cover_image" id="cover_image" data-ratio="16:9" data-preview="#previewCoverImg" accept="image/*" onchange="document.getElementById('coverPreviewContainer').classList.remove('hidden')" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition cursor-pointer">
                    <button type="button" onclick="window.CropHelper && window.CropHelper.open(document.getElementById('cover_image'))" class="shrink-0 text-xs text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-bold px-3.5 py-2.5 rounded-xl border border-emerald-200 transition inline-flex items-center gap-1.5 shadow-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                        Potong (HD)
                    </button>
                </div>
                <div class="text-xs text-slate-400 text-center uppercase font-bold">atau link URL gambar</div>
                <input type="url" name="cover_image_url" id="cover_image_url" value="{{ old('cover_image_url') }}" placeholder="https://example.com/foto-sampul.jpg" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 text-xs font-mono">
            </div>
            @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="border-slate-200">

        <!-- Foto-Foto Isi Album (Multi-Upload) -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Unggah Foto-Foto Dokumentasi dalam Album</label>
            <p class="text-xs text-slate-500 mb-3">Anda dapat memilih **banyak foto sekaligus** dari komputer Anda.</p>
            
            <div class="space-y-4 bg-slate-50 p-5 rounded-xl border border-slate-200">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Opsi A: Upload Banyak Berkas Foto Sekaligus</label>
                    <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer">
                </div>

                <div class="text-xs text-slate-400 text-center uppercase font-bold">atau</div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Opsi B: Daftar Link/URL Foto (1 URL per baris)</label>
                    <textarea name="photo_urls" rows="3" placeholder="https://images.unsplash.com/photo-1&#10;https://images.unsplash.com/photo-2" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 text-xs font-mono"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Simpan Album Baru
            </button>
        </div>
    </form>
</div>
@endsection
