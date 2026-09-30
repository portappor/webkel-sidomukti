@extends('layouts.admin')

@section('title', 'Kelola Kemitraan Strategis')

@section('content')
<div x-data="{ 
    createModal: false, 
    editModal: false, 
    deleteModal: false,
    deleteFormAction: '',
    deletePartnerName: '',
    editPartner: { id: '', name: '', category: 'Instansi Pemerintah', logo_url: '', description: '', website: '', contact_person: '', phone: '', is_active: true, sort_order: 0 },
    openEdit(partner) {
        this.editPartner = { ...partner, logo_url: partner.logo };
        this.editModal = true;
    },
    openDelete(id, name) {
        this.deleteFormAction = '{{ url('/dashboard/partnerships') }}/' + id;
        this.deletePartnerName = name;
        this.deleteModal = true;
    }
}">

    <!-- Top Title & Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Kemitraan Strategis</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen mitra kerja instansi pemerintah, BUMN, lembaga pendidikan, dan sektor swasta Kelurahan Sidomukti.</p>
        </div>

        <button @click="createModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            + Tambah Mitra Baru
        </button>
    </div>

    <!-- Alert Messages -->
    

    @if($errors->any())
    <div class="mb-6 bg-rose-500/10 border border-rose-500/20 text-rose-700 px-4 py-3 rounded-xl text-xs font-semibold">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Stat Cards Overview dihapus -->



    <!-- Main Data Table / Cards -->
    @if($partnerships->count() > 0)
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white text-[11px] font-bold uppercase tracking-wider border-b border-slate-800">
                        <th class="py-3.5 px-4">Nama & Logo Mitra</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Deskripsi Kerjasama</th>
                        <th class="py-3.5 px-4">Kontak Person</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @foreach($partnerships as $partner)
                    <tr class="hover:bg-slate-50/80 transition">
                        
                        <!-- Logo & Name -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 p-1 shrink-0 overflow-hidden flex items-center justify-center">
                                    <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="w-full h-full object-contain rounded-lg">
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-800 leading-snug line-clamp-1">{{ $partner->name }}</h4>
                                    @if($partner->website)
                                    <a href="{{ $partner->website }}" target="_blank" class="text-[11px] text-emerald-600 hover:underline flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        {{ parse_url($partner->website, PHP_URL_HOST) ?? $partner->website }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/80 rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                                {{ $partner->category }}
                            </span>
                        </td>

                        <!-- Description -->
                        <td class="py-3.5 px-4 max-w-xs">
                            <p class="text-slate-600 line-clamp-2 leading-relaxed text-[11px]">
                                {{ $partner->description ?? '-' }}
                            </p>
                        </td>

                        <!-- Contact Person & Phone -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700">{{ $partner->contact_person ?? '-' }}</span>
                                @if($partner->phone)
                                <span class="text-[11px] text-slate-500 font-mono flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                                    {{ $partner->phone }}
                                </span>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            @if($partner->is_active)
                            <span class="px-2.5 py-1 bg-teal-100 text-teal-800 rounded-full text-[10px] font-bold">
                                Aktif
                            </span>
                            @else
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold">
                                Nonaktif
                            </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openEdit({{ json_encode($partner) }})" 
                                        class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button @click="openDelete({{ $partner->id }}, '{{ addslashes($partner->name) }}')" 
                                        class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $partnerships->withQueryString()->links() }}
    </div>
    @else
    <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 max-w-xl mx-auto my-8">
        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9"></path></svg>
        <h3 class="text-lg font-bold text-slate-700">Belum Ada Data Kemitraan</h3>
        <p class="text-slate-500 text-xs mt-1">Belum ada data mitra kerja yang sesuai dengan filter atau pencarian Anda.</p>
    </div>
    @endif

    <!-- MODAL CREATE PARTNER -->
    <div x-show="createModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs"
         style="display: none;">
        
        <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                <div class="flex items-center gap-3.5">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Kemitraan Kerja</span>
                        </div>
                        <h3 class="text-base font-bold text-white tracking-wide">Tambah Mitra Kerja Baru</h3>
                    </div>
                </div>
                <button type="button" @click="createModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('dashboard.partnerships.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validatePartnershipForm(this)" class="flex flex-col flex-1 overflow-hidden">
                @csrf

                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Instansi / Perusahaan Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Contoh: PT Pegadaian (Persero)">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition bg-white">
                                <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                                <option value="BUMN / BUMD">BUMN / BUMD</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Sektor Swasta / UMKM">Sektor Swasta / UMKM</option>
                                <option value="Organisasi Masyarakat">Organisasi Masyarakat</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampilan</label>
                            <input type="number" name="sort_order" value="0" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Upload File Logo (Atau Masukkan URL Logo) <span class="text-[10px] font-medium text-slate-400">(Maks 5MB)</span></label>
                        <input type="file" name="logo_file" accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer mb-2">
                        <input type="text" name="logo_url" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Atau paste URL logo (https://...)">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi / Bentuk Kerjasama</label>
                        <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Penjelasan ringkas program kemitraan..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Penanggung Jawab / Kontak</label>
                            <input type="text" name="contact_person" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Contoh: Bpk. Hendra">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">No. Telepon / WA</label>
                            <input type="text" name="phone" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="081234567890">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Situs Web Resmi (URL)</label>
                        <input type="url" name="website" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="https://www.instansi.go.id">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_active" id="is_active_create" value="1" checked class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                        <label for="is_active_create" class="text-xs font-bold text-slate-700 cursor-pointer">Status Aktif (Ditampilkan Publik)</label>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                    <button type="button" @click="createModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PARTNER -->
    <div x-show="editModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs"
         style="display: none;">
        
        <div class="relative w-full max-w-lg my-auto transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
                <div class="flex items-center gap-3.5">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Kemitraan Kerja</span>
                        </div>
                        <h3 class="text-base font-bold text-white tracking-wide">Edit Data Mitra Kerja</h3>
                    </div>
                </div>
                <button type="button" @click="editModal = false" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'{{ url('/dashboard/partnerships') }}/' + editPartner.id" method="POST" enctype="multipart/form-data" onsubmit="return validatePartnershipForm(this)" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Instansi / Perusahaan Mitra <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editPartner.name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" x-model="editPartner.category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition bg-white">
                                <option value="Instansi Pemerintah">Instansi Pemerintah</option>
                                <option value="BUMN / BUMD">BUMN / BUMD</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Sektor Swasta / UMKM">Sektor Swasta / UMKM</option>
                                <option value="Organisasi Masyarakat">Organisasi Masyarakat</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Tampilan</label>
                            <input type="number" name="sort_order" x-model="editPartner.sort_order" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti File Logo (Opsional) <span class="text-[10px] font-medium text-slate-400">(Maks 5MB)</span></label>
                        <input type="file" name="logo_file" accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer mb-2">
                        <input type="text" name="logo_url" x-model="editPartner.logo_url" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition" placeholder="Atau paste URL logo (https://...)">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi / Bentuk Kerjasama</label>
                        <textarea name="description" x-model="editPartner.description" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Penanggung Jawab / Kontak</label>
                            <input type="text" name="contact_person" x-model="editPartner.contact_person" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">No. Telepon / WA</label>
                            <input type="text" name="phone" x-model="editPartner.phone" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Situs Web Resmi (URL)</label>
                        <input type="url" name="website" x-model="editPartner.website" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 transition">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" name="is_active" id="is_active_edit" value="1" :checked="editPartner.is_active" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                        <label for="is_active_edit" class="text-xs font-bold text-slate-700 cursor-pointer">Status Aktif (Ditampilkan Publik)</label>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                    <button type="button" @click="editModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Perbarui Data</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DELETE CONFIRMATION -->
    <div x-show="deleteModal" 
         x-transition.opacity
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs"
         style="display: none;">
        
        <div class="relative max-w-sm w-full bg-white rounded-2xl p-6 text-center shadow-2xl border border-slate-200">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="font-bold text-base text-slate-800 mb-1">Konfirmasi Hapus</h3>
            <p class="text-xs text-slate-500 mb-6">Apakah Anda yakin ingin menghapus data kemitraan <span class="font-bold text-slate-700" x-text="deletePartnerName"></span>?</p>
            
            <form :action="deleteFormAction" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-center gap-3">
                    <button type="button" @click="deleteModal = false" class="w-1/2 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">Batal</button>
                    <button type="submit" class="w-1/2 py-2.5 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition cursor-pointer">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
window.validateImageUrlInput = function(input) {
    const val = input.value ? input.value.trim() : '';
    if (!val) return true;

    const isImageUrl = /^https?:\/\/.+/i.test(val) && /\.(jpe?g|png|webp|gif|svg)($|\?|#)/i.test(val);
    if (!isImageUrl) {
        input.value = '';
        input.dispatchEvent(new Event('input'));
        alert('🚫 AKSES DITOLAK!\n\nTautan URL logo \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan URL berkas Foto / Gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg) yang diperbolehkan!');
        return false;
    }
    return true;
};

window.validatePartnershipForm = function(form) {
    const fileInput = form.querySelector('input[name="logo_file"]');
    if (fileInput && fileInput.files && fileInput.files.length > 0) {
        if (!validateImageUpload(fileInput)) {
            return false;
        }
    }

    const urlInput = form.querySelector('input[name="logo_url"]');
    if (urlInput && urlInput.value.trim() !== '') {
        if (!validateImageUrlInput(urlInput)) {
            return false;
        }
    }

    return true;
};
</script>
@endsection
