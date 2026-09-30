import re

file_path = 'd:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Update the Filter & Search Section and the List Section
old_section = """    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl p-3 md:p-4 flex flex-col md:flex-row items-center gap-4 border border-slate-200 shadow-sm mt-4" x-data="{ selectedCategory: '{{ $profilId }}', searchQuery: '' }">
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
        @foreach($menus->whereIn('title', ['Profil']) as $m)
            <div x-show="selectedCategory == '{{ $m->id }}'" x-cloak>
                @if($m->children && $m->children->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($m->children as $child)
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
                                        <div class="flex items-center gap-1 shrink-0 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button @click="openEditModal('{{ $child->id }}', '{{ addslashes($child->title) }}', '{{ addslashes($child->url) }}', '{{ $child->target }}', {{ $m->id }}, {{ $child->order }}, {{ $child->is_active ? 1 : 0 }}, '{{ addslashes($child->content) }}', '{{ addslashes($child->image) }}')" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg cursor-pointer transition">
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
                    <div class="bg-white rounded-3xl p-10 md:p-16 flex flex-col items-center justify-center text-center border border-slate-200 shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-slate-800 mb-2">Belum Ada Halaman Sub-Menu Kustom</h3>
                        <p class="text-xs md:text-sm text-slate-500 max-w-md mx-auto mb-6">Tambahkan sub-menu baru untuk dropdown navigasi ini beserta halaman penjelasannya dengan mengklik tombol di bawah.</p>
                        <button @click="openAddModal({{ $m->id }}, '{{ $m->title }}')" class="flex items-center gap-2 px-5 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Sub-Menu Sekarang
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>"""

new_section = """    <!-- Filter & Search Section -->
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
    </div>"""

content = content.replace(old_section, new_section)

# 2. Add searchQuery to navigationManager
content = content.replace(
    "        showAddModal: false,",
    "        searchQuery: '',\n        showAddModal: false,"
)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)
print("Template simplified and integrated successfully!")
