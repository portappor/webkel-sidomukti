import re

with open('resources/views/home.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Extract sections
hero_match = re.search(r'(<!-- Hero Banner -->.*?)</section>', content, re.DOTALL)
stats_match = re.search(r'(<!-- Floating Stats Bar -->.*?)</section>', content, re.DOTALL)
layanan_match = re.search(r'(<!-- Fitur Quick Access / Layanan \(Grid\) -->.*?)</section>', content, re.DOTALL)
berita_match = re.search(r'(<!-- Feed Informasi / Berita Terbaru -->.*?)</section>', content, re.DOTALL)

sambutan_html = """
<!-- Sambutan Pimpinan / Lurah -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 items-center">
            <div class="w-full lg:w-1/3 flex justify-center reveal fade-right">
                <div class="relative w-64">
                    <img src="{{ isset($settings['kadin_photo']) && $settings['kadin_photo'] ? Storage::url($settings['kadin_photo']) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop' }}" 
                         alt="Pimpinan Kelurahan" class="w-full h-80 object-cover rounded-2xl shadow-lg border border-slate-100">
                    <div class="absolute -bottom-4 inset-x-4 bg-white border border-slate-100 py-3 px-4 rounded-xl shadow-sm text-center">
                        <h4 class="font-bold text-sm text-slate-800">{{ $settings['kadin_name'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}</h4>
                        <p class="text-[10px] text-green-600 font-semibold uppercase mt-0.5">{{ $settings['kadin_title'] ?? 'LURAH KANDANG JATI KULON' }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3 space-y-5 text-center lg:text-left reveal fade-left">
                <div class="inline-flex items-center gap-2 text-green-600 text-xs font-bold uppercase tracking-widest">
                    Sambutan {{ $settings['kadin_title'] ?? 'LURAH KANDANG JATI KULON' }}
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                    Melayani Warga Sepenuh Hati Menuju Kelurahan yang Maju, Sejahtera & Mandiri
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed max-w-3xl">
                    Selamat Datang di Portal Resmi <strong>{{ $settings['agency_name'] ?? 'KELURAHAN SIDOMUKTI' }} {{ $settings['regency_name'] ?? 'Kecamatan Kraksaan, Kabupaten Probolinggo' }}</strong>. Kami berkomitmen menyajikan pelayanan publik prima, kemudahan administrasi kependudukan dan pengurusan surat keterangan, transparansi kinerja kelurahan, serta pemberdayaan potensi ekonomi warga lokal.
                </p>
                <div class="pt-4 flex flex-wrap gap-4 items-center justify-center lg:justify-start">
                    <a href="{{ route('profil.visi-misi') }}" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                        Visi & Misi Kami <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
"""

# Fix Floating Stats Bar to no longer have -mt-12 and have a background
stats_html = stats_match.group(1) + "</section>"
stats_html = stats_html.replace('class="relative z-20 -mt-12"', 'class="relative z-20 py-12 bg-slate-50 border-t border-slate-100"')

# Fix Layanan
layanan_html = layanan_match.group(1) + "</section>"

# Fix Berita
berita_html = berita_match.group(1) + "</section>"

new_content = f"""@extends('layouts.app')

@section('content')

{hero_match.group(1)}</section>

{sambutan_html}

{stats_html}

{layanan_html}

{berita_html}

@endsection
"""

with open('resources/views/home.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_content)
