@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Berita</h2>
        <p class="text-slate-500 text-sm">Perbarui konten artikel.</p>
    </div>
    <a href="{{ route('dashboard.posts.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 border border-slate-300 rounded-lg shadow-sm bg-white hover:bg-slate-50 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Batal
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <form action="{{ route('dashboard.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (Main Content) -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required class="w-full px-4 py-3 rounded-lg border @error('title') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="Masukkan judul yang menarik...">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-3 rounded-lg border @error('category_id') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category_id', $post->category_id) == $cat->id || (!old('category_id') && !$post->category_id && $post->category == $cat->name)) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-bold text-slate-700 mb-2">Penulis</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $post->author ?? auth()->user()->name ?? '') }}" class="w-full px-4 py-3 rounded-lg border @error('author') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="Nama Penulis">
                        @error('author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-bold text-slate-700 mb-2">Ringkasan (Opsional)</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="w-full px-4 py-3 rounded-lg border @error('excerpt') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="Tuliskan ringkasan singkat artikel ini (maksimal 2-3 kalimat)...">{{ old('excerpt', $post->excerpt) }}</textarea>
                    <p class="text-xs text-slate-500 mt-1">Ringkasan akan ditampilkan di halaman daftar berita. Jika kosong, sistem akan mengambil dari isi konten.</p>
                    @error('excerpt')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-bold text-slate-700 mb-2">Isi Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="15" class="w-full px-4 py-3 rounded-lg border @error('content') border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column (Meta & Settings) -->
            <div class="space-y-6">
                <div class="bg-slate-50 p-5 rounded-lg border border-slate-200">
                    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-200 pb-2">Pengaturan Publikasi</h3>
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <option value="published" {{ (old('status') == 'published' || $post->published_at) ? 'selected' : '' }}>Dipublikasikan</option>
                            <option value="draft" {{ (old('status') == 'draft' || !$post->published_at) ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Perbarui Artikel
                        </button>
                    </div>
                </div>

                <div class="bg-slate-50 p-5 rounded-lg border border-slate-200">
                    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-200 pb-2">Gambar Utama (Thumbnail)</h3>
                    
                    @if($post->thumbnail)
                    <div class="mb-3">
                        <p class="text-xs text-slate-500 mb-2">Gambar saat ini / Preview:</p>
                        @php
                            $thumbSrc = \Illuminate\Support\Str::startsWith($post->thumbnail, ['http://', 'https://']) ? $post->thumbnail : Storage::url($post->thumbnail);
                        @endphp
                        <img id="previewThumbnail" src="{{ $thumbSrc }}" alt="Thumbnail" class="w-full h-36 object-cover rounded-lg border border-slate-200 shadow-sm">
                    </div>
                    @else
                    <div id="previewContainer" class="mb-3 hidden">
                        <p class="text-xs text-slate-500 mb-2">Preview Gambar:</p>
                        <img id="previewThumbnail" src="" alt="Thumbnail" class="w-full h-36 object-cover rounded-lg border border-slate-200 shadow-sm">
                    </div>
                    @endif

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Opsi A: Upload Berkas Gambar Baru</label>
                            <div class="flex items-center gap-2">
                                <input type="file" name="thumbnail" id="thumbnail" data-preview="#previewThumbnail" accept="image/*" onchange="if(validateImageUpload(this)){ const p=document.getElementById('previewContainer'); if(p) p.classList.remove('hidden'); }" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer">
                                <button type="button" onclick="window.CropHelper && window.CropHelper.open(document.getElementById('thumbnail'))" class="shrink-0 text-xs text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-semibold px-3 py-2 rounded-xl border border-emerald-200 transition inline-flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                                    Potong
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Opsi B: Atau Tempel Link/URL Gambar (HTTP/HTTPS)</label>
                            <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', \Illuminate\Support\Str::startsWith($post->thumbnail, ['http://', 'https://']) ? $post->thumbnail : '') }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 font-mono" placeholder="https://example.com/gambar.jpg">
                        </div>
                        @error('thumbnail')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('thumbnail_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#content',
                height: 500,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media table | preview fullscreen code',
                content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #334155; }',
                branding: false,
                promotion: false,
                setup: function (editor) {
                    editor.on('change keyup blur', function () {
                        editor.save();
                    });
                }
            });
        }
    });
</script>
@endpush
