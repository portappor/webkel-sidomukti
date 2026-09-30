@extends('layouts.admin')

@section('title', 'Kelola Album Foto')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Album Foto</h2>
        <p class="text-slate-500 text-sm">Kelola album dan dokumentasi foto kegiatan kelurahan.</p>
    </div>
    <button type="button" onclick="openCreateAlbumModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 text-sm cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Album Baru
    </button>
</div>



@if($errors->any())
<div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl relative mb-6 shadow-xs" role="alert">
    <div class="font-bold text-sm mb-1 flex items-center gap-2">
        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Perhatian:
    </div>
    <ul class="list-disc list-inside text-sm space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 p-6">
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
                                <button type="button" 
                                        onclick="openEditAlbumModal({{ $album->id }}, '{{ addslashes($album->title) }}', '{{ $album->category }}', '{{ $album->event_date ? $album->event_date->format('Y-m-d') : '' }}', '{{ addslashes($album->description ?? '') }}', '{{ addslashes($album->cover_url) }}')" 
                                        class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition cursor-pointer" title="Edit Album">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <form action="{{ route('dashboard.galleries.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Hapus album {{ addslashes($album->title) }} beserta seluruh foto di dalamnya?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer" title="Hapus Album">
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

<!-- Modal Buat Album Foto Baru -->
<div id="createAlbumModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-4xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            ALBUM FOTO & DOKUMENTASI
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Buat Album Foto Baru</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('createAlbumModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('dashboard.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" name="_form_type" value="create">

                <div>
                    <label for="create_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Album Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="create_title" value="{{ old('_form_type') === 'create' ? old('title') : '' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Pelatihan UMKM & Kewirausahaan Warga Sidomukti 2026">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="create_category" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                        <select name="category" id="create_category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                            <option value="">-- Pilih Kategori Album --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ (old('_form_type') === 'create' && old('category') == $cat->slug) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="create_event_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Pelaksanaan Kegiatan</label>
                        <input type="date" name="event_date" id="create_event_date" value="{{ old('_form_type') === 'create' ? old('event_date', date('Y-m-d')) : date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>
                </div>

                <div>
                    <label for="create_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Narasi Album Dokumentasi</label>
                    <textarea name="description" id="create_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Jelaskan secara singkat latar belakang atau ringkasan kegiatan ini...">{{ old('_form_type') === 'create' ? old('description') : '' }}</textarea>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Foto Sampul (Thumbnail Album) <span class="text-rose-500">*</span></label>
                    
                    <div class="mb-3 hidden" id="create_coverPreviewContainer">
                        <img id="create_previewCoverImg" src="" class="w-full h-44 object-cover rounded-xl border border-slate-200 shadow-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Upload Berkas Foto Sampul (Cropper 16:9) <span class="font-normal text-slate-400">(Maks 5MB)</span></label>
                            <div class="flex items-center gap-2">
                                <input type="file" name="cover_image" id="create_cover_image" data-ratio="16:9" accept="image/*" onchange="if(validateImageUpload(this)){ if(this.files[0]){ document.getElementById('create_previewCoverImg').src = URL.createObjectURL(this.files[0]); document.getElementById('create_coverPreviewContainer').classList.remove('hidden'); } }" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                                <button type="button" onclick="const input = document.getElementById('create_cover_image'); if(input.files.length){ if(validateImageUpload(input)){ window.CropHelper.open(input); } } else { alert('Pilih foto sampul terlebih dahulu!'); }" class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-200 text-xs font-bold transition shrink-0 flex items-center gap-1 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121m5.121-5.121l7-7"></path></svg>
                                    <span>Potong</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Atau Link URL Gambar Sampul (HTTP/HTTPS)</label>
                            <input type="url" name="cover_image_url" id="create_cover_image_url" value="{{ old('_form_type') === 'create' ? old('cover_image_url') : '' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono" placeholder="https://example.com/foto-sampul.jpg">
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Foto-Foto Dokumentasi dalam Album</label>
                    <p class="text-[10px] text-slate-400 mb-2">Anda dapat memilih <strong>banyak foto sekaligus</strong> dari perangkat Anda.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Upload Banyak Berkas Foto <span class="font-normal text-slate-400">(Maks 5MB)</span></label>
                            <input type="file" name="photos[]" id="create_photos" multiple accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Atau Daftar Link/URL Foto (1 URL per baris)</label>
                            <textarea name="photo_urls" id="create_photo_urls" rows="2" placeholder="https://images.unsplash.com/photo-1&#10;https://images.unsplash.com/photo-2" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-mono"></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('createAlbumModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Album Baru</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Album Foto -->
<div id="editAlbumModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-4xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            ALBUM FOTO & DOKUMENTASI
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Edit Album Foto</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('editAlbumModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="editAlbumForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form_type" value="edit">

                <div>
                    <label for="edit_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Album Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_category" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                        <select name="category" id="edit_category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_event_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Pelaksanaan Kegiatan</label>
                        <input type="date" name="event_date" id="edit_event_date" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                    </div>
                </div>

                <div>
                    <label for="edit_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Narasi Album Dokumentasi</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block text-xs font-bold text-slate-700 mb-2">Foto Sampul (Thumbnail Album)</label>
                    
                    <div class="mb-3 flex items-center gap-3" id="edit_coverPreviewContainer">
                        <img id="edit_previewCoverImg" src="" class="w-32 h-20 object-cover rounded-xl border border-slate-200 shadow-xs">
                        <span class="text-xs text-slate-400 font-medium">Foto Sampul Saat Ini</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Ganti Sampul dengan Upload Berkas Baru (Cropper 16:9) <span class="font-normal text-slate-400">(Maks 5MB)</span></label>
                            <div class="flex items-center gap-2">
                                <input type="file" name="cover_image" id="edit_cover_image" data-ratio="16:9" accept="image/*" onchange="if(validateImageUpload(this)){ if(this.files[0]){ document.getElementById('edit_previewCoverImg').src = URL.createObjectURL(this.files[0]); } }" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                                <button type="button" onclick="const input = document.getElementById('edit_cover_image'); if(input.files.length){ if(validateImageUpload(input)){ window.CropHelper.open(input); } } else { alert('Pilih foto sampul terlebih dahulu!'); }" class="px-3 py-1.5 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-200 text-xs font-bold transition shrink-0 flex items-center gap-1 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121m5.121-5.121l7-7"></path></svg>
                                    <span>Potong</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Atau Link URL Sampul Baru (HTTP/HTTPS)</label>
                            <input type="url" name="cover_image_url" id="edit_cover_image_url" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono" placeholder="https://example.com/foto-sampul.jpg">
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tambah Foto Dokumentasi Baru ke Album</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Upload Banyak Berkas Foto Baru <span class="font-normal text-slate-400">(Maks 5MB)</span></label>
                            <input type="file" name="photos[]" id="edit_photos" multiple accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Atau Daftar Link/URL Foto Tambahan (1 per baris)</label>
                            <textarea name="photo_urls" id="edit_photo_urls" rows="2" placeholder="https://images.unsplash.com/photo-1&#10;https://images.unsplash.com/photo-2" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-mono"></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('editAlbumModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        const card = modal.querySelector('.transform') || modal.firstElementChild;
        if (card) {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }
    }, 10);
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('opacity-0');
    const card = modal.querySelector('.transform') || modal.firstElementChild;
    if (card) {
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function openCreateAlbumModal() {
    document.getElementById('create_title').value = '';
    document.getElementById('create_category').value = '';
    document.getElementById('create_event_date').value = "{{ date('Y-m-d') }}";
    document.getElementById('create_description').value = '';
    document.getElementById('create_cover_image').value = '';
    document.getElementById('create_cover_image_url').value = '';
    document.getElementById('create_photos').value = '';
    document.getElementById('create_photo_urls').value = '';
    const prev = document.getElementById('create_coverPreviewContainer');
    if (prev) prev.classList.add('hidden');

    openModal('createAlbumModal');
}

function openEditAlbumModal(id, title, category, eventDate, description, coverUrl) {
    const form = document.getElementById('editAlbumForm');
    form.action = "{{ url('/dashboard/galleries') }}/" + id;
    
    document.getElementById('edit_title').value = title || '';
    document.getElementById('edit_category').value = category || '';
    document.getElementById('edit_event_date').value = eventDate || '';
    document.getElementById('edit_description').value = description || '';

    const previewContainer = document.getElementById('edit_coverPreviewContainer');
    const previewImg = document.getElementById('edit_previewCoverImg');
    if (coverUrl) {
        previewImg.src = coverUrl;
        previewContainer.classList.remove('hidden');
    } else {
        previewContainer.classList.add('hidden');
    }

    openModal('editAlbumModal');
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    @if(old('_form_type') === 'edit')
        openModal('editAlbumModal');
    @else
        openModal('createAlbumModal');
    @endif
});
@endif
</script>
@endsection
