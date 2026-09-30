@extends('layouts.admin')

@section('title', 'Kelola Pengumuman Teks Berjalan')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Pengumuman Teks Berjalan</h2>
        <p class="text-slate-500 text-sm">Kelola informasi penting yang akan tampil sebagai teks berjalan di beranda.</p>
    </div>
    <button type="button" onclick="openCreateAnnouncementModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 text-sm cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Pengumuman
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
                    <th scope="col" class="px-6 py-4">Isi Pengumuman</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4">Tanggal</th>
                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($announcements as $announcement)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $announcement->title }}</div>
                        <div class="text-xs text-slate-500 mt-1 max-w-md line-clamp-2">{{ $announcement->content }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($announcement->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Aktif Tayang
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-medium">
                        {{ $announcement->created_at ? $announcement->created_at->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @php
                                $annPayload = json_encode([
                                    'id' => $announcement->id,
                                    'title' => $announcement->title,
                                    'content' => $announcement->content ?? '',
                                    'is_active' => $announcement->is_active ? 1 : 0
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                            @endphp
                            <button type="button" 
                                    data-announcement="{{ $annPayload }}"
                                    onclick="handleEditAnnouncement(this)" 
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition cursor-pointer" 
                                    title="Edit Pengumuman">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('dashboard.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition cursor-pointer" title="Hapus Pengumuman">
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

<!-- Modal Tambah Pengumuman -->
<div id="createAnnouncementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4 sm:p-6">
    <div class="relative w-full max-w-xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.684A1.76 1.76 0 013 12V8a1.76 1.76 0 012.436-1.684l6.564-2.813V18.5l-6.564-2.816z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Pengumuman & Info</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Tambah Pengumuman Baru</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('createAnnouncementModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form action="{{ route('dashboard.announcements.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="_form_type" value="create">

            <!-- Form Body (Scrollable) -->
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <div>
                    <label for="create_title" class="block text-xs font-semibold text-slate-700 tracking-wide uppercase mb-1.5">
                        Judul Ringkas <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="create_title" value="{{ old('_form_type') === 'create' ? old('title') : '' }}" required 
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition outline-none shadow-2xs" 
                           placeholder="Contoh: INFO VAKSINASI KELURAHAN">
                </div>

                <div>
                    <label for="create_content" class="block text-xs font-semibold text-slate-700 tracking-wide uppercase mb-1.5">
                        Isi Pengumuman Lengkap
                    </label>
                    <textarea name="content" id="create_content" rows="4" 
                              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition outline-none shadow-2xs" 
                              placeholder="Contoh: Pelaksanaan vaksinasi akan diselenggarakan pada hari Minggu di Balai Desa.">{{ old('_form_type') === 'create' ? old('content') : '' }}</textarea>
                </div>

                <!-- Helper Callout Box -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 text-xs text-slate-600 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Gabungan antara Judul dan Isi Pengumuman ini akan dirangkai dan ditampilkan secara otomatis berurutan pada Running Text di halaman utama.</span>
                </div>

                <!-- Status Toggle Switch -->
                <div class="pt-1">
                    <label for="create_is_active" class="relative inline-flex items-center gap-3 cursor-pointer group select-none">
                        <div class="relative shrink-0">
                            <input type="checkbox" name="is_active" id="create_is_active" value="1" {{ (old('_form_type') === 'create' ? old('is_active', true) : true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-slate-800 group-hover:text-emerald-700 transition">Tampilkan Pengumuman (Aktif)</span>
                            <span class="text-xs text-slate-500">Pengumuman akan langsung ditayangkan pada running text beranda</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('createAnnouncementModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Pengumuman</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pengumuman -->
<div id="editAnnouncementModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4 sm:p-6">
    <div class="relative w-full max-w-xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Pengumuman & Info</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Edit Pengumuman</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('editAnnouncementModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form id="editAnnouncementForm" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')
            <input type="hidden" name="_form_type" value="edit">

            <!-- Form Body (Scrollable) -->
            <div class="p-6 space-y-5 overflow-y-auto flex-1">
                <div>
                    <label for="edit_title" class="block text-xs font-semibold text-slate-700 tracking-wide uppercase mb-1.5">
                        Judul Ringkas <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="edit_title" required 
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition outline-none shadow-2xs">
                </div>

                <div>
                    <label for="edit_content" class="block text-xs font-semibold text-slate-700 tracking-wide uppercase mb-1.5">
                        Isi Pengumuman Lengkap
                    </label>
                    <textarea name="content" id="edit_content" rows="4" 
                              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 text-sm placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition outline-none shadow-2xs"></textarea>
                </div>

                <!-- Helper Callout Box -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-3.5 text-xs text-slate-600 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Gabungan antara Judul dan Isi Pengumuman ini akan dirangkai dan ditampilkan secara otomatis berurutan pada Running Text di halaman utama.</span>
                </div>

                <!-- Status Toggle Switch -->
                <div class="pt-1">
                    <label for="edit_is_active" class="relative inline-flex items-center gap-3 cursor-pointer group select-none">
                        <div class="relative shrink-0">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-slate-800 group-hover:text-emerald-700 transition">Tampilkan Pengumuman (Aktif)</span>
                            <span class="text-xs text-slate-500">Pengumuman akan langsung ditayangkan pada running text beranda</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('editAnnouncementModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Perbarui Pengumuman</span>
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

function openCreateAnnouncementModal() {
    document.getElementById('create_title').value = '';
    document.getElementById('create_content').value = '';
    document.getElementById('create_is_active').checked = true;
    openModal('createAnnouncementModal');
}

function handleEditAnnouncement(btn) {
    try {
        const raw = btn.getAttribute('data-announcement');
        if (!raw) return;
        const data = JSON.parse(raw);
        openEditAnnouncementModal(data.id, data.title, data.content, data.is_active);
    } catch (e) {
        console.error('Error parsing announcement data:', e);
    }
}

function openEditAnnouncementModal(id, title, content, isActive) {
    const form = document.getElementById('editAnnouncementForm');
    form.action = "{{ url('/dashboard/announcements') }}/" + id;
    
    document.getElementById('edit_title').value = title || '';
    document.getElementById('edit_content').value = content || '';
    document.getElementById('edit_is_active').checked = Boolean(isActive);

    openModal('editAnnouncementModal');
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    @if(old('_form_type') === 'edit')
        openModal('editAnnouncementModal');
    @else
        openModal('createAnnouncementModal');
    @endif
});
@endif
</script>

@push('scripts')
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
});
</script>
@endpush
@endsection
