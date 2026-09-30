@extends('layouts.admin')

@section('title', 'Kelola Agenda Kegiatan')

@section('content')
<div x-data="{ 
    showModal: false, 
    editModal: false,
    createImagePreview: null,
    editImagePreview: null,
    createImageError: false,
    editImageError: false,
    createImageErrorMsg: '',
    editImageErrorMsg: '',
    editAgenda: { id: '', title: '', date: '', end_date: '', time: '', end_time: '', location: '', organizer: '', description: '', image_url: '' },
    validateFile(event, type) {
        const file = event.target.files[0];
        if (!file) {
            if (type === 'create') { this.createImagePreview = null; this.createImageError = false; }
            else { this.editImagePreview = null; this.editImageError = false; }
            return;
        }

        if (window.validateImageUpload && !window.validateImageUpload(event.target, null, 'Pilih Berkas Foto', 2)) {
            if (type === 'create') {
                this.createImagePreview = null;
                this.createImageError = true;
                this.createImageErrorMsg = 'AKSES DITOLAK! Silakan pilih file foto/gambar yang valid (maksimal 2MB).';
            } else {
                this.editImagePreview = null;
                this.editImageError = true;
                this.editImageErrorMsg = 'AKSES DITOLAK! Silakan pilih file foto/gambar yang valid (maksimal 2MB).';
            }
            return;
        }

        if (type === 'create') {
            this.createImageError = false;
            this.createImageErrorMsg = '';
            this.createImagePreview = URL.createObjectURL(file);
        } else {
            this.editImageError = false;
            this.editImageErrorMsg = '';
            this.editImagePreview = URL.createObjectURL(file);
        }
    }
}">

