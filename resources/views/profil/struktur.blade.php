@extends('layouts.app')

@section('title', 'Struktur Organisasi - Kelurahan Sidomukti')

@section('content')
<div class="bg-slate-100/70 min-h-screen">

    <!-- Page Header (Deep Dark Theme matching portal standard) -->
    <div class="bg-[#0b1329] text-white border-b border-slate-800 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/4 -bottom-10 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 md:py-10 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex text-xs text-slate-400 mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1.5 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-emerald-400 transition font-medium">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-slate-400">Profil</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1.5 text-emerald-400 font-semibold">Struktur Organisasi</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-900/40 border border-emerald-500/30 rounded-full text-emerald-300 text-[11px] font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Bagan Struktur Pemerintahan
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-tight mb-3">
                    Struktur Organisasi Kelurahan Sidomukti
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed max-w-2xl">
                    Susunan kepemimpinan, sekretariat, seksi pelayanan, serta mitra lembaga di lingkungan Pemerintah Kelurahan Sidomukti.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto px-4 py-8 max-w-6xl space-y-8">

        @php
            // Extract settings data
            $lurahVal = $settings['foto_lurah'] ?? $settings['kadin_photo'] ?? '';
            $lurahSrc = $lurahVal ? (\Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : Storage::url($lurahVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_lurah'] ?? 'Ahmad Syarif') . '&background=0f172a&color=fff&size=200';
            $lurahNama = $settings['nama_lurah'] ?? 'H. Ahmad Syarif, S.STP, M.Si';
            $lurahNip = $settings['nip_lurah'] ?? '';
            $lurahJabatan = $settings['jabatan_lurah'] ?? 'Lurah Sidomukti';

            $sekVal = $settings['foto_sekretaris'] ?? '';
            $sekSrc = $sekVal ? (\Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : Storage::url($sekVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_sekretaris'] ?? 'Budi Santoso') . '&background=64748b&color=fff&size=200';
            $sekNama = $settings['nama_sekretaris'] ?? 'Budi Santoso, S.Sos';
            $sekNip = $settings['nip_sekretaris'] ?? '';
            $sekJabatan = $settings['jabatan_sekretaris'] ?? 'Sekretaris Kelurahan Sidomukti';
            $sekSeksi = $settings['seksi_sekretaris'] ?? 'Kelompok Jabatan Fungsional';

            $pemVal = $settings['foto_kasi_pemerintahan'] ?? '';
            $pemSrc = $pemVal ? (\Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : Storage::url($pemVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan') . '&background=64748b&color=fff&size=200';
            $pemNama = $settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan, S.AP';
            $pemNip = $settings['nip_kasi_pemerintahan'] ?? '';
            $pemJabatan = $settings['jabatan_kasi_pemerintahan'] ?? 'Kasi Pemerintahan';
            $pemSeksi = $settings['seksi_kasi_pemerintahan'] ?? 'Kelompok Jabatan Fungsional';

            $trantibVal = $settings['foto_kasi_trantib'] ?? '';
            $trantibSrc = $trantibVal ? (\Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : Storage::url($trantibVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_kasi_trantib'] ?? 'M Rizky Pratama') . '&background=64748b&color=fff&size=200';
            $trantibNama = $settings['nama_kasi_trantib'] ?? 'M. Rizky Pratama, S.IP';
            $trantibNip = $settings['nip_kasi_trantib'] ?? '';
            $trantibJabatan = $settings['jabatan_kasi_trantib'] ?? 'Kasi Trantib (Ketentraman & Ketertiban)';
            $trantibSeksi = $settings['seksi_kasi_trantib'] ?? 'Kelompok Jabatan Fungsional';

            $kesraVal = $settings['foto_kasi_kesra'] ?? '';
            $kesraSrc = $kesraVal ? (\Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : Storage::url($kesraVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($settings['nama_kasi_kesra'] ?? 'Nurul Hidayah') . '&background=64748b&color=fff&size=200';
            $kesraNama = $settings['nama_kasi_kesra'] ?? 'Nurul Hidayah, SE., MM';
            $kesraNip = $settings['nip_kasi_kesra'] ?? '';
            $kesraJabatan = $settings['jabatan_kasi_kesra'] ?? 'Kasi Pembangunan & Kesra';
            $kesraSeksi = $settings['seksi_kasi_kesra'] ?? 'Kelompok Jabatan Fungsional';

            $baganVal = $settings['gambar_bagan_struktur'] ?? '';
            $baganSrc = $baganVal ? (\Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : Storage::url($baganVal)) : '';

            $aparaturTambahan = json_decode($settings['aparatur_tambahan'] ?? '[]', true) ?: [];
        @endphp

        <!-- Chart Container -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-12 shadow-sm overflow-x-auto">
            <div class="min-w-[850px] flex flex-col items-center">

                <!-- Level 1 (Lurah) -->
                <div class="relative flex flex-col items-center z-10 mt-4">

                    <img src="{{ $lurahSrc }}" alt="{{ $lurahNama }}" class="w-28 h-28 rounded-full border-[4px] border-slate-900 shadow-md mb-3 object-cover bg-slate-100">
                    <h4 class="font-extrabold text-slate-900 text-sm md:text-base">{{ $lurahNama }}</h4>
                    @if($lurahNip)
                    <p class="text-[11px] font-mono text-slate-500 font-medium">NIP. {{ $lurahNip }}</p>
                    @endif
                    <div class="bg-slate-900 text-white text-[9.5px] font-extrabold px-4 py-1.5 rounded-full mt-1.5 uppercase tracking-widest shadow-2xs">
                        {{ $lurahJabatan }}
                    </div>
                </div>

                <div class="w-px h-10 bg-slate-300 my-1"></div>



                <!-- Level 3 (Branches) -->
                <div class="w-full relative pt-6 mt-1">
                    <div class="absolute top-0 left-[12.5%] right-[12.5%] h-px bg-slate-300"></div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 place-content-center">

                        <!-- Col 1 (Sekretaris) -->
                        <div class="flex flex-col items-center text-center relative z-10 group">
                            <div class="w-px h-6 bg-slate-300 absolute -top-6 left-1/2 -translate-x-1/2"></div>
                            <img src="{{ $sekSrc }}" alt="{{ $sekNama }}" class="w-20 h-20 rounded-full border-2 border-slate-300 shadow-2xs mb-3 bg-slate-50 object-cover group-hover:-translate-y-1 transition-transform">
                            <h4 class="font-bold text-slate-900 text-xs mb-0.5">{{ $sekNama }}</h4>
                            @if($sekNip)
                            <p class="text-[10px] font-mono text-slate-500 mb-1">NIP. {{ $sekNip }}</p>
                            @endif
                            <div class="bg-slate-900 text-white text-[8px] font-extrabold px-2 py-1.5 rounded-md w-full uppercase tracking-wider leading-relaxed shadow-2xs mb-2">
                                {{ $sekJabatan }}
                            </div>
                            <div class="border border-slate-200 rounded px-2 py-1.5 bg-slate-50/50 w-full mt-auto">
                                <span class="text-[7.5px] text-slate-500 uppercase font-bold tracking-wider">{{ $sekSeksi }}</span>
                            </div>
                        </div>

                        <!-- Col 2 (Kasi Pem) -->
                        <div class="flex flex-col items-center text-center relative z-10 group">
                            <div class="w-px h-6 bg-slate-300 absolute -top-6 left-1/2 -translate-x-1/2"></div>
                            <img src="{{ $pemSrc }}" alt="{{ $pemNama }}" class="w-20 h-20 rounded-full border-2 border-slate-300 shadow-2xs mb-3 bg-slate-50 object-cover group-hover:-translate-y-1 transition-transform">
                            <h4 class="font-bold text-slate-900 text-xs mb-0.5">{{ $pemNama }}</h4>
                            @if($pemNip)
                            <p class="text-[10px] font-mono text-slate-500 mb-1">NIP. {{ $pemNip }}</p>
                            @endif
                            <div class="bg-slate-900 text-white text-[8px] font-extrabold px-2 py-1.5 rounded-md w-full uppercase tracking-wider leading-relaxed shadow-2xs mb-2">
                                {{ $pemJabatan }}
                            </div>
                            <div class="border border-slate-200 rounded px-2 py-1.5 bg-slate-50/50 w-full mt-auto">
                                <span class="text-[7.5px] text-slate-500 uppercase font-bold tracking-wider">{{ $pemSeksi }}</span>
                            </div>
                        </div>

                        <!-- Col 3 (Kasi Trantib) -->
                        <div class="flex flex-col items-center text-center relative z-10 group">
                            <div class="w-px h-6 bg-slate-300 absolute -top-6 left-1/2 -translate-x-1/2"></div>
                            <img src="{{ $trantibSrc }}" alt="{{ $trantibNama }}" class="w-20 h-20 rounded-full border-2 border-slate-300 shadow-2xs mb-3 bg-slate-50 object-cover group-hover:-translate-y-1 transition-transform">
                            <h4 class="font-bold text-slate-900 text-xs mb-0.5">{{ $trantibNama }}</h4>
                            @if($trantibNip)
                            <p class="text-[10px] font-mono text-slate-500 mb-1">NIP. {{ $trantibNip }}</p>
                            @endif
                            <div class="bg-slate-900 text-white text-[8px] font-extrabold px-2 py-1.5 rounded-md w-full uppercase tracking-wider leading-relaxed shadow-2xs mb-2">
                                {{ $trantibJabatan }}
                            </div>
                            <div class="border border-slate-200 rounded px-2 py-1.5 bg-slate-50/50 w-full mt-auto">
                                <span class="text-[7.5px] text-slate-500 uppercase font-bold tracking-wider">{{ $trantibSeksi }}</span>
                            </div>
                        </div>

                        <!-- Col 4 (Kasi Kesra) -->
                        <div class="flex flex-col items-center text-center relative z-10 group">
                            <div class="w-px h-6 bg-slate-300 absolute -top-6 left-1/2 -translate-x-1/2"></div>
                            <img src="{{ $kesraSrc }}" alt="{{ $kesraNama }}" class="w-20 h-20 rounded-full border-2 border-slate-300 shadow-2xs mb-3 bg-slate-50 object-cover group-hover:-translate-y-1 transition-transform">
                            <h4 class="font-bold text-slate-900 text-xs mb-0.5">{{ $kesraNama }}</h4>
                            @if($kesraNip)
                            <p class="text-[10px] font-mono text-slate-500 mb-1">NIP. {{ $kesraNip }}</p>
                            @endif
                            <div class="bg-slate-900 text-white text-[8px] font-extrabold px-2 py-1.5 rounded-md w-full uppercase tracking-wider leading-relaxed shadow-2xs mb-2">
                                {{ $kesraJabatan }}
                            </div>
                            <div class="border border-slate-200 rounded px-2 py-1.5 bg-slate-50/50 w-full mt-auto">
                                <span class="text-[7.5px] text-slate-500 uppercase font-bold tracking-wider">{{ $kesraSeksi }}</span>
                            </div>
                        </div>

                        <!-- Dynamic Aparatur Tambahan -->
                        @foreach($aparaturTambahan as $anggota)
                        @php
                            $anggotaVal = $anggota['foto'] ?? '';
                            if (!empty($anggota['foto_url'])) {
                                $anggotaSrc = $anggota['foto_url'];
                            } else {
                                $anggotaSrc = $anggotaVal ? (\Illuminate\Support\Str::startsWith($anggotaVal, ['http://', 'https://']) ? $anggotaVal : Storage::url($anggotaVal)) : 'https://ui-avatars.com/api/?name=' . urlencode($anggota['nama'] ?? 'Anggota') . '&background=64748b&color=fff&size=200';
                            }
                        @endphp
                        <div class="flex flex-col items-center text-center relative z-10 group">
                            <div class="w-px h-6 bg-slate-300 absolute -top-6 left-1/2 -translate-x-1/2"></div>
                            <img src="{{ $anggotaSrc }}" alt="{{ $anggota['nama'] }}" class="w-20 h-20 rounded-full border-2 border-slate-300 shadow-2xs mb-3 bg-slate-50 object-cover group-hover:-translate-y-1 transition-transform">
                            <h4 class="font-bold text-slate-900 text-xs mb-0.5">{{ $anggota['nama'] }}</h4>
                            @if(!empty($anggota['nip']))
                            <p class="text-[10px] font-mono text-slate-500 mb-1">NIP. {{ $anggota['nip'] }}</p>
                            @endif
                            <div class="bg-slate-900 text-white text-[8px] font-extrabold px-2 py-1.5 rounded-md w-full uppercase tracking-wider leading-relaxed shadow-2xs mb-2">
                                {!! nl2br(e($anggota['jabatan'])) !!}
                            </div>
                            <div class="border border-slate-200 rounded px-2 py-1.5 bg-slate-50/50 w-full mt-auto">
                                <span class="text-[7.5px] text-slate-500 uppercase font-bold tracking-wider">{{ !empty($anggota['seksi']) ? $anggota['seksi'] : 'Kelompok Jabatan Fungsional' }}</span>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>

        <!-- Berkas Diagram Bagan Organisasi Utuh (Jika Diunggah Admin) -->
        @if($baganSrc)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Diagram Bagan Resmi Struktur Organisasi
            </h3>
            <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-50 p-2">
                <img src="{{ $baganSrc }}" alt="Bagan Struktur Organisasi Sidomukti" class="w-full h-auto object-contain mx-auto rounded-lg">
            </div>
        </div>
        @endif


    </div>

</div>
@endsection
