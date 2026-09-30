@extends('layouts.admin')

@section('title', 'Kelola Video Dokumentasi')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Video Dokumentasi</h2>
        <p class="text-slate-500 text-sm">Kelola tayangan video dokumentasi kegiatan kelurahan dari YouTube.</p>
    </div>
    <button type="button" onclick="openCreateVideoModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 text-sm cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Video Baru
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
    @if($videos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $video)
                <div class="group relative bg-slate-50 rounded-xl overflow-hidden border border-slate-200 flex flex-col justify-between hover:shadow-md transition">
                    <div class="relative aspect-video w-full overflow-hidden bg-slate-900">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-emerald-400 text-[10px] font-extrabold uppercase tracking-wider rounded-lg border border-slate-700">
                                {{ ucfirst($video->category) }}
                            </span>
                        </div>
                        @if($video->duration)
                        <div class="absolute bottom-3 right-3">
                            <span class="px-2 py-0.5 bg-slate-950/90 text-white text-[11px] font-bold rounded-md border border-slate-700">
                                {{ $video->duration }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 mb-1">{{ $video->title }}</h3>
                            <p class="text-xs text-slate-500 mb-3">
                                {{ $video->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between gap-2">
                            <a href="{{ $video->youtube_url }}" target="_blank" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                Buka YouTube
                            </a>

                            <div class="flex items-center gap-2">
                                <button type="button" 
                                        onclick="openEditVideoModal({{ $video->id }}, '{{ addslashes($video->title) }}', '{{ $video->category }}', '{{ addslashes($video->duration ?? '') }}', '{{ addslashes($video->youtube_url) }}', '{{ addslashes($video->description ?? '') }}')" 
                                        class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition cursor-pointer" title="Edit Video">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <form action="{{ route('dashboard.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Hapus video {{ addslashes($video->title) }}?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer" title="Hapus Video">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($videos->hasPages())
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $videos->links() }}
        </div>
        @endif
    @else
        <div class="py-12 text-center flex flex-col items-center">
            <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-slate-700">Belum Ada Video Dokumentasi</h3>
            <p class="text-slate-500 mt-1">Silakan tambahkan video dokumentasi pertama Anda.</p>
        </div>
    @endif
</div>

<!-- Modal Tambah Video Baru -->
<div id="createVideoModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-2xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Galeri & Media</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Tambah Video Dokumentasi Baru</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('createVideoModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form action="{{ route('dashboard.videos.store') }}" method="POST" onsubmit="return validateYoutubeUrlForm(this)" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="_form_type" value="create">

            <!-- Form Body (Scrollable) -->
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <div>
                    <label for="create_title" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Video Dokumentasi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="create_title" value="{{ old('_form_type') === 'create' ? old('title') : '' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Contoh: Liputan Jalan Sehat & Semarak HUT RI 2026">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="create_category" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori Kegiatan <span class="text-red-500">*</span></label>
                        <select name="category" id="create_category" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                            <option value="">-- Pilih Kategori Video --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ (old('_form_type') === 'create' && old('category') == $cat->slug) ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="create_duration" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Durasi Video (Opsional)</label>
                        <input type="text" name="duration" id="create_duration" value="{{ old('_form_type') === 'create' ? old('duration') : '' }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Contoh: 04:15">
                    </div>
                </div>

                <div>
                    <label for="create_youtube_url" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Link / URL Video YouTube <span class="text-red-500">*</span></label>
                    <input type="url" name="youtube_url" id="create_youtube_url" value="{{ old('_form_type') === 'create' ? old('youtube_url') : '' }}" required onchange="validateYoutubeUrlInput(this)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm font-mono" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ atau https://youtu.be/...">
                    <p class="text-[11px] text-slate-400 mt-1">Sistem akan secara otomatis mengambil thumbnail gambar dan mengaktifkan pemutar video YouTube.</p>
                </div>

                <div>
                    <label for="create_description" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deskripsi Singkat Video</label>
                    <textarea name="description" id="create_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm" placeholder="Tuliskan ringkasan isi video dokumentasi ini...">{{ old('_form_type') === 'create' ? old('description') : '' }}</textarea>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('createVideoModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Simpan Video</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Video -->
<div id="editVideoModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-2xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Galeri & Media</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Edit Video Dokumentasi</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('editVideoModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form id="editVideoForm" method="POST" onsubmit="return validateYoutubeUrlForm(this)" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')
            <input type="hidden" name="_form_type" value="edit">

            <!-- Form Body (Scrollable) -->
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <div>
                    <label for="edit_title" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Judul Video Dokumentasi <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_category" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Kategori Kegiatan <span class="text-red-500">*</span></label>
                        <select name="category" id="edit_category" required class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="edit_duration" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Durasi Video (Opsional)</label>
                        <input type="text" name="duration" id="edit_duration" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Contoh: 04:15">
                    </div>
                </div>

                <div>
                    <label for="edit_youtube_url" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Link / URL Video YouTube <span class="text-red-500">*</span></label>
                    <input type="url" name="youtube_url" id="edit_youtube_url" required onchange="validateYoutubeUrlInput(this)" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm font-mono">
                    <p class="text-[11px] text-slate-400 mt-1">Sistem akan secara otomatis mengambil thumbnail gambar dan mengaktifkan pemutar video YouTube.</p>
                </div>

                <div>
                    <label for="edit_description" class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Deskripsi Singkat Video</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 transition text-sm"></textarea>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('editVideoModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
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

function openCreateVideoModal() {
    document.getElementById('create_title').value = '';
    document.getElementById('create_category').value = '';
    document.getElementById('create_duration').value = '';
    document.getElementById('create_youtube_url').value = '';
    document.getElementById('create_description').value = '';

    openModal('createVideoModal');
}

function openEditVideoModal(id, title, category, duration, youtubeUrl, description) {
    const form = document.getElementById('editVideoForm');
    form.action = "{{ url('/dashboard/videos') }}/" + id;
    
    document.getElementById('edit_title').value = title || '';
    document.getElementById('edit_category').value = category || '';
    document.getElementById('edit_duration').value = duration || '';
    document.getElementById('edit_youtube_url').value = youtubeUrl || '';
    document.getElementById('edit_description').value = description || '';

    openModal('editVideoModal');
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    @if(old('_form_type') === 'edit')
        openModal('editVideoModal');
    @else
        openModal('createVideoModal');
    @endif
});
@endif
</script>
@endsection