<script>
function validateAgendaForm(form) {
    const startDate = form.querySelector('[name="date"]').value;
    const endDate = form.querySelector('[name="end_date"]').value;
    const startTime = form.querySelector('[name="time"]').value;
    const endTime = form.querySelector('[name="end_time"]').value;
    const imageInput = form.querySelector('[name="image"]');

    if (endDate && startDate && endDate < startDate) {
        alert('🚫 TANGGAL TIDAK VALID!\n\nTanggal Selesai (' + endDate + ') tidak boleh lebih awal dari Tanggal Mulai (' + startDate + ').');
        return false;
    }

    if (startTime && endTime) {
        if (!endDate || endDate === startDate) {
            if (endTime < startTime) {
                alert('🚫 JAM / WAKTU TIDAK VALID!\n\nJam Selesai (' + endTime + ') tidak boleh lebih awal dari Jam Mulai (' + startTime + ').');
                return false;
            }
        }
    }

    if (imageInput && imageInput.files && imageInput.files.length > 0) {
        if (window.validateImageUpload && !window.validateImageUpload(imageInput, null, 'Pilih Berkas Foto', 2)) {
            return false;
        }
    }

    return true;
}
</script>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Agenda Kegiatan</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola jadwal kegiatan resmi dan acara kemasyarakatan Kelurahan Sidomukti.</p>
        </div>

        <button @click="showModal = true; createImageError = false; createImagePreview = null" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Tambah Agenda Baru
        </button>

        <!-- Modal Form Tambah Agenda -->
        <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                        <div class="flex items-center gap-3.5">
                            <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Agenda & Kegiatan</span>
                                </div>
                                <h3 class="text-base font-bold text-white tracking-wide">Tambah Agenda Kegiatan</h3>
                            </div>
                        </div>
                        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('dashboard.agendas.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden" onsubmit="return validateAgendaForm(this)">
                        @csrf
                        <div class="p-6 space-y-4 overflow-y-auto flex-1">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama / Judul Agenda <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Contoh: Musrenbang Kelurahan / Posyandu Balita">
                            </div>

                            <!-- Rentang Tanggal (Mulai s/d Selesai) -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                                    <input type="date" name="date" required class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">s/d Tanggal (Selesai)</label>
                                    <input type="date" name="end_date" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                            </div>

                            <!-- Rentang Waktu / Jam (Format Khusus Input Time) -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jam Mulai</label>
                                    <input type="time" name="time" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">s/d Jam (Selesai)</label>
                                    <input type="time" name="end_time" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Lokasi Tempat <span class="text-red-500">*</span></label>
                                <input type="text" name="location" required placeholder="Aula Kelurahan / RW 02" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Penyelenggara / Penanggung Jawab <span class="text-red-500">*</span></label>
                                <input type="text" name="organizer" required placeholder="PKK / Karang Taruna / Lurah" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>

                            <!-- Form Unggah Gambar Dokumentasi Agenda -->
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Dokumentasi / Foto Agenda (Gambar)</label>
                                <input type="file" name="image" accept="image/*" @change="validateFile($event, 'create')" class="w-full text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, JPEG, WEBP, GIF (Maksimal 2MB).</p>

                                <!-- Alert Notifikasi Akses Ditolak -->
                                <div x-show="createImageError" class="mt-2.5 p-3 bg-rose-50 border border-rose-300 rounded-xl text-rose-800 text-xs font-bold flex items-start gap-2 shadow-xs" x-cloak>
                                    <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span x-text="createImageErrorMsg"></span>
                                </div>

                                <!-- Preview Thumbnail Gambar -->
                                <template x-if="createImagePreview">
                                    <div class="mt-2.5 relative w-24 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-xs">
                                        <img :src="createImagePreview" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Keterangan Singkat</label>
                                <textarea name="description" rows="2" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Deskripsi atau rincian singkat acara..."></textarea>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                            <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Simpan Agenda</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Form Edit Agenda -->
        <div x-show="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                        <div class="flex items-center gap-3.5">
                            <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Agenda & Kegiatan</span>
                                </div>
                                <h3 class="text-base font-bold text-white tracking-wide">Edit Agenda Kegiatan</h3>
                            </div>
                        </div>
                        <button type="button" @click="editModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form :action="'/dashboard/agendas/' + editAgenda.id" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden" onsubmit="return validateAgendaForm(this)">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-4 overflow-y-auto flex-1">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama / Judul Agenda <span class="text-red-500">*</span></label>
                                <input type="text" name="title" x-model="editAgenda.title" required class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>

                            <!-- Rentang Tanggal Edit -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                                    <input type="date" name="date" x-model="editAgenda.date" required class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">s/d Tanggal (Selesai)</label>
                                    <input type="date" name="end_date" x-model="editAgenda.end_date" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                            </div>

                            <!-- Rentang Waktu / Jam Edit (Input Time) -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Jam Mulai</label>
                                    <input type="time" name="time" x-model="editAgenda.time" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">s/d Jam (Selesai)</label>
                                    <input type="time" name="end_time" x-model="editAgenda.end_time" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Lokasi Tempat <span class="text-red-500">*</span></label>
                                <input type="text" name="location" x-model="editAgenda.location" required placeholder="Aula Kelurahan / RW 02" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Penyelenggara / Penanggung Jawab <span class="text-red-500">*</span></label>
                                <input type="text" name="organizer" x-model="editAgenda.organizer" required placeholder="PKK / Karang Taruna / Lurah" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>

                            <!-- Form Unggah Gambar Edit Agenda -->
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Dokumentasi / Foto Agenda (Gambar)</label>
                                <input type="file" name="image" accept="image/*" @change="validateFile($event, 'edit')" class="w-full text-xs border border-slate-200 rounded-xl px-3 py-2 bg-slate-50 focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, JPEG, WEBP, GIF (Maks 2MB). Biarkan kosong jika tidak ingin mengubah foto.</p>

                                <!-- Alert Notifikasi Akses Ditolak -->
                                <div x-show="editImageError" class="mt-2.5 p-3 bg-rose-50 border border-rose-300 rounded-xl text-rose-800 text-xs font-bold flex items-start gap-2 shadow-xs" x-cloak>
                                    <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <span x-text="editImageErrorMsg"></span>
                                </div>

                                <!-- Preview Thumbnail Baru -->
                                <template x-if="editImagePreview">
                                    <div class="mt-2.5 relative w-24 h-24 rounded-xl overflow-hidden border border-slate-200 shadow-xs">
                                        <img :src="editImagePreview" class="w-full h-full object-cover">
                                    </div>
                                </template>

                                <!-- Preview Foto Agenda Saat Ini -->
                                <template x-if="!editImagePreview && editAgenda.image_url">
                                    <div class="mt-2.5 flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-200">
                                        <img :src="editAgenda.image_url" class="w-14 h-14 object-cover rounded-lg border border-slate-200">
                                        <span class="text-xs text-slate-500 font-medium">Foto agenda saat ini</span>
                                    </div>
                                </template>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Keterangan Singkat</label>
                                <textarea name="description" x-model="editAgenda.description" rows="2" class="w-full text-sm border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                            <button type="button" @click="editModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r-xl shadow-xs text-sm font-medium">
        <div class="font-bold mb-1">Validation Error:</div>
        <ul class="list-disc list-inside text-xs space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="font-bold text-slate-800 text-sm">Jadwal Agenda Kegiatan</h2>
            <span class="text-xs text-slate-500 font-semibold">Total: {{ $agendas->count() }} Kegiatan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-6">Tanggal & Waktu</th>
                        <th class="py-3.5 px-6">Nama Agenda & Foto</th>
                        <th class="py-3.5 px-6">Lokasi</th>
                        <th class="py-3.5 px-6">Penyelenggara</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($agendas as $agenda)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-4 px-6 whitespace-nowrap">
                            <div class="font-bold text-slate-800">
                                @php
                                    $startDateFormatted = is_string($agenda->date) ? $agenda->date : $agenda->date->format('d M Y');
                                    $endDateFormatted = $agenda->end_date ? (is_string($agenda->end_date) ? $agenda->end_date : $agenda->end_date->format('d M Y')) : null;
                                @endphp
                                @if($endDateFormatted && $endDateFormatted !== $startDateFormatted)
                                    {{ $startDateFormatted }} <span class="text-emerald-600 font-normal">s/d</span> {{ $endDateFormatted }}
                                @else
                                    {{ $startDateFormatted }}
                                @endif
                            </div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">
                                @if($agenda->time && $agenda->end_time)
                                    {{ $agenda->time }} <span class="text-emerald-600">s/d</span> {{ $agenda->end_time }}
                                @else
                                    {{ $agenda->time ?? 'Waktu disesuaikan' }}
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if($agenda->image)
                                    <img src="{{ Storage::url($agenda->image) }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-2xs shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center shrink-0 border border-slate-200" title="Tanpa Foto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-800">{{ $agenda->title }}</div>
                                    @if($agenda->description)
                                    <div class="text-xs text-slate-400 line-clamp-1">{{ $agenda->description }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-700 font-medium">
                            {{ $agenda->location }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-semibold">
                                {{ $agenda->organizer }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($agenda->is_active)
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold">Aktif</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-semibold">Selesai / Non-Aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="inline-flex items-center gap-2">
                                @php
                                    $rawTime = preg_match('/(\d{1,2}[:.]\d{2})/', (string)($agenda->getRawOriginal('time') ?? $agenda->time ?? ''), $m1) ? str_replace('.', ':', sprintf('%05s', $m1[1])) : '';
                                    $rawEndTime = preg_match('/(\d{1,2}[:.]\d{2})/', (string)($agenda->getRawOriginal('end_time') ?? $agenda->end_time ?? ''), $m2) ? str_replace('.', ':', sprintf('%05s', $m2[1])) : '';
                                @endphp
                                <button type="button" @click="editAgenda = {{ json_encode([
                                    'id' => (string)$agenda->id,
                                    'title' => (string)$agenda->title,
                                    'date' => is_string($agenda->date) ? $agenda->date : $agenda->date->format('Y-m-d'),
                                    'end_date' => $agenda->end_date ? (is_string($agenda->end_date) ? $agenda->end_date : $agenda->end_date->format('Y-m-d')) : '',
                                    'time' => $rawTime,
                                    'end_time' => $rawEndTime,
                                    'location' => (string)$agenda->location,
                                    'organizer' => (string)$agenda->organizer,
                                    'description' => (string)($agenda->description ?? ''),
                                    'image_url' => $agenda->image ? Storage::url($agenda->image) : '',
                                ]) }}; editImageError = false; editImagePreview = null; editModal = true;" class="p-1.5 text-slate-400 hover:text-amber-600 transition cursor-pointer" title="Edit Agenda">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <form action="{{ route('dashboard.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition cursor-pointer" title="Hapus Agenda">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                            Belum ada agenda kegiatan yang dicatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
