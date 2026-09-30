@extends('layouts.admin')

@section('title', 'Kelola Tugas dan Fungsi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Tugas dan Fungsi Kelurahan</h1>
        <p class="text-sm text-slate-500 mt-1">Editor untuk menjelaskan tugas pokok dan fungsi di Kelurahan Sidomukti.</p>
    </div>
</div>



<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
    <form action="{{ route('dashboard.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Tugas Fungsi dengan TinyMCE -->
        <div>
            <label for="tugas_fungsi" class="block text-sm font-bold text-slate-800 uppercase tracking-wide mb-2">Tugas & Fungsi</label>
            <textarea name="tugas_fungsi" id="tugas_fungsi" rows="14" 
                      class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-xs text-sm leading-relaxed" 
                      placeholder="Tuliskan tugas dan fungsi...">{{ $settings['tugas_fungsi'] ?? '' }}</textarea>
        </div>

        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider py-3 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Tugas & Fungsi
            </button>
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
                selector: '#tugas_fungsi',
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
