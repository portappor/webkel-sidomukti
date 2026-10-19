import os
import re

home_path = r"d:\portal-desa\webkel-sidomukti\resources\views\home.blade.php"

with open(home_path, 'r', encoding='utf-8') as f:
    content = f.read()

demografi_html = """
    <!-- Section Statistik & Demografi (Integrated) -->
    <section class="py-16 bg-white relative border-t border-slate-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-xs">Statistik Kelurahan</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">Data & Demografi Warga</h2>
                <p class="text-slate-500">Gambaran umum statistik kependudukan, wilayah, dan sosial demografi di kelurahan kami.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                @if(($settings['show_penduduk'] ?? '1') == '1')
                <div class="bg-emerald-50 rounded-2xl p-6 text-center border border-emerald-100 hover:shadow-lg hover:shadow-emerald-100 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto bg-emerald-500 text-white rounded-full flex items-center justify-center mb-4 shadow-md shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="text-3xl font-extrabold text-emerald-700 mb-1">{{ $settings['demografi_total'] ?? '0' }}</div>
                    <div class="text-sm font-semibold text-emerald-600/80 uppercase tracking-wide">Penduduk</div>
                </div>
                @endif

                @if(($settings['show_kk'] ?? '1') == '1')
                <div class="bg-emerald-50 rounded-2xl p-6 text-center border border-emerald-100 hover:shadow-lg hover:shadow-emerald-100 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto bg-emerald-500 text-white rounded-full flex items-center justify-center mb-4 shadow-md shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    </div>
                    <div class="text-3xl font-extrabold text-emerald-700 mb-1">{{ $settings['demografi_kk'] ?? '0' }}</div>
                    <div class="text-sm font-semibold text-emerald-600/80 uppercase tracking-wide">Kepala Keluarga</div>
                </div>
                @endif

                @if(($settings['show_wilayah'] ?? '1') == '1')
                <div class="bg-emerald-50 rounded-2xl p-6 text-center border border-emerald-100 hover:shadow-lg hover:shadow-emerald-100 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto bg-emerald-500 text-white rounded-full flex items-center justify-center mb-4 shadow-md shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0v5"></path></svg>
                    </div>
                    <div class="text-3xl font-extrabold text-emerald-700 mb-1">{{ $settings['wilayah_rt'] ?? '0' }}/{{ $settings['wilayah_rw'] ?? '0' }}</div>
                    <div class="text-sm font-semibold text-emerald-600/80 uppercase tracking-wide">RT / RW</div>
                </div>
                @endif

                @if(($settings['show_luas'] ?? '1') == '1')
                <div class="bg-emerald-50 rounded-2xl p-6 text-center border border-emerald-100 hover:shadow-lg hover:shadow-emerald-100 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-12 h-12 mx-auto bg-emerald-500 text-white rounded-full flex items-center justify-center mb-4 shadow-md shadow-emerald-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <div class="text-3xl font-extrabold text-emerald-700 mb-1">{{ $settings['luas_wilayah'] ?? '0' }}<span class="text-lg">km&sup2;</span></div>
                    <div class="text-sm font-semibold text-emerald-600/80 uppercase tracking-wide">Luas Wilayah</div>
                </div>
                @endif
            </div>
        </div>
    </section>
"""

if "<!-- Section Statistik & Demografi" not in content:
    # Insert right before the closing @endsection
    insert_pos = content.rfind("<!-- 1. Lightbox Modal Foto -->")
    if insert_pos == -1:
        insert_pos = content.rfind("@endsection")
        
    if insert_pos != -1:
        new_content = content[:insert_pos] + demografi_html + "\n" + content[insert_pos:]
        with open(home_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print("Injected demographics section into home.blade.php")
    else:
        print("Could not find insertion point in home.blade.php")
else:
    print("Demographics section already exists in home.blade.php")
