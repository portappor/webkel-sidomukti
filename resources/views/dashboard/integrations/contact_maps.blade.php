@extends('layouts.admin')

@section('title', 'Kelola Informasi Kontak & Google Maps')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Informasi Kontak & Google Maps</h2>
        <p class="text-slate-500 text-sm">Kelola informasi alamat fisik kantor kelurahan, telepon resmi, email, serta sematan peta navigasi lokasi Google Maps.</p>
    </div>
    <div>
        <a href="{{ route('contact') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            Lihat Halaman Kontak Publik
        </a>
    </div>
</div>



<form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateContactMapsForm(this)" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Form Input Kontak -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Informasi Kontak & Jam Operasional</h3>
                            <p class="text-slate-500 text-xs">Telepon kantor, WhatsApp hotline, email resmi, alamat, dan jam pelayanan publik.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Telepon Kantor Resmi</label>
                            <input type="text" name="telepon" value="{{ $settings['telepon'] ?? '(0335) 123456' }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: (0335) 123456">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nomor WhatsApp Hotline</label>
                            <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '0812 3456 7890' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: 0812 3456 7890">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Email Resmi Kelurahan</label>
                            <input type="email" name="email" value="{{ $settings['email'] ?? 'info@sidomukti.desa.id' }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800" placeholder="Contoh: info@sidomukti.desa.id">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Lengkap Fisik Kantor</label>
                        <textarea name="alamat" rows="2" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800">{{ $settings['alamat'] ?? 'Jl. Raya Sidomukti No. 10, Kelurahan Sidomukti, Kecamatan Kraksaan, Kabupaten Probolinggo, Jawa Timur 67282' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5" x-data="{ 
                        jamSeninKamisMode: '{{ in_array($settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB', ['07.30 - 15.00 WIB', '07.30 - 15.30 WIB', '08.00 - 14.00 WIB', '08.00 - 15.00 WIB', '08.00 - 16.00 WIB', '24 Jam (Layanan Online Mandiri)']) ? ($settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB') : 'custom' }}',
                        valSeninKamis: '{{ addslashes($settings['jam_layanan_senin_kamis'] ?? '07.30 - 15.00 WIB') }}',
                        jamJumatMode: '{{ in_array($settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB', ['07.30 - 11.30 WIB', '07.30 - 11.00 WIB', '08.00 - 11.30 WIB', '07.30 - 14.30 WIB', '08.00 - 15.00 WIB', '24 Jam (Layanan Online Mandiri)']) ? ($settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB') : 'custom' }}',
                        valJumat: '{{ addslashes($settings['jam_layanan_jumat'] ?? '07.30 - 11.30 WIB') }}'
                    }">
                        <!-- Jam Kerja Senin - Kamis -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jam Kerja Pelayanan (Senin - Kamis)</label>
                            <select x-model="jamSeninKamisMode" @change="if(jamSeninKamisMode !== 'custom') valSeninKamis = jamSeninKamisMode" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800 bg-white shadow-xs">
                                <option value="07.30 - 15.00 WIB">07.30 - 15.00 WIB (Standar Pemkab)</option>
                                <option value="07.30 - 15.30 WIB">07.30 - 15.30 WIB</option>
                                <option value="08.00 - 14.00 WIB">08.00 - 14.00 WIB</option>
                                <option value="08.00 - 15.00 WIB">08.00 - 15.00 WIB</option>
                                <option value="08.00 - 16.00 WIB">08.00 - 16.00 WIB</option>
                                <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                                <option value="custom">-- Ketik Jam Kustom --</option>
                            </select>
                            <input type="hidden" name="jam_layanan_senin_kamis" :value="jamSeninKamisMode === 'custom' ? valSeninKamis : jamSeninKamisMode">
                            <div x-show="jamSeninKamisMode === 'custom'" x-collapse class="mt-2">
                                <input type="text" x-model="valSeninKamis" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium text-slate-800" placeholder="Ketik format jam khusus...">
                            </div>
                        </div>

                        <!-- Jam Kerja Jumat -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jam Kerja Pelayanan (Jumat)</label>
                            <select x-model="jamJumatMode" @change="if(jamJumatMode !== 'custom') valJumat = jamJumatMode" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-medium text-slate-800 bg-white shadow-xs">
                                <option value="07.30 - 11.30 WIB">07.30 - 11.30 WIB (Standar Pemkab)</option>
                                <option value="07.30 - 11.00 WIB">07.30 - 11.00 WIB</option>
                                <option value="08.00 - 11.30 WIB">08.00 - 11.30 WIB</option>
                                <option value="07.30 - 14.30 WIB">07.30 - 14.30 WIB</option>
                                <option value="08.00 - 15.00 WIB">08.00 - 15.00 WIB</option>
                                <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                                <option value="custom">-- Ketik Jam Kustom --</option>
                            </select>
                            <input type="hidden" name="jam_layanan_jumat" :value="jamJumatMode === 'custom' ? valJumat : jamJumatMode">
                            <div x-show="jamJumatMode === 'custom'" x-collapse class="mt-2">
                                <input type="text" x-model="valJumat" class="w-full px-4 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-medium text-slate-800" placeholder="Ketik format jam khusus...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Settings Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Pengaturan Kode QR Dinamis Footer</h3>
                            <p class="text-slate-500 text-xs">Kelola gambar Kode QR custom, URL tujuan scan, serta teks label keterangan di footer website.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Unggah File Gambar Kode QR Custom (Opsional) <span class="text-[10px] font-medium text-slate-400 normal-case ml-1">(Maks 5MB)</span></label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                            @if(!empty($settings['qr_code_image']))
                                <div class="relative group shrink-0">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($settings['qr_code_image'], 'http') ? $settings['qr_code_image'] : asset('storage/' . $settings['qr_code_image']) }}" alt="QR Code Custom" class="w-20 h-20 object-contain p-1 border border-slate-300 rounded-xl bg-white shadow-xs">
                                </div>
                            @endif
                            <div class="flex-grow w-full">
                                <input type="file" name="qr_code_image" accept="image/*" onchange="validateImageUpload(this)" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 transition cursor-pointer">
                                <p class="text-[11px] text-slate-400 mt-1">Unggah file PNG/JPG/WEBP Kode QR khusus. Jika tidak diunggah, sistem otomatis me-render Kode QR generator dari URL tujuan di bawah.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">URL Tujuan Scan Kode QR</label>
                        <input type="url" name="qr_code_destination_url" value="{{ $settings['qr_code_destination_url'] ?? url('/') }}" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 transition font-mono text-slate-800" placeholder="{{ url('/') }}">
                        <p class="text-[11px] text-slate-400 mt-1">Warga yang melakukan scan akan diarahkan ke URL ini (misal: Halaman Beranda, WhatsApp Hotline, atau Form Pengaduan).</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Label QR Code</label>
                            <input type="text" name="qr_code_title" value="{{ $settings['qr_code_title'] ?? 'Scan QR Portal Pelayanan' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 transition font-medium text-slate-800" placeholder="Scan QR Portal Pelayanan">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Subjudul / Keterangan QR</label>
                            <input type="text" name="qr_code_subtitle" value="{{ $settings['qr_code_subtitle'] ?? 'Kelurahan Sidomukti' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-purple-500 transition font-medium text-slate-800" placeholder="Kelurahan Sidomukti">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Sosial Footer Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Tautan Media Sosial Footer</h3>
                            <p class="text-slate-500 text-xs">Link jejaring media sosial kelurahan yang tampil pada footer halaman publik.</p>
                        </div>
                    </div>
                </div>
                @php
                    $defaultSocials = [
                        ['platform' => 'Instagram', 'url' => $settings['instagram'] ?? 'https://www.instagram.com/', 'icon' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>'],
                        ['platform' => 'YouTube', 'url' => $settings['youtube'] ?? 'https://www.youtube.com/', 'icon' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 00-2.122 2.136C0 8.07 0 12 0 12s0 3.93.498 5.814a3.016 3.016 0 002.122 2.136c1.872.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>'],
                        ['platform' => 'TikTok', 'url' => $settings['tiktok'] ?? 'https://www.tiktok.com/', 'icon' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>']
                    ];
                    $socialLinksStr = isset($settings['social_media_links']) ? $settings['social_media_links'] : json_encode($defaultSocials);
                @endphp
                @php
                    $svgs = [
                        'Instagram' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                        'YouTube' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 00-2.122 2.136C0 8.07 0 12 0 12s0 3.93.498 5.814a3.016 3.016 0 002.122 2.136c1.872.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                        'TikTok' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>',
                        'Facebook' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                        'Twitter / X' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>',
                        'WhatsApp' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
                        'Telegram' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.888-.662 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                        'LinkedIn' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                        'Lainnya' => '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>'
                    ];
                    $svgsJson = json_encode($svgs);
                @endphp
                <div class="p-6 md:p-8" x-data="{ 
                    socials: {{ $socialLinksStr }},
                    icons: {{ $svgsJson }},
                    updateIcon(soc) {
                        soc.icon = this.icons[soc.type] || this.icons['Lainnya'];
                    }
                }" x-init="
                    socials.forEach(s => {
                        if(!s.type) s.type = s.platform;
                    });
                ">
                    <input type="hidden" name="social_media_links" :value="JSON.stringify(socials)">
                    
                    <div class="space-y-4">
                        <template x-for="(soc, index) in socials" :key="index">
                            <div class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl bg-slate-50">
                                
                                <!-- Platform / Medsos -->
                                <div class="w-1/4">
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Platform / Medsos</label>
                                    <select x-model="soc.type" @change="updateIcon(soc); if(!soc.platform || soc.platform === 'Lainnya') soc.platform = soc.type;" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 transition font-medium text-slate-800 bg-white">
                                        <option value="Instagram">Instagram</option>
                                        <option value="YouTube">YouTube</option>
                                        <option value="TikTok">TikTok</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Twitter / X">Twitter / X</option>
                                        <option value="WhatsApp">WhatsApp</option>
                                        <option value="Telegram">Telegram</option>
                                        <option value="LinkedIn">LinkedIn</option>
                                        <option value="Website Lain">Website Lain</option>
                                        <option value="Lainnya">Kustom / Lainnya</option>
                                    </select>
                                </div>

                                <!-- Label / Nama Akun -->
                                <div class="w-1/4">
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">Label / Nama Akun</label>
                                    <input type="text" x-model="soc.platform" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 transition font-medium text-slate-800" placeholder="Label">
                                </div>
                                
                                <!-- URL / Link Tautan -->
                                <div class="flex-1">
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1.5">URL / Link Tautan</label>
                                    <input type="url" x-model="soc.url" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 transition font-medium text-slate-800" placeholder="https://...">
                                </div>
                                
                                <!-- Hapus Button -->
                                <div class="pt-6">
                                    <button type="button" @click="socials.splice(index, 1)" class="text-rose-500 hover:text-rose-600 bg-rose-50 hover:bg-rose-100 p-2.5 rounded-lg border border-rose-100 transition flex-shrink-0" title="Hapus Tautan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <button type="button" @click="socials.push({type: 'Instagram', platform: 'Instagram', url: '', icon: icons['Instagram']})" class="px-5 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-xl shadow-sm border border-indigo-200 transition flex items-center justify-center gap-2 w-full md:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Media Sosial Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- Google Maps Embed Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50/80 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Pengaturan Sematan Peta Google Maps</h3>
                            <p class="text-slate-500 text-xs">Kode sematan iFrame atau link tautan Peta Google Maps Kantor Kelurahan.</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tautan Navigasi Langsung Google Maps</label>
                        <input type="url" name="gmaps_link" value="{{ $settings['gmaps_link'] ?? 'https://maps.google.com/?q=Kelurahan+Sidomukti+Kraksaan' }}" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-mono" placeholder="https://maps.google.com/?q=...">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kode Sematan iFrame Google Maps (SRC Embed URL)</label>
                        <textarea name="gmaps_iframe" rows="3" class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 transition font-mono">{{ $settings['gmaps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15814.159392817812!2d113.407!3d-7.755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd701a5d24d2ab7%3A0x7d0186c478a87ab5!2sSidomukti%2C%20Kraksaan%2C%20Probolinggo%20Regency%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Tempelkan URL dari atribut `src="..."` kode embed Google Maps.</p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition">Simpan Informasi Kontak & Maps</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Map & Contact Card Preview -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                <h4 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Pratinjau Peta Google Maps Kantor
                </h4>

                <div class="w-full h-64 rounded-xl overflow-hidden border border-slate-200 shadow-xs bg-slate-100">
                    <iframe src="{{ $settings['gmaps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15814.159392817812!2d113.407!3d-7.755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd701a5d24d2ab7%3A0x7d0186c478a87ab5!2sSidomukti%2C%20Kraksaan%2C%20Probolinggo%20Regency%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid' }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-xs space-y-2 text-slate-700">
                    <div class="font-bold text-slate-900 border-b border-slate-200 pb-2">Informasi Publik Halaman Kontak</div>
                    <div><strong class="text-slate-900">Alamat:</strong> {{ $settings['alamat'] ?? 'Jl. Raya Sidomukti No. 10' }}</div>
                    <div><strong class="text-slate-900">Telepon:</strong> {{ $settings['telepon'] ?? '(0335) 123456' }}</div>
                    <div><strong class="text-slate-900">Email:</strong> {{ $settings['email'] ?? 'info@sidomukti.desa.id' }}</div>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection

@push('scripts')
<script>
    window.validateContactMapsForm = function(form) {
        const fileInput = form.querySelector('input[name="qr_code_image"]');
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            if (!validateImageUpload(fileInput)) {
                return false;
            }
        }
        return true;
    };
</script>
@endpush
