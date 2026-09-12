@extends('layouts.admin')

@section('title', 'Struktur Organisasi & Aparatur')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Struktur Organisasi & Aparatur</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola data pejabat, foto pas foto aparatur, NIP, serta diagram bagan struktur organisasi kelurahan.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-xl shadow-xs text-sm font-medium flex items-center gap-2">
    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
    <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: KEPALA KELURAHAN (LURAH) -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-slate-900"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">1. Kepala Kelurahan (Lurah)</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Foto Lurah (1:1 Pas Foto HD)</label>
                    <div class="mb-3">
                        @php
                            $lurahVal = $settings['foto_lurah'] ?? $settings['kadin_photo'] ?? '';
                            $lurahSrc = $lurahVal ? (\Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : Storage::url($lurahVal)) : 'https://ui-avatars.com/api/?name=Ahmad+Syarif&background=0f172a&color=fff&size=200';
                        @endphp
                        <img id="previewFotoLurah" src="{{ $lurahSrc }}" 
                             alt="Foto Lurah" class="w-32 h-32 object-cover rounded-2xl border-2 border-slate-300 shadow-sm mx-auto md:mx-0">
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <input type="file" name="foto_lurah" id="inputFotoLurah" data-ratio="1:1" data-preview="#previewFotoLurah" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer">
                            <button type="button" onclick="if(document.getElementById('inputFotoLurah').files.length){ window.CropHelper.open(document.getElementById('inputFotoLurah')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-3 py-1.5 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                                Potong (HD)
                            </button>
                        </div>
                        <input type="url" name="foto_lurah_url" value="{{ \Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : '' }}" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 font-mono" placeholder="Atau paste URL Foto Lurah">
                    </div>
                </div>

                <div class="md:col-span-2 space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_lurah" value="{{ $settings['nama_lurah'] ?? 'H. Ahmad Syarif, S.STP, M.Si' }}" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">NIP Kepala Kelurahan</label>
                        <input type="text" name="nip_lurah" value="{{ $settings['nip_lurah'] ?? '19780512 200212 1 003' }}" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan Resmi</label>
                        <input type="text" name="jabatan_lurah" value="{{ $settings['jabatan_lurah'] ?? 'Lurah Sidomukti' }}" 
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm font-semibold">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: KETUA LPMK -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">2. Lembaga Pemberdayaan Masyarakat (LPMK)</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Foto Ketua / Perwakilan LPMK</label>
                    <div class="mb-3">
                        @php
                            $lpmkVal = $settings['foto_lpmk'] ?? '';
                            $lpmkSrc = $lpmkVal ? (\Illuminate\Support\Str::startsWith($lpmkVal, ['http://', 'https://']) ? $lpmkVal : Storage::url($lpmkVal)) : 'https://ui-avatars.com/api/?name=Ketua+LPMK&background=10b981&color=fff&size=200';
                        @endphp
                        <img id="previewFotoLpmk" src="{{ $lpmkSrc }}" alt="Foto LPMK" class="w-28 h-28 object-cover rounded-2xl border-2 border-emerald-300 shadow-sm mx-auto md:mx-0">
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <input type="file" name="foto_lpmk" id="inputFotoLpmk" data-ratio="1:1" data-preview="#previewFotoLpmk" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200 transition cursor-pointer">
                            <button type="button" onclick="if(document.getElementById('inputFotoLpmk').files.length){ window.CropHelper.open(document.getElementById('inputFotoLpmk')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-3 py-1.5 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                                Potong (HD)
                            </button>
                        </div>
                        <input type="url" name="foto_lpmk_url" value="{{ \Illuminate\Support\Str::startsWith($lpmkVal, ['http://', 'https://']) ? $lpmkVal : '' }}" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 font-mono" placeholder="Atau paste URL Foto LPMK">
                    </div>
                </div>

                <div class="md:col-span-2 space-y-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Ketua LPMK</label>
                        <input type="text" name="nama_lpmk" value="{{ $settings['nama_lpmk'] ?? 'H. Moh. Ridwan, M.Pd' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lembaga</label>
                        <input type="text" name="jabatan_lpmk" value="{{ $settings['jabatan_lpmk'] ?? 'Lembaga Pemberdayaan Masyarakat (LPMK)' }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: SEKRETARIS KELURAHAN & KEPALA SEKSI (KASI) -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-6">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">3. Sekretariat & Kepala Seksi (Kasi)</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Sekretaris Kelurahan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Sekretaris Kelurahan</span>
                        <span class="text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-extrabold">Sekretariat</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $sekVal = $settings['foto_sekretaris'] ?? '';
                            $sekSrc = $sekVal ? (\Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : Storage::url($sekVal)) : 'https://ui-avatars.com/api/?name=Budi+Santoso&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoSekretaris" src="{{ $sekSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <input type="file" name="foto_sekretaris" id="inputFotoSekretaris" data-ratio="1:1" data-preview="#previewFotoSekretaris" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-50 file:text-blue-700">
                            <input type="url" name="foto_sekretaris_url" value="{{ \Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : '' }}" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_sekretaris" value="{{ $settings['nama_sekretaris'] ?? 'Budi Santoso, S.Sos' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                        <input type="text" name="nip_sekretaris" value="{{ $settings['nip_sekretaris'] ?? '19820315 200604 1 008' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Kasi Pemerintahan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Pemerintahan</span>
                        <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 1</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $pemVal = $settings['foto_kasi_pemerintahan'] ?? '';
                            $pemSrc = $pemVal ? (\Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : Storage::url($pemVal)) : 'https://ui-avatars.com/api/?name=Hendra+Setiawan&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiPem" src="{{ $pemSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <input type="file" name="foto_kasi_pemerintahan" id="inputFotoKasiPem" data-ratio="1:1" data-preview="#previewFotoKasiPem" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-amber-50 file:text-amber-800">
                            <input type="url" name="foto_kasi_pemerintahan_url" value="{{ \Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : '' }}" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_kasi_pemerintahan" value="{{ $settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan, S.AP' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                        <input type="text" name="nip_kasi_pemerintahan" value="{{ $settings['nip_kasi_pemerintahan'] ?? '19850620 200902 1 004' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Kasi Trantib -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Trantib (Ketentraman & Ketertiban)</span>
                        <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 2</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $trantibVal = $settings['foto_kasi_trantib'] ?? '';
                            $trantibSrc = $trantibVal ? (\Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : Storage::url($trantibVal)) : 'https://ui-avatars.com/api/?name=M+Rizky+Pratama&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiTrantib" src="{{ $trantibSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <input type="file" name="foto_kasi_trantib" id="inputFotoKasiTrantib" data-ratio="1:1" data-preview="#previewFotoKasiTrantib" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-800">
                            <input type="url" name="foto_kasi_trantib_url" value="{{ \Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : '' }}" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_kasi_trantib" value="{{ $settings['nama_kasi_trantib'] ?? 'M. Rizky Pratama, S.IP' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                        <input type="text" name="nip_kasi_trantib" value="{{ $settings['nip_kasi_trantib'] ?? '19880110 201101 1 002' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

                <!-- Kasi Pembangunan & Kesra -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Pembangunan & Kesra</span>
                        <span class="text-[10px] text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 3</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $kesraVal = $settings['foto_kasi_kesra'] ?? '';
                            $kesraSrc = $kesraVal ? (\Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : Storage::url($kesraVal)) : 'https://ui-avatars.com/api/?name=Nurul+Hidayah&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiKesra" src="{{ $kesraSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <input type="file" name="foto_kasi_kesra" id="inputFotoKasiKesra" data-ratio="1:1" data-preview="#previewFotoKasiKesra" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-purple-50 file:text-purple-800">
                            <input type="url" name="foto_kasi_kesra_url" value="{{ \Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : '' }}" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                        <input type="text" name="nama_kasi_kesra" value="{{ $settings['nama_kasi_kesra'] ?? 'Nurul Hidayah, SE., MM' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                        <input type="text" name="nip_kasi_kesra" value="{{ $settings['nip_kasi_kesra'] ?? '19870904 201001 2 005' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                    </div>
                </div>

            </div>
        </div>

        <!-- SECTION 4: GAMBAR BAGAN STRUKTUR ORGANISASI UTUH (OPSIONAL) -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-teal-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">4. Berkas Gambar Diagram Bagan Organisasi Utuh (Opsional)</h3>
            </div>

            <div class="space-y-4">
                @php
                    $baganVal = $settings['gambar_bagan_struktur'] ?? '';
                    $baganSrc = $baganVal ? (\Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : Storage::url($baganVal)) : '';
                @endphp
                @if($baganSrc)
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Bagan Saat Ini:</label>
                    <img id="previewBaganStruktur" src="{{ $baganSrc }}" class="max-h-64 rounded-xl border border-slate-300 shadow-sm mx-auto object-contain bg-white p-2">
                </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Unggah Gambar Diagram Bagan Organisasi Baru (PNG/JPG)</label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="gambar_bagan_struktur" id="inputBaganStruktur" data-ratio="16:9" data-preview="#previewBaganStruktur" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-800">
                        <button type="button" onclick="if(document.getElementById('inputBaganStruktur').files.length){ window.CropHelper.open(document.getElementById('inputBaganStruktur')); } else { alert('Pilih berkas diagram bagan terlebih dahulu!'); }" class="px-3.5 py-2 bg-white hover:bg-teal-50 text-slate-700 hover:text-teal-800 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                            Potong (HD)
                        </button>
                    </div>
                    <input type="url" name="gambar_bagan_struktur_url" value="{{ \Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : '' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-mono mt-2" placeholder="Atau paste URL Berkas Gambar Bagan">
                </div>
            </div>
        </div>

        <!-- SECTION 5: NARASI KETERANGAN STRUKTUR -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200/90 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
                <span class="w-3 h-3 rounded-full bg-slate-600"></span>
                <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide">5. Narasi & Keterangan Tambahan</h3>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Penjelasan Tugas Pokok & Keterangan Struktur</label>
                <textarea name="struktur_organisasi" rows="4" 
                          class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-sm leading-relaxed" 
                          placeholder="Penjelasan rincian tugas Sekretaris Kelurahan, Kasi Pemerintahan, Kasi Trantib, Kasi Kesra, dsb...">{{ $settings['struktur_organisasi'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="pt-4 flex items-center justify-between gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs uppercase tracking-wider py-3.5 px-8 rounded-xl shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Seluruh Aparatur & Struktur
            </button>
        </div>
    </form>
</div>
@endsection
