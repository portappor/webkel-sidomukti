@extends('layouts.admin')

@section('title', 'Kelola Aparatur & Struktur Organisasi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Aparatur & Struktur Organisasi</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola data pejabat, foto pas foto aparatur, NIP, serta diagram bagan struktur organisasi kelurahan.</p>
    </div>
</div>



<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-6 md:p-8">
    <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateAparaturForm(this)" class="space-y-8">
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
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Foto Lurah (1:1 Pas Foto HD) <span class="text-[10px] font-medium text-slate-400 normal-case">(Maks 5MB)</span></label>
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
                            @if(!empty($settings['foto_lurah']) || !empty($settings['kadin_photo']))
                            <button type="submit" form="delete-foto-lurah" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Lurah?')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-xl border border-rose-200 text-xs font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                            @endif
                        </div>
                        <input type="url" name="foto_lurah_url" value="{{ \Illuminate\Support\Str::startsWith($lurahVal, ['http://', 'https://']) ? $lurahVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3 py-1.5 text-xs rounded-xl border border-slate-300 font-mono" placeholder="Atau paste URL Foto Lurah">
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
                        <span>Sekretaris Kelurahan <span class="text-[9px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                        <span class="text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-extrabold">Sekretariat</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $sekVal = $settings['foto_sekretaris'] ?? '';
                            $sekSrc = $sekVal ? (\Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : Storage::url($sekVal)) : 'https://ui-avatars.com/api/?name=Budi+Santoso&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoSekretaris" src="{{ $sekSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_sekretaris" id="inputFotoSekretaris" data-ratio="1:1" data-preview="#previewFotoSekretaris" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-blue-50 file:text-blue-700">
                                <button type="button" onclick="if(document.getElementById('inputFotoSekretaris').files.length){ window.CropHelper.open(document.getElementById('inputFotoSekretaris')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-blue-50 text-slate-700 hover:text-blue-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_sekretaris']))
                                <button type="submit" form="delete-foto-sekretaris" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Sekretaris?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_sekretaris_url" value="{{ \Illuminate\Support\Str::startsWith($sekVal, ['http://', 'https://']) ? $sekVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_sekretaris" value="{{ $settings['nama_sekretaris'] ?? 'Budi Santoso, S.Sos' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                            <input type="text" name="nip_sekretaris" value="{{ $settings['nip_sekretaris'] ?? '19820315 200604 1 008' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan Spesifik</label>
                            <input type="text" name="jabatan_sekretaris" value="{{ $settings['jabatan_sekretaris'] ?? 'Sekretaris Kelurahan Sidomukti' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Lembaga / Kelompok</label>
                            <input type="text" name="seksi_sekretaris" value="{{ $settings['seksi_sekretaris'] ?? 'Kelompok Jabatan Fungsional' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                    </div>
                </div>

                <!-- Kasi Pemerintahan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Pemerintahan <span class="text-[9px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                        <span class="text-[10px] text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 1</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $pemVal = $settings['foto_kasi_pemerintahan'] ?? '';
                            $pemSrc = $pemVal ? (\Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : Storage::url($pemVal)) : 'https://ui-avatars.com/api/?name=Hendra+Setiawan&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiPem" src="{{ $pemSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_kasi_pemerintahan" id="inputFotoKasiPem" data-ratio="1:1" data-preview="#previewFotoKasiPem" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-amber-50 file:text-amber-800">
                                <button type="button" onclick="if(document.getElementById('inputFotoKasiPem').files.length){ window.CropHelper.open(document.getElementById('inputFotoKasiPem')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-amber-50 text-slate-700 hover:text-amber-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_kasi_pemerintahan']))
                                <button type="submit" form="delete-foto-kasi-pem" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Kasi Pemerintahan?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_kasi_pemerintahan_url" value="{{ \Illuminate\Support\Str::startsWith($pemVal, ['http://', 'https://']) ? $pemVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_kasi_pemerintahan" value="{{ $settings['nama_kasi_pemerintahan'] ?? 'Hendra Setiawan, S.AP' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                            <input type="text" name="nip_kasi_pemerintahan" value="{{ $settings['nip_kasi_pemerintahan'] ?? '19850620 200902 1 004' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan Spesifik</label>
                            <input type="text" name="jabatan_kasi_pemerintahan" value="{{ $settings['jabatan_kasi_pemerintahan'] ?? 'Kasi Pemerintahan' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Lembaga / Kelompok</label>
                            <input type="text" name="seksi_kasi_pemerintahan" value="{{ $settings['seksi_kasi_pemerintahan'] ?? 'Kelompok Jabatan Fungsional' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                    </div>
                </div>

                <!-- Kasi Trantib -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Trantib (Ketentraman & Ketertiban) <span class="text-[9px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                        <span class="text-[10px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 2</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $trantibVal = $settings['foto_kasi_trantib'] ?? '';
                            $trantibSrc = $trantibVal ? (\Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : Storage::url($trantibVal)) : 'https://ui-avatars.com/api/?name=M+Rizky+Pratama&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiTrantib" src="{{ $trantibSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_kasi_trantib" id="inputFotoKasiTrantib" data-ratio="1:1" data-preview="#previewFotoKasiTrantib" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-50 file:text-emerald-800">
                                <button type="button" onclick="if(document.getElementById('inputFotoKasiTrantib').files.length){ window.CropHelper.open(document.getElementById('inputFotoKasiTrantib')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_kasi_trantib']))
                                <button type="submit" form="delete-foto-kasi-trantib" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Kasi Trantib?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_kasi_trantib_url" value="{{ \Illuminate\Support\Str::startsWith($trantibVal, ['http://', 'https://']) ? $trantibVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_kasi_trantib" value="{{ $settings['nama_kasi_trantib'] ?? 'M. Rizky Pratama, S.IP' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                            <input type="text" name="nip_kasi_trantib" value="{{ $settings['nip_kasi_trantib'] ?? '19880110 201101 1 002' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan Spesifik</label>
                            <input type="text" name="jabatan_kasi_trantib" value="{{ $settings['jabatan_kasi_trantib'] ?? 'Kasi Trantib (Ketentraman & Ketertiban)' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Lembaga / Kelompok</label>
                            <input type="text" name="seksi_kasi_trantib" value="{{ $settings['seksi_kasi_trantib'] ?? 'Kelompok Jabatan Fungsional' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                    </div>
                </div>

                <!-- Kasi Pembangunan & Kesra -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-sm text-slate-800 border-b pb-2 flex items-center justify-between">
                        <span>Kasi Pembangunan & Kesra <span class="text-[9px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></span>
                        <span class="text-[10px] text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full font-extrabold">Seksi 3</span>
                    </h4>
                    <div class="flex items-center gap-4">
                        @php
                            $kesraVal = $settings['foto_kasi_kesra'] ?? '';
                            $kesraSrc = $kesraVal ? (\Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : Storage::url($kesraVal)) : 'https://ui-avatars.com/api/?name=Nurul+Hidayah&background=64748b&color=fff&size=150';
                        @endphp
                        <img id="previewFotoKasiKesra" src="{{ $kesraSrc }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0">
                        <div class="w-full space-y-2">
                            <div class="flex items-center gap-2">
                                <input type="file" name="foto_kasi_kesra" id="inputFotoKasiKesra" data-ratio="1:1" data-preview="#previewFotoKasiKesra" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-purple-50 file:text-purple-800">
                                <button type="button" onclick="if(document.getElementById('inputFotoKasiKesra').files.length){ window.CropHelper.open(document.getElementById('inputFotoKasiKesra')); } else { alert('Pilih berkas foto terlebih dahulu!'); }" class="px-2 py-1 bg-white hover:bg-purple-50 text-slate-700 hover:text-purple-700 rounded-lg border border-slate-300 text-[11px] font-bold transition shrink-0 shadow-2xs">
                                    Potong
                                </button>
                                @if(!empty($settings['foto_kasi_kesra']))
                                <button type="submit" form="delete-foto-kasi-kesra" onclick="return confirm('Apakah Anda yakin ingin menghapus foto Kasi Pembangunan & Kesra?')" class="px-2 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-lg border border-rose-200 text-[11px] font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                                @endif
                            </div>
                            <input type="url" name="foto_kasi_kesra_url" value="{{ \Illuminate\Support\Str::startsWith($kesraVal, ['http://', 'https://']) ? $kesraVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-2.5 py-1 text-xs rounded-lg border border-slate-300 font-mono" placeholder="atau paste URL foto">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_kasi_kesra" value="{{ $settings['nama_kasi_kesra'] ?? 'Nurul Hidayah, SE., MM' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">NIP</label>
                            <input type="text" name="nip_kasi_kesra" value="{{ $settings['nip_kasi_kesra'] ?? '19870904 201001 2 005' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jabatan Spesifik</label>
                            <input type="text" name="jabatan_kasi_kesra" value="{{ $settings['jabatan_kasi_kesra'] ?? 'Kasi Pembangunan & Kesra' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Lembaga / Kelompok</label>
                            <input type="text" name="seksi_kasi_kesra" value="{{ $settings['seksi_kasi_kesra'] ?? 'Kelompok Jabatan Fungsional' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Dynamic Additional Aparatur -->
            <div x-data="aparaturTambahan()" class="mt-8 pt-6 border-t border-slate-200/80">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h4 class="font-extrabold text-sm text-slate-800">Struktur Aparatur / Staf Tambahan</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Tambahkan staf atau anggota lain yang tidak termasuk dalam 4 jabatan utama di atas.</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <template x-for="(anggota, index) in listAnggota" :key="index">
                        <div class="relative bg-white border border-slate-200/80 rounded-2xl p-4 flex flex-col md:flex-row gap-5 items-start shadow-sm transition hover:shadow-md hover:border-emerald-200 group">
                            <!-- Delete Button -->
                            <button type="button" @click="hapusAnggota(index)" class="absolute -top-2.5 -right-2.5 bg-white text-rose-400 hover:text-white hover:bg-rose-500 p-1.5 rounded-full shadow-sm border border-slate-200 hover:border-rose-500 transition z-10 opacity-0 md:group-hover:opacity-100 focus:opacity-100 max-md:opacity-100" title="Hapus Anggota">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            
                            <!-- Photo Section -->
                            <div class="flex flex-col items-center gap-2.5 w-full md:w-32 shrink-0">
                                <div class="w-20 h-20 rounded-full border-2 border-slate-100 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                                    <template x-if="anggota.foto && !anggota.foto_url">
                                        <img :src="anggota.foto.startsWith('http') ? anggota.foto : '/storage/' + anggota.foto" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="anggota.foto_url">
                                        <img :src="anggota.foto_url" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!anggota.foto && !anggota.foto_url">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </template>
                                </div>
                                <div class="w-full relative text-center space-y-1.5">
                                    <input type="hidden" :name="`aparatur_tambahan[${index}][foto_old]`" :value="anggota.foto">
                                    <label class="cursor-pointer inline-block w-full">
                                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1.5 rounded-lg hover:bg-emerald-100 border border-emerald-100 transition block shadow-2xs">Unggah Foto</span>
                                        <input type="file" :name="`aparatur_tambahan[${index}][foto_file]`" accept="image/*" class="hidden">
                                    </label>
                                    <input type="url" :name="`aparatur_tambahan[${index}][foto_url]`" x-model="anggota.foto_url" @change="validateImageUrlInput($event.target)" class="w-full px-2 py-1.5 text-[10px] rounded-lg border border-slate-200 font-mono text-center placeholder-slate-400 bg-slate-50 focus:bg-white" placeholder="atau URL Foto...">
                                </div>
                            </div>

                            <!-- Info Section -->
                            <div class="w-full space-y-3.5 pt-1">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Lengkap & Gelar</label>
                                        <input type="text" :name="`aparatur_tambahan[${index}][nama]`" x-model="anggota.nama" placeholder="Cth: Budi Santoso, S.Kom" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition" required>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">NIP (Opsional)</label>
                                        <input type="text" :name="`aparatur_tambahan[${index}][nip]`" x-model="anggota.nip" placeholder="Cth: 19900101 202012 1 001" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jabatan Spesifik</label>
                                        <input type="text" :name="`aparatur_tambahan[${index}][jabatan]`" x-model="anggota.jabatan" placeholder="Cth: Staf Pelayanan Administrasi" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition" required>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Bagian / Seksi (Opsional)</label>
                                        <input type="text" :name="`aparatur_tambahan[${index}][seksi]`" x-model="anggota.seksi" placeholder="Cth: Seksi Pemerintahan" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <button type="button" @click="tambahAnggota()" class="w-full py-3.5 border-2 border-dashed border-slate-300 hover:border-emerald-400 bg-slate-50/50 hover:bg-emerald-50/50 text-slate-500 hover:text-emerald-600 rounded-2xl text-xs font-bold transition flex items-center justify-center gap-2 group">
                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Staf / Anggota Baru
                    </button>
                </div>
                <input type="hidden" name="aparatur_tambahan_hapus_semua" value="1" :disabled="listAnggota.length > 0">
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
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Unggah Gambar Diagram Bagan Organisasi Baru (PNG/JPG) <span class="text-[10px] font-medium text-slate-400 normal-case">(Maks 5MB)</span></label>
                    <div class="flex items-center gap-3">
                        <input type="file" name="gambar_bagan_struktur" id="inputBaganStruktur" data-ratio="16:9" data-preview="#previewBaganStruktur" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-teal-800">
                        <button type="button" onclick="if(document.getElementById('inputBaganStruktur').files.length){ window.CropHelper.open(document.getElementById('inputBaganStruktur')); } else { alert('Pilih berkas diagram bagan terlebih dahulu!'); }" class="px-3.5 py-2 bg-white hover:bg-teal-50 text-slate-700 hover:text-teal-800 rounded-xl border border-slate-300 text-xs font-bold transition shrink-0 shadow-2xs">
                            Potong (HD)
                        </button>
                        @if(!empty($settings['gambar_bagan_struktur']))
                        <button type="submit" form="delete-gambar-bagan" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar Diagram Bagan Organisasi?')" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 hover:text-rose-700 rounded-xl border border-rose-200 text-xs font-bold transition shrink-0 shadow-2xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Bagan
                        </button>
                        @endif
                    </div>
                    <input type="url" name="gambar_bagan_struktur_url" value="{{ \Illuminate\Support\Str::startsWith($baganVal, ['http://', 'https://']) ? $baganVal : '' }}" onchange="validateImageUrlInput(this)" onblur="validateImageUrlInput(this)" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-mono mt-2" placeholder="Atau paste URL Berkas Gambar Bagan">
                </div>
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

<!-- Forms Hidden untuk Hapus Foto Setting Aparatur -->
@if(!empty($settings['foto_lurah']) || !empty($settings['kadin_photo']))
<form id="delete-foto-lurah" action="{{ route('dashboard.settings.destroy-key', 'foto_lurah') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_lpmk']))
<form id="delete-foto-lpmk" action="{{ route('dashboard.settings.destroy-key', 'foto_lpmk') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_sekretaris']))
<form id="delete-foto-sekretaris" action="{{ route('dashboard.settings.destroy-key', 'foto_sekretaris') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_kasi_pemerintahan']))
<form id="delete-foto-kasi-pem" action="{{ route('dashboard.settings.destroy-key', 'foto_kasi_pemerintahan') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_kasi_trantib']))
<form id="delete-foto-kasi-trantib" action="{{ route('dashboard.settings.destroy-key', 'foto_kasi_trantib') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['foto_kasi_kesra']))
<form id="delete-foto-kasi-kesra" action="{{ route('dashboard.settings.destroy-key', 'foto_kasi_kesra') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@if(!empty($settings['gambar_bagan_struktur']))
<form id="delete-gambar-bagan" action="{{ route('dashboard.settings.destroy-key', 'gambar_bagan_struktur') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="no-referrer"></script>
<script>
    window.validateImageUrlInput = function(input) {
        const val = input.value ? input.value.trim() : '';
        if (!val) return true;

        const isImageUrl = /^https?:\/\/.+/i.test(val) && /\.(jpe?g|png|webp|gif|svg)($|\?|#)/i.test(val);
        if (!isImageUrl) {
            input.value = '';
            input.dispatchEvent(new Event('input'));
            alert('🚫 AKSES DITOLAK!\n\nTautan URL foto \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan URL berkas Foto / Gambar (berakhiran .jpg, .png, .jpeg, .webp, .gif, .svg) yang diperbolehkan!');
            return false;
        }
        return true;
    };

    window.validateAparaturForm = function(form) {
        const fileInputs = form.querySelectorAll('input[type="file"][accept*="image"]');
        for (let input of fileInputs) {
            if (input.files && input.files.length > 0) {
                if (!validateImageUpload(input)) {
                    return false;
                }
            }
        }

        const urlInputs = [
            'foto_lurah_url',
            'foto_lpmk_url',
            'foto_sekretaris_url',
            'foto_kasi_pemerintahan_url',
            'foto_kasi_trantib_url',
            'foto_kasi_kesra_url',
            'gambar_bagan_struktur_url'
        ];

        for (let name of urlInputs) {
            const input = form.querySelector(`input[name="${name}"]`);
            if (input && input.value.trim() !== '') {
                if (!validateImageUrlInput(input)) {
                    return false;
                }
            }
        }

        return true;
    };

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#struktur_organisasi',
                height: 450,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media table | preview fullscreen code',
                content_style: 'body { font-family: Inter, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.6; color: #334155; } ol { list-style-type: decimal; padding-left: 1.5rem; } ul { list-style-type: disc; padding-left: 1.5rem; } li { margin-bottom: 0.375rem; }',
                branding: false,
                promotion: false,
                setup: function (editor) {
                    editor.on('change keyup blur', function () {
                        editor.save();
                    });
                }
            });
        }
    });
    document.addEventListener('alpine:init', () => {
        Alpine.data('aparaturTambahan', () => ({
            listAnggota: @json(json_decode($settings['aparatur_tambahan'] ?? '[]')),
            tambahAnggota() {
                this.listAnggota.push({
                    seksi: '',
                    nama: '',
                    jabatan: '',
                    nip: '',
                    foto: '',
                    foto_url: ''
                });
            },
            hapusAnggota(index) {
                if(confirm('Yakin ingin menghapus anggota tambahan ini?')) {
                    this.listAnggota.splice(index, 1);
                }
            }
        }));
    });
</script>
@endpush
