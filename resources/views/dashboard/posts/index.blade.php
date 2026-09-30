@extends('layouts.admin')

@section('title', 'Kelola Berita & Artikel')

@push('styles')
<style>
.tox-tinymce-aux {
    z-index: 99999 !important;
}
</style>
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Berita & Artikel</h2>
        <p class="text-slate-500 text-sm">Kelola publikasi berita, artikel, dan kabar terkini kelurahan.</p>
    </div>
    <button type="button" onclick="openCreatePostModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 text-sm cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tulis Berita Baru
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

<div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden p-2 sm:p-4">
    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase font-semibold border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4">Judul Artikel</th>
                    <th scope="col" class="px-6 py-4">Kategori</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4">Tanggal</th>
                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($posts as $post)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($post->thumbnail)
                                @if(Str::startsWith($post->thumbnail, ['http://', 'https://']))
                                    <img src="{{ $post->thumbnail }}" class="w-12 h-12 object-cover rounded-xl shadow-xs shrink-0" alt="Thumbnail">
                                @else
                                    <img src="{{ Storage::url($post->thumbnail) }}" class="w-12 h-12 object-cover rounded-xl shadow-xs shrink-0" alt="Thumbnail">
                                @endif
                            @else
                                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div>
                                <div class="font-bold text-slate-900 line-clamp-1 max-w-md">{{ $post->title }}</div>
                                <div class="text-xs text-slate-400 mt-0.5 line-clamp-1 max-w-md">{{ Str::limit(strip_tags(html_entity_decode($post->excerpt ?? $post->content)), 60) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $post->categoryRelation->name ?? $post->category ?? 'Umum' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($post->published_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                Dipublikasi
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-medium">
                        @php
                            $rawDateStr = $post->created_at ? $post->created_at->format('Y-m-d\TH:i') : '';
                            $formattedDateStr = $post->created_at ? $post->created_at->format('d M Y, H:i') : '-';
                        @endphp
                        <div class="relative inline-block text-left" id="date_cell_{{ $post->id }}">
                            <button type="button" 
                                    onclick="toggleInlineDatePicker({{ $post->id }})" 
                                    class="group inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 font-medium transition cursor-pointer border border-slate-200/80 hover:border-emerald-300"
                                    title="Klik untuk mengubah tanggal secara langsung">
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-emerald-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span id="date_text_{{ $post->id }}">{{ $formattedDateStr }}</span>
                                <svg class="w-3 h-3 text-slate-400 opacity-60 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>

                            <!-- Datetime Popover -->
                            <div id="date_picker_popover_{{ $post->id }}" class="hidden absolute right-0 sm:left-0 sm:right-auto top-full mt-1.5 z-40 bg-white p-3 rounded-2xl shadow-xl border border-slate-200/90 flex items-center gap-2 min-w-[280px]">
                                <input type="datetime-local" 
                                       id="date_input_{{ $post->id }}" 
                                       value="{{ $rawDateStr }}" 
                                       class="px-2.5 py-1.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 font-mono w-full bg-slate-50/50">
                                <button type="button" 
                                        onclick="saveInlineDate({{ $post->id }})" 
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-xl text-xs transition cursor-pointer shadow-xs shrink-0 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Simpan</span>
                                </button>
                                <button type="button" 
                                        onclick="toggleInlineDatePicker({{ $post->id }})" 
                                        class="p-1.5 hover:bg-slate-100 text-slate-400 hover:text-slate-600 rounded-lg text-xs transition cursor-pointer shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @php
                                $thumbUrl = '';
                                if ($post->thumbnail) {
                                    $thumbUrl = Str::startsWith($post->thumbnail, ['http://', 'https://']) ? $post->thumbnail : Storage::url($post->thumbnail);
                                }
                                $postData = json_encode([
                                    'id' => $post->id,
                                    'title' => $post->title,
                                    'category_id' => $post->category_id,
                                    'author' => $post->author ?? '',
                                    'excerpt' => $post->excerpt ?? '',
                                    'content' => $post->content ?? '',
                                    'status' => $post->published_at ? 'published' : 'draft',
                                    'created_at' => $rawDateStr,
                                    'thumbnail_url' => $thumbUrl,
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                            @endphp
                            <button type="button" 
                                    data-post="{{ $postData }}"
                                    onclick="handleEditPost(this)" 
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition cursor-pointer" 
                                    title="Edit Berita">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('dashboard.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition cursor-pointer" title="Hapus Berita">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Berita Baru -->
<div id="createPostModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-6xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[92vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Publikasi & Informasi</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Tulis Berita Baru</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('createPostModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form action="{{ route('dashboard.posts.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="_form_type" value="create">

            <!-- Form Body (Scrollable) -->
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <div>
                    <label for="create_title" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="create_title" value="{{ old('_form_type') === 'create' ? old('title') : '' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Masukkan judul artikel yang menarik...">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label for="create_category_id" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori</label>
                        <select name="category_id" id="create_category_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('_form_type') === 'create' && old('category_id') == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="create_author" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Penulis</label>
                        <input type="text" name="author" id="create_author" value="{{ old('_form_type') === 'create' ? old('author', auth()->user()->name ?? 'ADMIN') : (auth()->user()->name ?? 'ADMIN') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Nama Penulis">
                    </div>

                    <div>
                        <label for="create_created_at" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tanggal Publikasi</label>
                        <input type="datetime-local" name="created_at" id="create_created_at" value="{{ old('_form_type') === 'create' ? old('created_at', now()->format('Y-m-d\TH:i')) : now()->format('Y-m-d\TH:i') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-mono">
                    </div>

                    <div>
                        <label for="create_status" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Status Publikasi</label>
                        <select name="status" id="create_status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                            <option value="published" {{ (old('_form_type') === 'create' && old('status') === 'published') ? 'selected' : '' }}>Publikasikan Langsung</option>
                            <option value="draft" {{ (old('_form_type') === 'create' && old('status') === 'draft') ? 'selected' : '' }}>Simpan sebagai Draft</option>
                        </select>
                    </div>
                </div>



                <div>
                    <label for="create_content" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Isi Konten Berita (TinyMCE) <span class="text-red-500">*</span></label>
                    <textarea name="content" id="create_content" rows="10" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Tuliskan isi berita lengkap di sini...">{{ old('_form_type') === 'create' ? old('content') : '' }}</textarea>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Gambar Utama (Thumbnail)</label>
                    
                    <div class="mb-3 hidden" id="create_previewContainer">
                        <img id="create_previewThumbnail" src="" class="w-full h-40 object-cover rounded-xl border border-slate-200 shadow-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Berkas Foto (Cropper) <span class="font-medium text-slate-400">(Maks 5MB)</span></label>
                            <div class="flex items-center gap-2">
                                <input type="file" name="thumbnail" id="create_thumbnail" accept="image/*" onchange="if(validateImageUpload(this)){ if(this.files[0]){ document.getElementById('create_previewThumbnail').src = URL.createObjectURL(this.files[0]); document.getElementById('create_previewContainer').classList.remove('hidden'); } }" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                                <button type="button" onclick="const input = document.getElementById('create_thumbnail'); if(input.files.length){ if(validateImageUpload(input)){ window.CropHelper.open(input); } } else { alert('Pilih foto terlebih dahulu!'); }" class="px-3 py-2 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-200 text-xs font-bold transition shrink-0 flex items-center gap-1 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121m5.121-5.121l7-7"></path></svg>
                                    <span>Potong</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Atau Link URL Gambar (HTTP/HTTPS)</label>
                            <input type="url" name="thumbnail_url" id="create_thumbnail_url" value="{{ old('_form_type') === 'create' ? old('thumbnail_url') : '' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 font-mono" placeholder="https://example.com/gambar.jpg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('createPostModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Artikel</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Berita -->
<div id="editPostModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-6xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[92vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Publikasi & Informasi</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Edit Berita & Artikel</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('editPostModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form id="editPostForm" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')
            <input type="hidden" name="_form_type" value="edit">

            <!-- Form Body (Scrollable) -->
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <div>
                    <label for="edit_title" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Masukkan judul artikel yang menarik...">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <label for="edit_category_id" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori</label>
                        <select name="category_id" id="edit_category_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_author" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Penulis</label>
                        <input type="text" name="author" id="edit_author" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Nama Penulis">
                    </div>

                    <div>
                        <label for="edit_created_at" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Tanggal Publikasi</label>
                        <input type="datetime-local" name="created_at" id="edit_created_at" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white font-mono">
                    </div>

                    <div>
                        <label for="edit_status" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Status Publikasi</label>
                        <select name="status" id="edit_status" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                            <option value="published">Publikasikan Langsung</option>
                            <option value="draft">Simpan sebagai Draft</option>
                        </select>
                    </div>
                </div>



                <div>
                    <label for="edit_content" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Isi Konten Berita (TinyMCE) <span class="text-red-500">*</span></label>
                    <textarea name="content" id="edit_content" rows="10" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Tuliskan isi berita lengkap di sini..."></textarea>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Gambar Utama (Thumbnail)</label>
                    
                    <div class="mb-3 hidden" id="edit_previewContainer">
                        <img id="edit_previewThumbnail" src="" class="w-full h-40 object-cover rounded-xl border border-slate-200 shadow-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Berkas Foto Baru (Cropper) <span class="font-medium text-slate-400">(Maks 5MB)</span></label>
                            <div class="flex items-center gap-2">
                                <input type="file" name="thumbnail" id="edit_thumbnail" accept="image/*" onchange="if(validateImageUpload(this)){ if(this.files[0]){ document.getElementById('edit_previewThumbnail').src = URL.createObjectURL(this.files[0]); document.getElementById('edit_previewContainer').classList.remove('hidden'); } }" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                                <button type="button" onclick="const input = document.getElementById('edit_thumbnail'); if(input.files.length){ if(validateImageUpload(input)){ window.CropHelper.open(input); } } else { alert('Pilih foto terlebih dahulu!'); }" class="px-3 py-2 bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-200 text-xs font-bold transition shrink-0 flex items-center gap-1 cursor-pointer">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121m5.121-5.121l7-7"></path></svg>
                                    <span>Potong</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Atau Link URL Gambar Baru (HTTP/HTTPS)</label>
                            <input type="url" name="thumbnail_url" id="edit_thumbnail_url" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 font-mono" placeholder="https://example.com/gambar.jpg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('editPostModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        const card = modal.firstElementChild;
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
    const card = modal.firstElementChild;
    if (card) {
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function ensureTinyMCE(id, height, isFull, initialContent) {
    if (typeof tinymce === 'undefined') return;

    const val = (typeof initialContent === 'string') ? initialContent : '';
    const existing = tinymce.get(id);
    if (existing) {
        existing.setContent(val);
        existing.save();
        return;
    }

    tinymce.init({
        selector: '#' + id,
        height: height,
        menubar: isFull,
        plugins: isFull ? [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ] : [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview', 'searchreplace', 'visualblocks', 'code', 'wordcount'
        ],
        toolbar: isFull ? 
            'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media table | preview fullscreen code' :
            'undo redo | bold italic underline | bullist numlist | link removeformat code',
        content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #334155; }',
        branding: false,
        promotion: false,
        setup: function (editor) {
            editor.on('init', function () {
                editor.setContent(val);
            });
            editor.on('change keyup blur', function () {
                editor.save();
            });
        }
    });
}

function toggleInlineDatePicker(id) {
    const popover = document.getElementById('date_picker_popover_' + id);
    if (!popover) return;
    
    document.querySelectorAll('[id^="date_picker_popover_"]').forEach(el => {
        if (el.id !== 'date_picker_popover_' + id) {
            el.classList.add('hidden');
        }
    });

    popover.classList.toggle('hidden');
}

function saveInlineDate(id) {
    const input = document.getElementById('date_input_' + id);
    if (!input || !input.value) {
        alert('Pilih tanggal dan waktu terlebih dahulu!');
        return;
    }

    const textSpan = document.getElementById('date_text_' + id);
    const originalText = textSpan ? textSpan.innerText : '';
    if (textSpan) textSpan.innerText = 'Menyimpan...';

    fetch("{{ url('/dashboard/posts') }}/" + id + "/date", {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            _token: '{{ csrf_token() }}',
            date: input.value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (textSpan) textSpan.innerText = data.formatted_date;
            const popover = document.getElementById('date_picker_popover_' + id);
            if (popover) popover.classList.add('hidden');
            
            showQuickNotification('Tanggal berita berhasil diperbarui.');
        } else {
            alert(data.message || 'Gagal mengubah tanggal.');
            if (textSpan) textSpan.innerText = originalText;
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan koneksi saat mengubah tanggal.');
        if (textSpan) textSpan.innerText = originalText;
    });
}

function showQuickNotification(msg) {
    const toast = document.createElement('div');
    toast.className = 'fixed bottom-5 right-5 z-50 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-2xl text-xs font-bold flex items-center gap-2 border border-slate-700 animate-bounce';
    toast.innerHTML = `<svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <span>${msg}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}

function handleEditPost(btn) {
    try {
        const raw = btn.getAttribute('data-post');
        if (!raw) return;
        const data = JSON.parse(raw);
        openEditPostModal(
            data.id,
            data.title,
            data.category_id,
            data.author,
            data.excerpt,
            data.content,
            data.status,
            data.created_at,
            data.thumbnail_url
        );
    } catch (e) {
        console.error('Error handling edit post:', e);
    }
}

function openCreatePostModal() {
    document.getElementById('create_title').value = '';
    document.getElementById('create_category_id').value = '';
    document.getElementById('create_author').value = "{{ auth()->user()->name ?? 'ADMIN' }}";
    document.getElementById('create_status').value = 'published';
    const nowStr = new Date().toISOString().slice(0, 16);
    document.getElementById('create_created_at').value = nowStr;
    document.getElementById('create_content').value = '';
    document.getElementById('create_thumbnail').value = '';
    document.getElementById('create_thumbnail_url').value = '';
    const prevContainer = document.getElementById('create_previewContainer');
    if (prevContainer) prevContainer.classList.add('hidden');

    openModal('createPostModal');

    setTimeout(() => {
        ensureTinyMCE('create_content', 350, true, '');
    }, 150);
}

function openEditPostModal(id, title, categoryId, author, excerpt, content, status, createdAt, thumbnailUrl) {
    const form = document.getElementById('editPostForm');
    form.action = "{{ url('/dashboard/posts') }}/" + id;
    
    document.getElementById('edit_title').value = title || '';
    document.getElementById('edit_category_id').value = categoryId || '';
    document.getElementById('edit_author').value = author || '';
    document.getElementById('edit_status').value = status || 'published';
    document.getElementById('edit_created_at').value = createdAt || '';
    document.getElementById('edit_content').value = content || '';

    const previewContainer = document.getElementById('edit_previewContainer');
    const previewImg = document.getElementById('edit_previewThumbnail');
    if (thumbnailUrl) {
        previewImg.src = thumbnailUrl;
        previewContainer.classList.remove('hidden');
    } else {
        previewContainer.classList.add('hidden');
    }

    openModal('editPostModal');

    setTimeout(() => {
        ensureTinyMCE('edit_content', 350, true, content || '');
    }, 150);
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    @if(old('_form_type') === 'edit')
        openModal('editPostModal');
        setTimeout(() => {
            ensureTinyMCE('edit_content', 350, true, @json(old('content', '')));
        }, 150);
    @else
        openModal('createPostModal');
        setTimeout(() => {
            ensureTinyMCE('create_content', 350, true, @json(old('content', '')));
        }, 150);
    @endif
});
@endif
</script>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable().destroy();
    }
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        "pageLength": 10,
        "order": []
    });

    $(document).on('submit', 'form', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
    });
});
</script>
@endpush
@endsection
