@extends('layouts.admin')

@section('title', 'Kelola Maklumat Pelayanan')

@section('content')
<div x-data="{ 
    showCreateModal: false, 
    showEditModal: false, 
    editItem: { id: '', title: '', is_active: 1, image_url: '' } 
}">
    <!-- Header Page -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Maklumat Pelayanan</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola peryataan Maklumat Pelayanan publik resmi Kelurahan Sidomukti yang ditampilkan di beranda utama.</p>
        </div>

        <button @click="showCreateModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Tambah Maklumat Baru
        </button>
    </div>

    

    <!-- Preview Active Maklumat Card -->
    @php
        $activeMaklumat = $maklumats->where('is_active', true)->first();
    @endphp

    @if($activeMaklumat)
    <div class="mb-8 bg-gradient-to-br from-emerald-900 via-slate-900 to-slate-950 rounded-2xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-emerald-800/40">
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <svg class="w-72 h-72 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 10h2v4h-2zm0 6h2v2h-2z"/></svg>
        </div>

        <div class="relative z-10">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Maklumat Aktif di Beranda
                </span>

                <button type="button" @click="editItem = {{ json_encode([
                    'id' => (string)$activeMaklumat->id,
                    'title' => (string)$activeMaklumat->title,
                    'is_active' => (bool)$activeMaklumat->is_active,
                    'image_url' => $activeMaklumat->image ? asset('storage/' . $activeMaklumat->image) : '',
                ]) }}; showEditModal = true;" class="text-xs bg-white/10 hover:bg-white/20 text-white font-semibold px-3 py-1.5 rounded-lg backdrop-blur-xs transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Maklumat Aktif
                </button>
            </div>

            <h2 class="text-xl sm:text-2xl font-black text-white mb-4 leading-snug">{{ $activeMaklumat->title }}</h2>

            @if($activeMaklumat->image)
            <div class="mt-2 w-full overflow-hidden rounded-xl border border-white/20 shadow-lg">
                <img src="{{ asset('storage/' . $activeMaklumat->image) }}" alt="Maklumat Pelayanan" class="w-full h-auto object-contain bg-slate-900/50">
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Daftar Semua Maklumat -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Daftar Maklumat Pelayanan</h3>
            <span class="text-xs text-slate-500 font-medium">Total: {{ $maklumats->count() }} Data</span>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($maklumats as $item)
            <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                <div class="space-y-1 max-w-2xl">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->is_active ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                            {{ $item->is_active ? 'Aktif di Beranda' : 'Non-Aktif' }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $item->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    <h4 class="font-bold text-slate-800 text-base leading-snug">{{ $item->title }}</h4>
                    <h4 class="font-bold text-slate-800 text-base leading-snug">{{ $item->title }}</h4>
                </div>

                <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                    <form action="{{ route('dashboard.maklumats.toggle', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-xl border transition cursor-pointer {{ $item->is_active ? 'bg-amber-50 text-amber-700 border-amber-200 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' }}">
                            {{ $item->is_active ? 'Set Non-Aktif' : 'Tampilkan di Beranda' }}
                        </button>
                    </form>

                    <button type="button" @click="editItem = {{ json_encode([
                        'id' => (string)$item->id,
                        'title' => (string)$item->title,
                        'is_active' => (bool)$item->is_active,
                        'image_url' => $item->image ? asset('storage/' . $item->image) : '',
                    ]) }}; showEditModal = true;" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition cursor-pointer" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>

                    @if($maklumats->count() > 1)
                    <form action="{{ route('dashboard.maklumats.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus maklumat ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 font-medium">
                Belum ada data Maklumat Pelayanan.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Tambah Maklumat Baru -->
    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="showCreateModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header Modal -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Maklumat Pelayanan</span>
                            </div>
                            <h3 class="text-base font-extrabold text-white tracking-tight mt-0.5">Tambah Maklumat Pelayanan Baru</h3>
                        </div>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Form Body -->
                <form action="{{ route('dashboard.maklumats.store') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Maklumat <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required placeholder="Contoh: Maklumat Pelayanan Kelurahan Sidomukti" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Foto / Poster Lampiran <span class="text-rose-500">*</span> <span class="text-xs font-medium text-slate-400">(Maks 5MB)</span></label>
                        <input type="file" name="image" accept="image/*" required onchange="validateImageUpload(this)" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50">
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_active" id="create_is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                        <label for="create_is_active" class="font-bold text-slate-700">Aktifkan & Tampilkan di Beranda Utama</label>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                        <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">Simpan Maklumat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Maklumat -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="showEditModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-xl my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Header Modal -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Maklumat Pelayanan</span>
                            </div>
                            <h3 class="text-base font-extrabold text-white tracking-tight mt-0.5">Edit Maklumat Pelayanan</h3>
                        </div>
                    </div>
                    <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Form Body -->
                <form :action="'/dashboard/maklumats/' + editItem.id" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Maklumat <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="editItem.title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Ganti Foto / Poster Lampiran (Opsional) <span class="text-xs font-medium text-slate-400">(Maks 5MB)</span></label>
                        <template x-if="editItem.image_url">
                            <div class="mb-2 flex items-center gap-3 bg-slate-50 p-2 rounded-xl border border-slate-200">
                                <img :src="editItem.image_url" alt="Preview" class="w-12 h-12 object-cover rounded-lg">
                                <span class="text-[11px] text-slate-500">Gambar saat ini</span>
                            </div>
                        </template>
                        <input type="file" name="image" accept="image/*" onchange="validateImageUpload(this)" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-slate-50">
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" :checked="editItem.is_active" class="rounded text-emerald-600 focus:ring-emerald-500">
                        <label for="edit_is_active" class="font-bold text-slate-700">Aktifkan & Tampilkan di Beranda Utama</label>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">Perbarui Maklumat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
