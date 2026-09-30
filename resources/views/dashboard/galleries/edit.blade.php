@extends('layouts.admin')

@section('title', 'Edit Album Galeri')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Album Foto</h2>
        <p class="text-slate-500 text-sm">Perbarui informasi album dan kelola foto-foto di dalamnya.</p>
    </div>
    <a href="{{ route('dashboard.galleries.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>



<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-4xl mb-8">
    <form action="{{ route('dashboard.galleries.update', $album->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Judul Album -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Album Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $album->title) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori Album -->
            <div>
                <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Kegiatan <span class="text-red-500">*</span></label>
                <select name="category" id="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition bg-white shadow-sm">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ old('category', $album->category) == $cat->slug || old('category', $album->category) == $cat->name ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Kegiatan -->
            <div>
                <label for="event_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pelaksanaan Kegiatan</label>
                <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $album->event_date ? $album->event_date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">
            </div>

            <!-- Deskripsi Album -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi / Narasi Album Dokumentasi</label>
                <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-green-500 transition shadow-sm">{{ old('description', $album->description) }}</textarea>
            </div>
        </div>

        <hr class="border-slate-200">

        <!-- Foto Sampul Album (Thumbnail) -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Foto Sampul (Thumbnail Album)</label>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <div class="w-28 h-20 bg-slate-900 rounded-lg overflow-hidden shrink-0 border border-slate-300">
                    <img id="editCoverPreview" src="{{ $album->cover_url }}" alt="Sampul Saat Ini" class="w-full h-full object-cover">
                </div>
                <div class="space-y-2 w-full">
                    <span class="text-xs text-slate-500 font-bold block">Ganti Sampul (Biarkan kosong jika tidak diubah):</span>
                    <div class="flex items-center gap-2">
                        <input type="file" name="cover_image" id="cover_image" data-ratio="16:9" data-preview="#editCoverPreview" accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition cursor-pointer">
                        <button type="button" onclick="const input = document.getElementById('cover_image'); if(input.files.length){ if(validateImageUpload(input)){ window.CropHelper.open(input); } } else { alert('Pilih foto sampul terlebih dahulu!'); }" class="shrink-0 text-xs text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-bold px-3 py-1.5 rounded-xl border border-emerald-200 transition inline-flex items-center gap-1 shadow-2xs cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                            Potong (HD)
                        </button>
                    </div>
                    <input type="url" name="cover_image_url" placeholder="Atau paste URL Foto Sampul Baru" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                </div>
            </div>
        </div>

        <hr class="border-slate-200">

        <!-- Tambah Foto Baru ke Album -->
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Tambah Foto Dokumentasi Baru ke Album</label>
            <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-200">
                <input type="file" name="photos[]" multiple accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer">
                <textarea name="photo_urls" rows="2" placeholder="Atau paste daftar URL foto tambahan (1 per baris)" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono"></textarea>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Kelola Foto yang Sudah Ada dalam Album -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 max-w-4xl">
    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Daftar Foto dalam Album Ini ({{ $album->photos->count() }} Foto)
    </h3>

    @if($album->photos->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($album->photos as $photo)
        <div class="group relative bg-slate-100 rounded-lg overflow-hidden border border-slate-200 aspect-square">
            <img src="{{ $photo->image_url }}" alt="Foto Album" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center p-2">
                <form action="{{ route('dashboard.galleries.photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg shadow transition flex items-center gap-1 text-xs font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-xs text-slate-500">Belum ada foto dalam album ini.</p>
    @endif
</div>
@endsection
