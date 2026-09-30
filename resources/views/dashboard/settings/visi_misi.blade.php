@extends('layouts.admin')

@section('title', 'Kelola Visi & Misi Kelurahan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Visi & Misi Kelurahan</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola narasi Visi dan Misi resmi Kelurahan Sidomukti yang tampil pada halaman publik.</p>
    </div>
</div>



<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
    <form action="{{ route('dashboard.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold text-slate-800 uppercase tracking-wide mb-2">Teks Visi & Misi Kelurahan</label>
            <textarea name="visi_misi" id="visi_misi" rows="12" 
                      class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs text-sm leading-relaxed" 
                      placeholder="Tuliskan Visi dan Misi resmi kelurahan di sini...">{{ $settings['visi_misi'] ?? '' }}</textarea>
            <p class="text-xs text-slate-400 mt-1.5">Mendukung format paragraf dan poin-poin misi.</p>
        </div>

        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider py-3 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan Visi & Misi
            </button>
    </form>

    @if(!empty($settings['visi_misi']))
    <form action="{{ route('dashboard.settings.destroy-key', 'visi_misi') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus / mengosongkan Visi & Misi?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs uppercase tracking-wider py-3 px-5 rounded-xl border border-rose-200 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            Hapus / Kosongkan Visi & Misi
        </button>
    </form>
    @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#visi_misi',
                height: 450,
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
