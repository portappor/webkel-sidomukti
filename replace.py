import re

with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

start_marker = r'    <!-- 1\. Header Halaman Ringan & Fast -->'
end_marker = r'    <!-- 4\. Modal Interaktif: Modal Tambah Sub-Menu / Tautan Menu -->'

match = re.search(f'{start_marker}.*?{end_marker}', content, re.DOTALL)
print('Match found:', bool(match))

if match:
    replacement = r'''    <!-- New Setting System Header -->
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-2">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Setting System</h1>
            </div>
            <p class="text-sm text-slate-500 font-medium">Pusat konfigurasi identitas visual (Logo & Hero Banner) dan pembuat sub-menu dropdown beserta halamannya.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('dashboard.settings.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white text-slate-600 font-bold text-sm border border-slate-200 rounded-xl hover:bg-slate-50 transition shadow-sm">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Logo & Hero Banner
            </a>
            <a href="{{ route('dashboard.navigation.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white text-emerald-700 font-bold text-sm border border-emerald-200 rounded-xl hover:bg-emerald-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                Sub-Menu & Halaman
            </a>
        </div>
    </div>

    <!-- Banner Info -->
    <div class="bg-[#05392b] rounded-2xl p-5 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 shadow-md border border-[#0a4d3a] mt-4">
        <div>
            <div class="flex items-center gap-3 mb-1.5">
                <h2 class="text-lg md:text-xl font-bold text-white tracking-tight">Pembuat Sub-Menu & Halaman Web Dinamis</h2>
                <span class="px-2.5 py-0.5 bg-[#ff9800] text-black text-[10px] font-black rounded-full uppercase tracking-wider shrink-0">Fitur Baru</span>
            </div>
            <p class="text-emerald-100/80 text-xs md:text-sm font-medium">Setiap sub-menu yang dibuat akan otomatis memiliki halaman detail lengkap dengan judul, foto cover, dan teks paragraf/rich content.</p>
        </div>
        @php
            $profilMenu = $menus->where("title", "Profil")->first();
            $profilId = $profilMenu ? $profilMenu->id : 1;
        @endphp
        <button @click="openAddModal({{ $profilId }}, 'Profil')" class="shrink-0 w-full md:w-auto flex items-center justify-center gap-2 px-5 py-3 bg-[#ff9800] hover:bg-[#e68a00] text-black font-extrabold text-sm rounded-xl transition shadow-lg border border-[#cc7a00] cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Sub-Menu & Halaman Baru
        </button>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl p-3 md:p-4 flex flex-col md:flex-row items-center gap-4 border border-slate-200 shadow-sm mt-4" x-data="{ selectedCategory: '{{ $profilId }}', searchQuery: '' }">
        <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
            <span class="text-xs md:text-sm font-bold text-slate-700 whitespace-nowrap">Kategori Dropdown:</span>
            <select x-model="selectedCategory" class="w-full md:w-48 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs md:text-sm text-slate-700 font-bold focus:ring-2 focus:ring-emerald-500 outline-none cursor-pointer">
                @foreach($menus->whereIn("title", ["Profil", "Layanan", "Dokumen"]) as $m)
                    <option value="{{ $m->id }}">Dropdown {{ $m->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Cari judul halaman..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500 outline-none">
        </div>
    </div>

    <!-- Empty State -->
    <div class="bg-white rounded-3xl p-10 md:p-16 flex flex-col items-center justify-center text-center border border-slate-200 shadow-sm mt-6 mb-8">
        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </div>
        <h3 class="text-base md:text-lg font-bold text-slate-800 mb-2">Belum Ada Halaman Sub-Menu Kustom</h3>
        <p class="text-xs md:text-sm text-slate-500 max-w-md mx-auto mb-6">Tambahkan sub-menu baru untuk dropdown navbar beserta halaman penjelasannya dengan mengklik tombol di bawah.</p>
        <button @click="openAddModal({{ $profilId }}, 'Profil')" class="flex items-center gap-2 px-5 py-2.5 bg-[#008c5f] hover:bg-[#00734e] text-white font-bold text-sm rounded-xl transition shadow-md cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Sub-Menu Sekarang
        </button>
    </div>

    <!-- 4. Modal Interaktif: Modal Tambah Sub-Menu / Tautan Menu -->'''
    
    new_content = re.sub(f'{start_marker}.*?{end_marker}', replacement, content, flags=re.DOTALL)
    with open('d:/portal-desa/webkel-sidomukti/resources/views/dashboard/navigation/index.blade.php', 'w', encoding='utf-8') as f:
        f.write(new_content)
    print('Replacement completed!')
