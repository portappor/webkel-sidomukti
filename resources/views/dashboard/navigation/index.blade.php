@extends('layouts.admin')

@section('title', 'Kelola Header Navigasi')

@section('content')
<div class="space-y-5" x-data="navigationManager()">

    <!-- Alert Notifications -->


    @if(isset($errors) && $errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl shadow-xs" role="alert">
        <div class="font-bold text-xs sm:text-sm mb-1 flex items-center gap-2">
            <span class="text-rose-600">⚠</span>
            <span>Perhatian Validation Error:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-0.5 ml-4">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- Banner Info -->
    <div class="bg-white rounded-xl p-5 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 shadow-sm border border-slate-200 mt-4">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 border border-emerald-100 hidden md:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <div>
                <div class="flex items-center gap-3 mb-1.5">
                    <h2 class="text-base md:text-lg font-bold text-slate-800 tracking-tight">Pembuat Sub-Menu & Halaman Web Dinamis</h2>
                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-bold rounded-full uppercase tracking-wider shrink-0">Fitur Baru</span>
                </div>
                <p class="text-slate-500 text-xs md:text-sm">Setiap sub-menu yang dibuat akan otomatis memiliki halaman detail lengkap dengan judul, foto cover, dan teks paragraf/rich content.</p>
            </div>
        </div>
        @php
            $profilMenu = $menus->where("title", "Profil")->first();
            $profilId = $profilMenu ? $profilMenu->id : 1;
        @endphp
        <button @click="openAddModal({{ $profilId }}, 'Profil')" class="shrink-0 w-full md:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Sub-Menu Baru
        </button>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl p-3 md:p-4 flex flex-col md:flex-row items-center gap-4 border border-slate-200 shadow-sm mt-4">
        <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
            <span class="text-xs md:text-sm font-bold text-slate-700 whitespace-nowrap">Mengelola Kategori:</span>
            <div class="px-4 py-2.5 bg-emerald-50 border border-emerald-200 rounded-lg text-xs md:text-sm text-emerald-800 font-bold flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Dropdown Profil
            </div>
        </div>
        <div class="w-full relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Cari judul halaman..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
    </div>

    <!-- Daftar Sub-Menu & Empty State -->
    <div class="mt-6 space-y-4 mb-8">
        @if($profilMenu && $profilMenu->children && $profilMenu->children->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($profilMenu->children as $child)
                    <!-- Sub-Menu Card -->
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition group relative overflow-hidden" 
                         x-show="searchQuery === '' || '{{ strtolower($child->title) }}'.includes(searchQuery.toLowerCase())">
                        <div class="flex flex-col h-full gap-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $child->title }}">{{ $child->title }}</h4>
                                        <p class="text-[10px] font-mono text-slate-400 truncate">{{ $child->url }}</p>
                                    </div>
                                </div>
                                @php
                                    $defaultMenus = ['visi & misi', 'struktur organisasi', 'sejarah kelurahan', 'tugas & fungsi', 'lembaga kemasyarakatan'];
                                @endphp
                                @if(!in_array(strtolower(trim($child->title)), $defaultMenus))
                                <div class="flex items-center gap-1 shrink-0 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal('{{ $child->id }}', '{{ addslashes($child->title) }}', '{{ addslashes($child->url) }}', '{{ $child->target }}', {{ $profilMenu->id }}, {{ $child->order }}, {{ $child->is_active ? 1 : 0 }}, '{{ addslashes($child->content) }}', '{{ addslashes($child->image) }}')" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg cursor-pointer transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('dashboard.navigation.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman &quot;{{ addslashes($child->title) }}&quot;?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg cursor-pointer transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @if($child->description)
                                <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $child->description }}</p>
                            @endif
                            <div class="mt-auto pt-3 flex items-center justify-between border-t border-slate-100">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold {{ $child->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $child->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $child->is_active ? 'Aktif Tayang' : 'Disembunyikan' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-10 md:p-16 flex flex-col items-center justify-center text-center border border-slate-200 shadow-sm">
                <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-slate-800 mb-2">Belum Ada Halaman Sub-Menu Kustom</h3>
                <p class="text-xs md:text-sm text-slate-500 max-w-md mx-auto mb-6">Tambahkan sub-menu baru untuk dropdown navigasi ini beserta halaman penjelasannya dengan mengklik tombol di bawah.</p>
                <button @click="openAddModal({{ $profilId }}, 'Profil')" class="flex items-center gap-2 px-5 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Sub-Menu Sekarang
                </button>
            </div>
        @endif
    </div>

    <!-- 4. Modal Interaktif: Modal Tambah Sub-Menu & Konfigurasi Halaman -->
    <div x-show="showAddModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-start justify-center p-4 pt-10 sm:pt-12 pb-12"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        <div class="bg-white rounded-2xl max-w-4xl w-full shadow-xl border border-slate-200 overflow-hidden text-left relative flex flex-col">
            
            <!-- Header -->
            <div class="px-6 py-4 flex items-center justify-between border-b border-slate-100">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="font-extrabold text-slate-800 text-lg">
                            Tambah Sub-Menu & Konfigurasi Halaman
                        </h3>
                    </div>
                    <p class="text-[13px] text-slate-500 font-medium mt-1 ml-4">
                        Tentukan label menu, letak dropdown, dan isi konten halaman.
                    </p>
                </div>
                <button type="button" @click="showAddModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1 cursor-pointer text-xl leading-none">&times;</button>
            </div>

            <!-- Body -->
            <form action="{{ route('dashboard.navigation.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
                @csrf
                <div class="p-6 overflow-y-auto max-h-[calc(100vh-140px)] space-y-6">
                    
                    <!-- Letak Menu Dropdown Navbar -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">
                            Letak Menu Dropdown Navbar <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach($menus->whereIn('title', ['Profil']) as $m)
                            <label class="relative flex items-center gap-3 p-3 border rounded-xl cursor-pointer transition-all duration-200"
                                   :class="addParentId == {{ $m->id }} ? 'border-emerald-500 bg-emerald-50/30 ring-1 ring-emerald-500' : 'border-slate-200 hover:border-emerald-200 hover:bg-slate-50'">
                                <input type="radio" name="parent_id" value="{{ $m->id }}" x-model="addParentId" class="hidden">
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center shrink-0"
                                     :class="addParentId == {{ $m->id }} ? 'border-emerald-500 bg-white' : 'border-slate-300'">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500" x-show="addParentId == {{ $m->id }}"></div>
                                </div>
                                <span class="text-sm font-bold text-slate-700" :class="addParentId == {{ $m->id }} ? 'text-emerald-800' : ''">Dropdown {{ $m->title }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium mt-1.5">
                            Sub-menu akan otomatis muncul di dropdown navigasi navbar yang dipilih.
                        </p>
                    </div>

                    <!-- Row 2 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Nama Sub-Menu / Judul Halaman <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   x-model="addTitle"
                                   @input="addSlug = addTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')"
                                   required
                                   placeholder="Contoh: Prestasi & Penghargaan Kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-white placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Slug URL (/halaman/:slug) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="slug"
                                   x-model="addSlug"
                                   placeholder="prestasi-kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-slate-50 placeholder-slate-400">
                        </div>
                    </div>

                    <!-- Ringkasan Singkat -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-2">
                            Ringkasan Singkat (Opsional)
                        </label>
                        <input type="text"
                               name="summary"
                               placeholder="Ringkasan 1-2 kalimat pengantar untuk pembaca..."
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-white placeholder-slate-400">
                    </div>

                    <!-- Foto Cover -->
                    <div class="bg-slate-50/50 border border-slate-200 rounded-xl p-4">
                        <label class="block text-sm font-bold text-slate-800 mb-3">
                            Foto Cover / Gambar Utama Halaman
                        </label>
                        <div class="flex items-center gap-4">
                            <!-- Preview Box -->
                            <div class="w-24 h-24 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-300 text-xs font-medium shrink-0 overflow-hidden relative group">
                                <template x-if="addImageUrl">
                                    <img :src="addImageUrl" class="w-full h-full object-cover" alt="Preview">
                                </template>
                                <template x-if="!addImageUrl">
                                    <span>Tanpa Foto</span>
                                </template>
                                <button type="button" x-show="addImageUrl" @click="addImageUrl=''; addImageName=''; $refs.fileInput.value=''" class="absolute inset-0 bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="flex-grow space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" :value="addImageName" placeholder="URL gambar atau unggah berkas foto..." class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white text-slate-600 focus:outline-none pointer-events-none" readonly>
                                    <button type="button" class="shrink-0 flex items-center gap-2 px-4 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md relative overflow-hidden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Pilih Foto
                                        <input type="file" name="image" x-ref="fileInput" @change="handleImageUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    </button>
                                </div>
                                <p class="text-[11px] text-slate-400 font-medium">
                                    Format foto: JPG, PNG, WebP (Maks. 10MB). Akan ditampilkan di atas artikel halaman.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Konten Paragraf -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-bold text-slate-800">
                                Konten Paragraf & Isi Halaman <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-bold text-[#008c5f]">Mendukung format heading, list, gambar, dan tebal/miring</span>
                        </div>
                        <div class="border border-slate-200 rounded-xl overflow-hidden bg-white">
                            <textarea name="content"
                                      id="content_add"
                                      rows="6"
                                      placeholder="Tuliskan isi informasi lengkap untuk halaman ini (paragraf, poin penting, tabel atau deskripsi)..."
                                      class="w-full px-4 py-3 text-sm text-slate-700 bg-white placeholder-slate-400 focus:outline-none resize-none border-none ring-0 focus:ring-0"></textarea>
                            
                            <!-- Bottom Editor Bar -->
                            <div class="bg-slate-50 px-4 py-2 border-t border-slate-100 flex items-center justify-between text-[11px] font-medium text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#008c5f]"></span>
                                    <span>Mode Visual (Microsoft Word Style)</span>
                                </div>
                                <div>
                                    0 kata &bull; 0 karakter
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="order" value="0">
                    <input type="hidden" name="is_active" value="1">
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3 mt-auto">
                    <button type="button" @click="showAddModal = false" class="px-5 py-2.5 text-slate-600 font-bold hover:text-slate-800 text-sm transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white text-sm font-bold rounded-xl transition shadow-md cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 5. Modal Interaktif: Modal Edit Sub-Menu (Optimized Backdrop & Lightweight Rendering) -->
    <div x-show="showEditModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-start justify-center p-4 pt-10 sm:pt-12 pb-12"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        <div class="bg-white rounded-2xl max-w-xl sm:max-w-2xl w-full p-5 sm:p-6 shadow-xl border border-slate-200 space-y-4 text-left relative">

            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base sm:text-lg">
                        Edit Sub-Menu Navigasi
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">
                        Perbarui informasi & konten halaman sub-menu
                    </p>
                </div>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 font-bold p-1 cursor-pointer text-xl leading-none">&times;</button>
            </div>

            <form :action="editFormAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="parent_id" :value="editParentId">

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        LABEL TAUTAN <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           x-model="editTitle"
                           required
                           placeholder="Contoh: Sejarah Kelurahan"
                           class="w-full px-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-800 bg-white">
                    <p class="text-[11px] text-slate-400 font-medium mt-1">
                        Nama menu yang akan tampil di header publik.
                    </p>
                </div>

                <div class="border border-slate-200/80 bg-slate-50/40 rounded-xl p-3.5 space-y-3">
                    <h4 class="font-bold text-slate-800 text-xs border-b border-slate-200/60 pb-1.5">
                        Konten Halaman Baru
                    </h4>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                            FOTO BANNER (OPSIONAL)
                        </label>

                        <template x-if="editImageUrl">
                            <div class="mb-2.5 p-2 bg-white border border-slate-200 rounded-lg flex items-center justify-between gap-3 shadow-2xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <img :src="editImageUrl" alt="Foto Banner" class="w-12 h-9 object-cover rounded border border-slate-200 shrink-0">
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-slate-800">Foto Banner Terpasang</p>
                                        <p class="text-[10px] text-slate-500 font-mono truncate" x-text="editImage"></p>
                                    </div>
                                </div>
                                <label class="inline-flex items-center gap-1 px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-md text-xs font-bold transition border border-rose-200 cursor-pointer shrink-0">
                                    <input type="checkbox" name="remove_image" value="1" class="w-3.5 h-3.5 text-rose-600 border-slate-300 rounded focus:ring-rose-500">
                                    <span>Hapus</span>
                                </label>
                            </div>
                        </template>

                        <input type="file"
                               name="image"
                               accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 cursor-pointer border border-slate-200 rounded-lg p-1 bg-white">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">
                            ISI HALAMAN SINGKAT
                        </label>
                        <textarea name="content"
                                  id="content_edit"
                                  x-model="editContent"
                                  rows="3"
                                  placeholder="Tuliskan deskripsi atau isi penjelasan singkat untuk halaman sub-menu ini..."
                                  class="w-full px-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-800 bg-white placeholder-slate-400"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            URUTAN TAMPIL <span class="text-rose-500">*</span>
                        </label>
                        <input type="number"
                               name="order"
                               x-model="editOrder"
                               min="0"
                               required
                               class="w-full px-3.5 py-2 text-xs sm:text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-800 bg-white">
                    </div>

                    <div class="pt-2 sm:pt-4">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            STATUS TAMPIL
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   :checked="editIsActive"
                                   class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                            <span class="text-xs sm:text-sm font-bold text-slate-800">Aktif Tayang</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                    <button type="button"
                            @click="showEditModal = false"
                            class="px-3.5 py-1.5 text-slate-600 font-bold hover:text-slate-800 text-xs transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition shadow-2xs cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('navigationManager', () => ({
        searchQuery: '',
        showAddModal: false,
        addParentId: null,
        addParentTitle: 'Profil',
        addTitle: '',
        addSlug: '',
        addImageUrl: '',
        addImageName: '',

        showEditModal: false,
        editId: null,
        editTitle: '',
        editUrl: '',
        editTarget: '_self',
        editOrder: 0,
        editIsActive: true,
        editContent: '',
        editImage: '',
        editImageUrl: '',
        editParentId: null,
        editFormAction: '',


        handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.addImageName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.addImageUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.addImageName = '';
                this.addImageUrl = '';
            }
        },

        openAddModal(parentId, parentTitle) {
            this.addParentId = parentId;
            this.addParentTitle = parentTitle || 'Profil';
            this.addTitle = '';
            this.addSlug = '';
            this.addImageUrl = '';
            this.addImageName = '';
            this.showAddModal = true;
            setTimeout(() => {
                if (typeof tinymce !== 'undefined') {
                    let editor = tinymce.get('content_add');
                    if (editor) {
                        editor.setContent('');
                    }
                }
            }, 100);
        },

        openEditModal(id, title, url, target, parentId, order, isActive, content, image) {
            this.editId = id;
            this.editTitle = title;
            this.editUrl = url;
            this.editTarget = target || '_self';
            this.editOrder = order || 0;
            this.editIsActive = Boolean(isActive);
            this.editContent = content || '';
            this.editParentId = parentId;
            this.editImage = image || '';

            if (this.editImage) {
                if (this.editImage.startsWith('http://') || this.editImage.startsWith('https://') || this.editImage.startsWith('data:')) {
                    this.editImageUrl = this.editImage;
                } else {
                    this.editImageUrl = `{{ asset('storage') }}/${this.editImage}`;
                }
            } else {
                this.editImageUrl = '';
            }

            this.editFormAction = `{{ url('/dashboard/navigation') }}/${id}`;
            this.showEditModal = true;

            setTimeout(() => {
                if (typeof tinymce !== 'undefined') {
                    let editor = tinymce.get('content_edit');
                    if (editor) {
                        editor.setContent(this.editContent);
                    }
                }
            }, 100);
        }
    }));
});

// Dynamic Realtime Clock (Format Indonesia)
function updateRealtimeClock() {
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const now = new Date();

    const dayName = days[now.getDay()];
    const dateNum = now.getDate();
    const monthName = months[now.getMonth()];
    const year = now.getFullYear();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const clockElement = document.getElementById('realtime-clock');
    if (clockElement) {
        clockElement.textContent = `${dayName}, ${dateNum} ${monthName} ${year} ${hours}:${minutes}:${seconds} WIB`;
    }
}

setInterval(updateRealtimeClock, 1000);
document.addEventListener('DOMContentLoaded', updateRealtimeClock);

document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content_add, #content_edit',
            height: 300,
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image table | code',
            content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #334155; }',
            branding: false,
            promotion: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    }
});
</script>
@endpush
@endsection
