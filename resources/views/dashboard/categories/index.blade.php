@extends('layouts.admin')

@section('title', 'Master Kategori Terpadu')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Master Kategori Terpadu</h2>
        <p class="text-slate-500 text-sm mt-0.5">Kelola master kategori data untuk modul SOP & Layanan, Dokumen PDF, Berita, Galeri Foto, dan Video Dokumentasi.</p>
    </div>
    <button type="button" onclick="openModal('addCategoryModal')" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-emerald-700/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 text-sm shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kategori
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

<!-- Top Filter Pills / Tabs -->
<div class="flex flex-wrap items-center gap-2 mb-6 pb-2 border-b border-slate-200/80">
    <a href="{{ route('dashboard.categories.index', ['module' => 'all']) }}" 
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 {{ $selectedModule === 'all' ? 'bg-emerald-700 text-white shadow-md shadow-emerald-700/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <span>Semua Kategori</span>
        <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedModule === 'all' ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $allCount }}</span>
    </a>

    @foreach($modules as $modKey => $modLabel)
    <a href="{{ route('dashboard.categories.index', ['module' => $modKey]) }}" 
       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 {{ $selectedModule === $modKey ? 'bg-emerald-700 text-white shadow-md shadow-emerald-700/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        <span>{{ $modLabel }}</span>
        <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedModule === $modKey ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $moduleCounts[$modKey] ?? 0 }}</span>
    </a>
    @endforeach
</div>

<!-- Table Card -->
<div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden p-2 sm:p-4">
    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase font-semibold border-b border-slate-200 text-[11px] tracking-wider">
                <tr>
                    <th scope="col" class="px-4 py-3.5 w-16">Urutan</th>
                    <th scope="col" class="px-4 py-3.5 w-32">Modul</th>
                    <th scope="col" class="px-6 py-3.5">Nama Kategori</th>
                    <th scope="col" class="px-6 py-3.5">Slug / Identifikasi</th>
                    <th scope="col" class="px-6 py-3.5">Keterangan</th>
                    <th scope="col" class="px-4 py-3.5 text-center w-24">Status</th>
                    <th scope="col" class="px-6 py-3.5 text-right w-24">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-4 py-4 font-semibold text-slate-400 text-xs">
                        #{{ $category->order }}
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $category->module_badge_class }}">
                            {{ strtoupper($category->module) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $category->color_dot_class }}"></span>
                            <span class="font-bold text-slate-800 text-sm md:text-base">{{ $category->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <code class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-mono border border-slate-200">{{ $category->slug }}</code>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs md:text-sm max-w-xs">
                        {{ $category->description ?: '-' }}
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($category->status === 'aktif')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                            Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" 
                                    onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->module }}', '{{ $category->color }}', '{{ addslashes($category->description ?? '') }}', {{ $category->order }}, '{{ $category->status }}')"
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition"
                                    title="Edit Kategori">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori &quot;{{ addslashes($category->name) }}&quot;?');" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition"
                                        title="Hapus Kategori">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500 italic">Belum ada data kategori untuk filter ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="addCategoryModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-lg transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            MASTER KATEGORI TERPADU
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Tambah Kategori Baru</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('addCategoryModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('dashboard.categories.store') }}" method="POST" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Modul Target <span class="text-rose-500">*</span></label>
                    <select name="module" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white" required>
                        @foreach($modules as $mKey => $mLabel)
                        <option value="{{ $mKey }}" {{ $selectedModule === $mKey ? 'selected' : '' }}>{{ $mLabel }} ({{ strtoupper($mKey) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Pemerintahan, UMKM, Pariwisata" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Warna Penanda <span class="text-rose-500">*</span></label>
                        <select name="color" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white" required>
                            <option value="emerald">Hijau (Emerald)</option>
                            <option value="blue">Biru (Blue)</option>
                            <option value="rose">Merah (Rose)</option>
                            <option value="amber">Kuning (Amber)</option>
                            <option value="purple">Ungu (Purple)</option>
                            <option value="indigo">Nila (Indigo)</option>
                            <option value="cyan">Biru Muda (Cyan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Urutan Tampilan <span class="text-rose-500">*</span></label>
                        <input type="number" name="order" value="1" min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 text-center bg-white" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Keterangan / Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Jelaskan cakupan topik untuk kategori ini..."></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('addCategoryModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Kategori</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div id="editCategoryModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-lg transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            MASTER KATEGORI TERPADU
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Edit Kategori</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('editCategoryModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="editCategoryForm" method="POST" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Modul Target <span class="text-rose-500">*</span></label>
                    <select name="module" id="edit_category_module" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white" required>
                        @foreach($modules as $mKey => $mLabel)
                        <option value="{{ $mKey }}">{{ $mLabel }} ({{ strtoupper($mKey) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="edit_category_name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Warna Penanda <span class="text-rose-500">*</span></label>
                        <select name="color" id="edit_category_color" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white" required>
                            <option value="emerald">Hijau (Emerald)</option>
                            <option value="blue">Biru (Blue)</option>
                            <option value="rose">Merah (Rose)</option>
                            <option value="amber">Kuning (Amber)</option>
                            <option value="purple">Ungu (Purple)</option>
                            <option value="indigo">Nila (Indigo)</option>
                            <option value="cyan">Biru Muda (Cyan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Urutan Tampilan <span class="text-rose-500">*</span></label>
                        <input type="number" name="order" id="edit_category_order" min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 text-center bg-white" required>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select name="status" id="edit_category_status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Keterangan / Deskripsi Singkat</label>
                    <textarea name="description" id="edit_category_description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('editCategoryModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            const card = modal.querySelector('.transform') || modal.firstElementChild;
            if (card) {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('opacity-0');
        const card = modal.querySelector('.transform') || modal.firstElementChild;
        if (card) {
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, name, module, color, description, order, status) {
        document.getElementById('edit_category_name').value = name;
        document.getElementById('edit_category_module').value = module;
        document.getElementById('edit_category_color').value = color;
        document.getElementById('edit_category_description').value = description;
        document.getElementById('edit_category_order').value = order;
        document.getElementById('edit_category_status').value = status;
        
        const form = document.getElementById('editCategoryForm');
        form.action = `/dashboard/categories/${id}`;
        
        openModal('editCategoryModal');
    }
</script>
@endsection
