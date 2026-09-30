import re

with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

start_marker = r'    <!-- 4\. Modal Interaktif: Modal Tambah Sub-Menu / Tautan Menu -->'
end_marker = r'    <!-- 5\. Modal Interaktif: Modal Edit Sub-Menu \(Optimized Backdrop & Lightweight Rendering\) -->'

match = re.search(f'{start_marker}.*?{end_marker}', content, re.DOTALL)
print('Match found:', bool(match))

if match:
    replacement = r'''    <!-- 4. Modal Interaktif: Modal Tambah Sub-Menu & Konfigurasi Halaman -->
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
                            @foreach($menus->whereIn('title', ['Profil', 'Pemerintahan', 'Informasi', 'Layanan', 'Dokumen']) as $m)
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
                                   placeholder="prestasi-kelurahan"
                                   class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 bg-white placeholder-slate-400">
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
                            <div class="w-24 h-24 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-300 text-xs font-medium shrink-0">
                                Tanpa Foto
                            </div>
                            <div class="flex-grow space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" placeholder="URL gambar atau unggah berkas foto..." class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-white text-slate-600 focus:outline-none pointer-events-none" readonly>
                                    <button type="button" class="shrink-0 flex items-center gap-2 px-4 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md relative overflow-hidden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Pilih Foto
                                        <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
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

    <!-- 5. Modal Interaktif: Modal Edit Sub-Menu (Optimized Backdrop & Lightweight Rendering) -->'''
    
    new_content = re.sub(f'{start_marker}.*?{end_marker}', replacement, content, flags=re.DOTALL)
    with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'w', encoding='utf-8') as f:
        f.write(new_content)
    print('Replacement completed!')
