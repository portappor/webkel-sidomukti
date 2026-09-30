@extends('layouts.admin')

@section('title', 'Kelola Sejarah Kelurahan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Sejarah Kelurahan</h1>
        <p class="text-sm text-slate-500 mt-1">Editor narasi asal-usul, riwayat pembentukan, dan latar sejarah Kelurahan Sidomukti.</p>
    </div>
</div>



<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
    <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateSejarahForm(this)" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Narasi Sejarah dengan TinyMCE -->
        <div>
            <label for="sejarah" class="block text-sm font-bold text-slate-800 uppercase tracking-wide mb-2">Narasi Sejarah Kelurahan</label>
            <textarea name="sejarah" id="sejarah" rows="14" 
                      class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs text-sm leading-relaxed" 
                      placeholder="Tuliskan cerita asal-usul dan sejarah perkembangan Kelurahan Sidomukti...">{{ $settings['sejarah'] ?? '' }}</textarea>
            <p class="text-xs text-slate-400 mt-1.5">Mendukung penulisan narasi panjang, pemformatan teks, dan dokumen sejarah wilayah.</p>
        </div>

        <!-- Section Upload / URL Foto Sejarah -->
        <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 space-y-4">
            <h3 class="font-bold text-slate-800 border-b border-slate-200 pb-2 text-sm uppercase tracking-wide">Foto Sejarah Kelurahan (Opsional)</h3>

            @if(!empty($settings['foto_sejarah']))
            <div class="mb-3">
                <p class="text-xs font-medium text-slate-500 mb-1.5">Foto Saat Ini / Preview:</p>
                @php
                    $sejarahImgSrc = \Illuminate\Support\Str::startsWith($settings['foto_sejarah'], ['http://', 'https://']) ? $settings['foto_sejarah'] : Storage::url($settings['foto_sejarah']);
                @endphp
                <div class="relative w-48 h-32 rounded-xl overflow-hidden border border-slate-200 shadow-sm group">
                    <img id="previewFotoSejarah" src="{{ $sejarahImgSrc }}" alt="Foto Sejarah" class="w-full h-full object-cover">
                </div>
            </div>
            @else
            <div id="previewContainerSejarah" class="mb-3 hidden">
                <p class="text-xs font-medium text-slate-500 mb-1.5">Preview Foto:</p>
                <div class="relative w-48 h-32 rounded-xl overflow-hidden border border-slate-200 shadow-sm group">
                    <img id="previewFotoSejarah" src="" alt="Foto Sejarah" class="w-full h-full object-cover">
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Opsi A: Upload Berkas Gambar <span class="text-[10px] font-medium text-slate-400">(Maks 5MB)</span></label>
                    <div class="flex items-center gap-2">
                        <input type="file" name="foto_sejarah" id="foto_sejarah" data-preview="#previewFotoSejarah" accept="image/*" onchange="if(validateImageUpload(this)){ const p=document.getElementById('previewContainerSejarah'); if(p) p.classList.remove('hidden'); }" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                        <button type="button" onclick="window.CropHelper && window.CropHelper.open(document.getElementById('foto_sejarah'))" class="shrink-0 text-xs text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-semibold px-3 py-2 rounded-xl border border-emerald-200 transition inline-flex items-center gap-1.5 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 0L4 4m5.121 5.121L4 14.121M14.121 9.121L19 4"/></svg>
                            Potong
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Opsi B: Atau Tempel Link/URL Gambar (HTTP/HTTPS)</label>
                    <input type="url" name="foto_sejarah_url" id="foto_sejarah_url" value="{{ old('foto_sejarah_url', \Illuminate\Support\Str::startsWith($settings['foto_sejarah'] ?? '', ['http://', 'https://']) ? $settings['foto_sejarah'] : '') }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono" placeholder="https://example.com/foto-sejarah.jpg">
                </div>
            </div>
            <p class="text-[11px] text-slate-500">Pilih salah satu metode: unggah berkas foto baru atau masukkan tautan URL gambar.</p>
        </div>

        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider py-3 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Sejarah & Foto
            </button>
    </form>

    @if(!empty($settings['sejarah']) || !empty($settings['foto_sejarah']))
    <form action="{{ route('dashboard.settings.destroy-key', 'sejarah') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus / mengosongkan Sejarah Kelurahan?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs uppercase tracking-wider py-3 px-5 rounded-xl border border-rose-200 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Hapus / Kosongkan Sejarah
        </button>
    </form>
    @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
    window.validateImageUrlInput = function(input) {
        const val = input.value ? input.value.trim() : '';
        if (!val) return true;

        const isImageUrl = /^https?:\/\/.+/i.test(val) && /\.(jpe?g|png|webp|gif|svg)($|\?|#)/i.test(val);
        if (!isImageUrl) {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            alert('🚫 AKSES DITOLAK!\n\nTautan URL foto \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan URL berkas Foto / Gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg) yang diperbolehkan!');
            return false;
        }
        return true;
    };

    window.validateSejarahForm = function(form) {
        const fileInput = form.querySelector('input[name="foto_sejarah"]');
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            if (!validateImageUpload(fileInput)) {
                return false;
            }
        }

        const urlInput = form.querySelector('input[name="foto_sejarah_url"]');
        if (urlInput && urlInput.value.trim() !== '') {
            if (!validateImageUrlInput(urlInput)) {
                return false;
            }
        }

        return true;
    };

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#sejarah',
                height: 500,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media table | preview fullscreen code',
                content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #334155; } ol { list-style-type: decimal; padding-left: 1.5rem; } ul { list-style-type: disc; padding-left: 1.5rem; } li { margin-bottom: 0.375rem; }',
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
