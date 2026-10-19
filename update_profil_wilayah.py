import os

file_path = r"d:\portal-desa\webkel-sidomukti\resources\views\profil\demografi.blade.php"

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace the static buttons with AlpineJS tabs
header_old = """    <!-- Header Page -->
    <div class="bg-white border-b border-slate-200 py-6 mb-8">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-start">
                <a href="{{ route('profil.demografi') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-500/20 flex items-center gap-2 transition hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Demografi Penduduk
                </a>
                <a href="#" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-bold text-sm rounded-xl transition flex items-center gap-2 cursor-not-allowed">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Wilayah & Sarpras
                </a>
            </div>
        </div>
    </div>"""

header_new = """    <!-- Header Page -->
    <div class="bg-white border-b border-slate-200 py-6 mb-8">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-start">
                <button @click="activeTab = 'demografi'" :class="activeTab === 'demografi' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20 hover:-translate-y-0.5' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900'" class="px-5 py-2.5 font-bold text-sm rounded-xl transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Demografi Penduduk
                </button>
                <button @click="activeTab = 'wilayah'" :class="activeTab === 'wilayah' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20 hover:-translate-y-0.5' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900'" class="px-5 py-2.5 font-bold text-sm rounded-xl transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5 text-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Wilayah & Sarpras
                </button>
            </div>
        </div>
    </div>"""

# Wrap container in x-data
if 'class="bg-slate-50 min-h-screen pb-16"' in content:
    content = content.replace('class="bg-slate-50 min-h-screen pb-16"', 'class="bg-slate-50 min-h-screen pb-16" x-data="{ activeTab: \'demografi\' }"')

content = content.replace(header_old, header_new)

# Wrap existing Demografi content in x-show
demografi_content_start = """    <div class="container mx-auto px-4 max-w-6xl space-y-6">"""
demografi_content_new = """    <div class="container mx-auto px-4 max-w-6xl space-y-6" x-show="activeTab === 'demografi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">"""
content = content.replace(demografi_content_start, demografi_content_new)

# Find end of demografi content to append wilayah content
append_wilayah = """
    </div>

    <!-- Profil Wilayah & Sarpras -->
    <div class="container mx-auto px-4 max-w-6xl space-y-6" x-show="activeTab === 'wilayah'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Batas Wilayah Administrasi -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Batas Wilayah Administrasi</h3>
                </div>

                <div class="space-y-0 divide-y divide-slate-100 border border-slate-100 rounded-2xl overflow-hidden">
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">UTARA</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_utara'] ?? 'Desa Kalibuntu' }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">TIMUR</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_timur'] ?? 'Kelurahan Kraksaan Wetan' }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">SELATAN</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_selatan'] ?? 'Desa Alassumur Kulon' }}</span>
                    </div>
                    <div class="flex justify-between items-center px-5 py-4 hover:bg-slate-50 transition">
                        <span class="text-xs font-bold text-slate-500 tracking-wider">BARAT</span>
                        <span class="text-sm font-semibold text-slate-800">{{ $settings['batas_barat'] ?? 'Desa Sidomukti' }}</span>
                    </div>
                </div>
            </div>

            <!-- Inventaris Sarana & Prasarana Umum -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Inventaris Sarana & Prasarana Umum</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-emerald-50/50 rounded-2xl p-5 text-center border border-emerald-100 flex flex-col items-center justify-center">
                        <div class="text-emerald-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-emerald-700 mb-1">{{ $settings['fas_sekolah'] ?? '9' }}</div>
                        <div class="text-[10px] font-bold text-emerald-600/80 uppercase tracking-widest">Sekolah (SD/SMP/SMA)</div>
                    </div>
                    <div class="bg-blue-50/50 rounded-2xl p-5 text-center border border-blue-100 flex flex-col items-center justify-center">
                        <div class="text-blue-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-blue-700 mb-1">{{ $settings['fas_ibadah'] ?? '12' }}</div>
                        <div class="text-[10px] font-bold text-blue-600/80 uppercase tracking-widest">Masjid & Musholla</div>
                    </div>
                    <div class="bg-pink-50/50 rounded-2xl p-5 text-center border border-pink-100 flex flex-col items-center justify-center">
                        <div class="text-pink-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-pink-700 mb-1">{{ $settings['fas_kesehatan'] ?? '8' }}</div>
                        <div class="text-[10px] font-bold text-pink-600/80 uppercase tracking-widest">Posyandu & Polindes</div>
                    </div>
                    <div class="bg-amber-50/50 rounded-2xl p-5 text-center border border-amber-100 flex flex-col items-center justify-center">
                        <div class="text-amber-500 mb-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="text-2xl font-extrabold text-amber-700 mb-1">{{ $settings['fas_pasar'] ?? '2' }}</div>
                        <div class="text-[10px] font-bold text-amber-600/80 uppercase tracking-widest">Pasar Tradisional</div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 text-sm text-slate-500 leading-relaxed border border-slate-100">
                    <p class="font-bold text-slate-700 mb-1">Informasi Pemekaran Lingkungan:</p>
                    <p>Kelurahan terbagi ke dalam <span class="font-bold text-slate-800">{{ $settings['wilayah_rw'] ?? '0' }} Rukun Warga (RW)</span> dan <span class="font-bold text-slate-800">{{ $settings['wilayah_rt'] ?? '0' }} Rukun Tetangga (RT)</span> yang aktif menyelenggarakan rembug warga dan kegiatan poskamling swakarsa secara berkesinambungan.</p>
                </div>
            </div>

        </div>
    </div>
"""

# Replace closing divs
if '        </div>\n    </div>\n</div>\n@endsection' in content:
    content = content.replace('        </div>\n    </div>\n</div>\n@endsection', '        </div>' + append_wilayah + '\n</div>\n@endsection')

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Updated wilayah profil view successfully!")
