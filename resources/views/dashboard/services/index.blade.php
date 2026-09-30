@extends('layouts.admin')

@section('title', 'Kelola Standar Layanan & SOP')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Kelola Standar Layanan & SOP</h2>
        <p class="text-slate-500 text-sm">Kelola repositori dokumen SOP, standar pelayanan publik, dan berkas PDF kelurahan.</p>
    </div>
    <button type="button" onclick="openModal('createServiceModal')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 text-sm cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Dokumen SOP
    </button>
</div>



@if($errors->any())
<div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl relative mb-6 shadow-xs" role="alert">
    <div class="font-bold text-sm mb-1 flex items-center gap-2">
        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Perhatian:
    </div>
    <ul class="list-disc list-inside text-sm space-y-0.5">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden p-2 sm:p-4">
    <div class="overflow-x-auto">
        <table id="dataTable" class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase font-semibold border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-4">No & Judul Dokumen SOP</th>
                    <th scope="col" class="px-6 py-4">Kategori Layanan</th>
                    <th scope="col" class="px-6 py-4">Slug URL</th>
                    <th scope="col" class="px-6 py-4 text-center">Berkas Dokumen PDF</th>
                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                    <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($services as $service)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-emerald-100/80 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0 mt-0.5 index-number">
                                {{ $loop->iteration }}
                            </span>
                            <div>
                                <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-emerald-700 transition">
                                    {{ $service->title }}
                                </a>
                                <p class="text-xs text-slate-400 mt-0.5 line-clamp-1 max-w-sm">{{ $service->description ?: 'Tidak ada keterangan tambahan.' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($service->kategoriLayanan)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                {{ $service->kategoriLayanan->nama_kategori }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                Umum / Belum Dikerjakan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <code class="px-2 py-1 bg-slate-100 text-slate-700 rounded-md text-[11px] font-mono border border-slate-200 max-w-xs truncate inline-block">{{ $service->slug }}</code>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($service->file_path && Storage::disk('public')->exists($service->file_path))
                            <a href="{{ Storage::url($service->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat Berkas
                            </a>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Belum Diunggah
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($service->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition" title="Lihat Tampilan Publik">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            @php
                                $srvPayload = json_encode([
                                    'id' => $service->id,
                                    'title' => $service->title,
                                    'kategori_layanan_id' => $service->kategori_layanan_id ?: null,
                                    'description' => $service->description ?? '',
                                    'requirements' => $service->requirements ?? '',
                                    'operating_hours' => $service->operating_hours ?? 'Senin - Jumat',
                                    'processing_time' => $service->processing_time ?? '15 - 30 Menit',
                                    'cost' => $service->cost ?? 'GRATIS',
                                    'is_active' => $service->is_active ? 1 : 0,
                                    'file_name' => basename($service->file_path ?? ''),
                                    'file_url' => $service->file_path ? Storage::url($service->file_path) : ''
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                            @endphp
                            <button type="button" 
                                    data-service="{{ $srvPayload }}"
                                    onclick="handleEditService(this)" 
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition cursor-pointer" 
                                    title="Edit Dokumen SOP">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                            <form action="{{ route('dashboard.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen SOP ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Hapus Dokumen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Dokumen SOP -->
<div id="createServiceModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-2xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            STANDAR PELAYANAN SOP
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Tambah Dokumen SOP / Layanan</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('createServiceModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Form -->
            <form action="{{ route('dashboard.services.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" name="_form_type" value="create">

                <div>
                    <label for="create_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen / Layanan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="create_title" value="{{ old('_form_type') === 'create' ? old('title') : '' }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: SOP Pelayanan Surat Keterangan Usaha (SKU)">
                </div>

                <!-- 1. Master Kategori Layanan -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="create_kategori_layanan_id" class="block text-xs font-bold text-slate-700">
                            Kategori Layanan <span class="text-rose-500">*</span>
                        </label>
                        <a href="{{ route('dashboard.categories.index', ['module' => 'layanan']) }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1">
                            <span>Kelola di Master Kategori ↗</span>
                        </a>
                    </div>
                    <select name="kategori_layanan_id" id="create_kategori_layanan_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                        <option value="">-- Pilih Kategori Layanan --</option>
                        @foreach($kategoriLayanan as $kat)
                            <option value="{{ $kat->id }}" {{ (old('_form_type') === 'create' && old('kategori_layanan_id') == $kat->id) ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="create_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Ringkasan Layanan</label>
                    <textarea name="description" id="create_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Tuliskan ringkasan prosedur atau petunjuk singkat...">{{ old('_form_type') === 'create' ? old('description') : '' }}</textarea>
                </div>

                <div>
                    <label for="create_requirements" class="block text-xs font-bold text-slate-700 mb-1.5">Persyaratan Dokumen</label>
                    <textarea name="requirements" id="create_requirements" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Contoh: Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW">{{ old('_form_type') === 'create' ? old('requirements') : '' }}</textarea>
                </div>

                <!-- Ketentuan Pelayanan Presets -->
                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Ketentuan Pelayanan</label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="create_operating_days" class="block text-[11px] font-bold text-slate-700 mb-1">Hari Operasional</label>
                            <select name="operating_days" id="create_operating_days" onchange="toggleCustomDays('create')" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="Senin - Jumat" selected>Senin - Jumat</option>
                                <option value="Senin - Sabtu">Senin - Sabtu</option>
                                <option value="Setiap Hari (Senin - Minggu)">Setiap Hari (Senin - Minggu)</option>
                                <option value="Hari Kerja Tertentu">Hari Kerja Tertentu</option>
                            </select>
                        </div>

                        <div>
                            <label for="create_operating_hours_preset" class="block text-[11px] font-bold text-slate-700 mb-1">Jam Operasional</label>
                            <select id="create_operating_hours_preset" onchange="toggleCustomHours('create')" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="07.30 - 15.30 WIB" selected>07.30 - 15.30 WIB</option>
                                <option value="08.00 - 14.00 WIB">08.00 - 14.00 WIB</option>
                                <option value="08.00 - 12.00 WIB">08.00 - 12.00 WIB</option>
                                <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                                <option value="Kustom">Kustom Jam Buka-Tutup</option>
                            </select>
                            <input type="hidden" name="operating_hours" id="create_operating_hours" value="07.30 - 15.30 WIB">
                        </div>

                        <div>
                            <label for="create_processing_time_preset" class="block text-[11px] font-bold text-slate-700 mb-1">Estimasi Waktu</label>
                            <select id="create_processing_time_preset" onchange="toggleCustomProcessing('create')" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="15 - 30 Menit">15 - 30 Menit</option>
                                <option value="30 - 60 Menit">30 - 60 Menit</option>
                                <option value="1 - 2 Jam">1 - 2 Jam</option>
                                <option value="1 Hari Kerja (1x24 Jam)" selected>1 Hari Kerja (1x24 Jam)</option>
                                <option value="2 - 3 Hari Kerja">2 - 3 Hari Kerja</option>
                                <option value="Kustom">Kustom Durasi</option>
                            </select>
                            <input type="hidden" name="processing_time" id="create_processing_time" value="1 Hari Kerja (1x24 Jam)">
                        </div>
                    </div>

                    <!-- Custom Hari Checkboxes -->
                    <div id="create_custom_days_box" class="hidden p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Pilih Hari Kerja Tertentu:</label>
                        <div class="flex flex-wrap gap-3 text-xs text-slate-700">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" value="{{ $day }}" onchange="updateCustomDaysString('create')" class="create_day_cb w-3.5 h-3.5 text-emerald-600 rounded border-slate-300">
                                    <span>{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Custom Jam Buka / Tutup -->
                    <div id="create_custom_hours_box" class="hidden p-3 bg-slate-50 border border-slate-200 rounded-xl grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jam Buka</label>
                            <input type="time" id="create_time_start" value="08:00" onchange="updateCustomHoursString('create')" class="w-full px-2.5 py-1.5 border border-slate-200 rounded-lg text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jam Tutup</label>
                            <input type="time" id="create_time_end" value="16:00" onchange="updateCustomHoursString('create')" class="w-full px-2.5 py-1.5 border border-slate-200 rounded-lg text-xs">
                        </div>
                    </div>

                    <!-- Custom Durasi -->
                    <div id="create_custom_processing_box" class="hidden p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Durasi Kustom</label>
                        <input type="text" id="create_processing_custom_input" placeholder="Misal: 5 Hari Kerja..." oninput="updateCustomProcessingString('create')" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs">
                    </div>

                    <!-- Biaya Pelayanan -->
                    <div>
                        <label for="create_cost" class="block text-[11px] font-bold text-slate-700 mb-1">Biaya Pelayanan</label>
                        <input type="text" name="cost" id="create_cost" value="{{ old('_form_type') === 'create' ? old('cost', 'GRATIS') : 'GRATIS' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold text-emerald-700" placeholder="GRATIS">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Berkas Dokumen PDF (Maks. 10MB)</label>
                    <input type="file" id="create_pdf_file" name="pdf_file" accept="application/pdf,.pdf" onchange="validatePdfUpload(this, 'create_pdf_label', 'Pilih Berkas PDF', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                    <span id="create_pdf_label" class="text-[10px] text-slate-400 mt-1 block">Format: Berkas PDF Publik (Maksimal 10MB)</span>
                </div>

                <div class="flex items-center pt-2 border-t border-slate-100">
                    <input type="checkbox" name="is_active" id="create_is_active" value="1" {{ old('_form_type') === 'create' ? (old('is_active') ? 'checked' : '') : 'checked' }} class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                    <label for="create_is_active" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Tampilkan dokumen ini di menu dan halaman publik (Aktif)</label>
                </div>

                <!-- Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('createServiceModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Dokumen SOP -->
<div id="editServiceModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-opacity duration-300">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>
    <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-2xl transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
            <!-- Modal Dark Emerald Header -->
            <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                            STANDAR PELAYANAN SOP
                        </span>
                        <h3 class="text-base font-black text-white mt-0.5">Edit Dokumen SOP / Layanan</h3>
                    </div>
                </div>
                <button type="button" onclick="closeModal('editServiceModal')" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer" title="Tutup Modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Form -->
            <form id="editServiceForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form_type" value="edit">

                <div>
                    <label for="edit_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen / Layanan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: SOP Pelayanan Surat Keterangan Usaha (SKU)">
                </div>

                <!-- 1. Master Kategori Layanan -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="edit_kategori_layanan_id" class="block text-xs font-bold text-slate-700">
                            Kategori Layanan <span class="text-rose-500">*</span>
                        </label>
                        <a href="{{ route('dashboard.categories.index', ['module' => 'layanan']) }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1">
                            <span>Kelola di Master Kategori ↗</span>
                        </a>
                    </div>
                    <select name="kategori_layanan_id" id="edit_kategori_layanan_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                        <option value="">-- Pilih Kategori Layanan --</option>
                        @foreach($kategoriLayanan as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="edit_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi / Ringkasan Layanan</label>
                    <textarea name="description" id="edit_description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Tuliskan ringkasan prosedur atau petunjuk singkat..."></textarea>
                </div>

                <div>
                    <label for="edit_requirements" class="block text-xs font-bold text-slate-700 mb-1.5">Persyaratan Dokumen</label>
                    <textarea name="requirements" id="edit_requirements" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Contoh: Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW"></textarea>
                </div>

                <!-- Ketentuan Pelayanan Presets -->
                <div class="border-t border-slate-100 pt-3 space-y-3">
                    <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Ketentuan Pelayanan</label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label for="edit_operating_days" class="block text-[11px] font-bold text-slate-700 mb-1">Hari Operasional</label>
                            <select name="operating_days" id="edit_operating_days" onchange="toggleCustomDays('edit')" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="Senin - Jumat">Senin - Jumat</option>
                                <option value="Senin - Sabtu">Senin - Sabtu</option>
                                <option value="Setiap Hari (Senin - Minggu)">Setiap Hari (Senin - Minggu)</option>
                                <option value="Hari Kerja Tertentu">Hari Kerja Tertentu</option>
                            </select>
                        </div>

                        <div>
                            <label for="edit_operating_hours_preset" class="block text-[11px] font-bold text-slate-700 mb-1">Jam Operasional</label>
                            <select id="edit_operating_hours_preset" onchange="toggleCustomHours('edit')" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="07.30 - 15.30 WIB">07.30 - 15.30 WIB</option>
                                <option value="08.00 - 14.00 WIB">08.00 - 14.00 WIB</option>
                                <option value="08.00 - 12.00 WIB">08.00 - 12.00 WIB</option>
                                <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                                <option value="Kustom">Kustom Jam Buka-Tutup</option>
                            </select>
                            <input type="hidden" name="operating_hours" id="edit_operating_hours" value="07.30 - 15.30 WIB">
                        </div>

                        <div>
                            <label for="edit_processing_time_preset" class="block text-[11px] font-bold text-slate-700 mb-1">Estimasi Waktu</label>
                            <select id="edit_processing_time_preset" onchange="toggleCustomProcessing('edit')" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                <option value="15 - 30 Menit">15 - 30 Menit</option>
                                <option value="30 - 60 Menit">30 - 60 Menit</option>
                                <option value="1 - 2 Jam">1 - 2 Jam</option>
                                <option value="1 Hari Kerja (1x24 Jam)">1 Hari Kerja (1x24 Jam)</option>
                                <option value="2 - 3 Hari Kerja">2 - 3 Hari Kerja</option>
                                <option value="Kustom">Kustom Durasi</option>
                            </select>
                            <input type="hidden" name="processing_time" id="edit_processing_time" value="1 Hari Kerja (1x24 Jam)">
                        </div>
                    </div>

                    <!-- Custom Hari Checkboxes -->
                    <div id="edit_custom_days_box" class="hidden p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Pilih Hari Kerja Tertentu:</label>
                        <div class="flex flex-wrap gap-3 text-xs text-slate-700">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                    <input type="checkbox" value="{{ $day }}" onchange="updateCustomDaysString('edit')" class="edit_day_cb w-3.5 h-3.5 text-emerald-600 rounded border-slate-300">
                                    <span>{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Custom Jam Buka / Tutup -->
                    <div id="edit_custom_hours_box" class="hidden p-3 bg-slate-50 border border-slate-200 rounded-xl grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jam Buka</label>
                            <input type="time" id="edit_time_start" value="08:00" onchange="updateCustomHoursString('edit')" class="w-full px-2.5 py-1.5 border border-slate-200 rounded-lg text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jam Tutup</label>
                            <input type="time" id="edit_time_end" value="16:00" onchange="updateCustomHoursString('edit')" class="w-full px-2.5 py-1.5 border border-slate-200 rounded-lg text-xs">
                        </div>
                    </div>

                    <!-- Custom Durasi -->
                    <div id="edit_custom_processing_box" class="hidden p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Durasi Kustom</label>
                        <input type="text" id="edit_processing_custom_input" placeholder="Misal: 5 Hari Kerja..." oninput="updateCustomProcessingString('edit')" class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs">
                    </div>

                    <!-- Biaya Pelayanan -->
                    <div>
                        <label for="edit_cost" class="block text-[11px] font-bold text-slate-700 mb-1">Biaya Pelayanan</label>
                        <input type="text" name="cost" id="edit_cost" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold text-emerald-700" placeholder="GRATIS">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Berkas Dokumen PDF (Maks. 10MB)</label>
                    <div id="edit_file_preview_container" class="mb-2 hidden">
                        <div class="px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-xs text-emerald-800 font-medium">
                            <span class="truncate max-w-md">📄 Berkas saat ini: <strong id="edit_current_file_name"></strong></span>
                            <a id="edit_current_file_url" href="#" target="_blank" class="text-emerald-700 hover:text-emerald-900 underline font-bold shrink-0">Lihat Berkas</a>
                        </div>
                    </div>
                    <input type="file" id="edit_pdf_file" name="pdf_file" accept="application/pdf,.pdf" onchange="validatePdfUpload(this, 'edit_pdf_label', 'Pilih Berkas Baru (Opsional)', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                    <span id="edit_pdf_label" class="text-[10px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah berkas PDF</span>
                </div>

                <div class="flex items-center pt-2 border-t border-slate-100">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2 cursor-pointer">
                    <label for="edit_is_active" class="ml-2 text-xs font-bold text-slate-700 cursor-pointer">Tampilkan dokumen ini di menu dan halaman publik (Aktif)</label>
                </div>

                <!-- Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('editServiceModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        const card = modal.querySelector('.transform') || modal.firstElementChild;
        if (card) {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }
    }, 10);
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('opacity-0');
    const card = modal.querySelector('.transform') || modal.firstElementChild;
    if (card) {
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function toggleCustomDays(prefix) {
    const select = document.getElementById(prefix + '_operating_days');
    const box = document.getElementById(prefix + '_custom_days_box');
    if (select.value === 'Hari Kerja Tertentu') {
        box.classList.remove('hidden');
        updateCustomDaysString(prefix);
    } else {
        box.classList.add('hidden');
    }
}

function updateCustomDaysString(prefix) {
    const checkboxes = document.querySelectorAll('.' + prefix + '_day_cb:checked');
    const selectedDays = Array.from(checkboxes).map(cb => cb.value);
    // If none selected yet, default text
    if (selectedDays.length === 0) {
        // keep select value
    }
}

function toggleCustomHours(prefix) {
    const select = document.getElementById(prefix + '_operating_hours_preset');
    const box = document.getElementById(prefix + '_custom_hours_box');
    const hidden = document.getElementById(prefix + '_operating_hours');

    if (select.value === 'Kustom') {
        box.classList.remove('hidden');
        updateCustomHoursString(prefix);
    } else {
        box.classList.add('hidden');
        hidden.value = select.value;
    }
}

function updateCustomHoursString(prefix) {
    const start = document.getElementById(prefix + '_time_start').value || '08:00';
    const end = document.getElementById(prefix + '_time_end').value || '16:00';
    const formatTime = (t) => t.replace(':', '.') + ' WIB';
    document.getElementById(prefix + '_operating_hours').value = formatTime(start) + ' - ' + formatTime(end);
}

function toggleCustomProcessing(prefix) {
    const select = document.getElementById(prefix + '_processing_time_preset');
    const box = document.getElementById(prefix + '_custom_processing_box');
    const hidden = document.getElementById(prefix + '_processing_time');

    if (select.value === 'Kustom') {
        box.classList.remove('hidden');
        updateCustomProcessingString(prefix);
    } else {
        box.classList.add('hidden');
        hidden.value = select.value;
    }
}

function updateCustomProcessingString(prefix) {
    const val = document.getElementById(prefix + '_processing_custom_input').value || 'Tergantung Layanan';
    document.getElementById(prefix + '_processing_time').value = val;
}

function handleEditService(btn) {
    try {
        const raw = btn.getAttribute('data-service');
        if (!raw) return;
        const d = JSON.parse(raw);
        openEditServiceModal(d.id, d.title, d.kategori_layanan_id, d.description, d.requirements, d.operating_hours, d.processing_time, d.cost, d.is_active, d.file_name, d.file_url);
    } catch (e) {
        console.error('Error parsing service data:', e);
    }
}

function openEditServiceModal(id, title, kategoriId, description, requirements, operatingHours, processingTime, cost, isActive, fileName, fileUrl) {
    const form = document.getElementById('editServiceForm');
    form.action = "{{ url('/dashboard/services') }}/" + id;
    
    document.getElementById('edit_title').value = title || '';
    
    // Set Kategori Select
    const katSelect = document.getElementById('edit_kategori_layanan_id');
    if (katSelect) {
        katSelect.value = kategoriId ? kategoriId : '';
    }

    document.getElementById('edit_description').value = description || '';
    document.getElementById('edit_requirements').value = requirements || '';
    
    // Match operating hours preset or custom
    const hoursPresetSelect = document.getElementById('edit_operating_hours_preset');
    const presetOptions = ['07.30 - 15.30 WIB', '08.00 - 14.00 WIB', '08.00 - 12.00 WIB', '24 Jam (Layanan Online Mandiri)'];
    if (presetOptions.includes(operatingHours)) {
        hoursPresetSelect.value = operatingHours;
        document.getElementById('edit_custom_hours_box').classList.add('hidden');
    } else if (operatingHours) {
        hoursPresetSelect.value = 'Kustom';
        document.getElementById('edit_custom_hours_box').classList.remove('hidden');
    } else {
        hoursPresetSelect.value = '07.30 - 15.30 WIB';
        document.getElementById('edit_custom_hours_box').classList.add('hidden');
    }
    document.getElementById('edit_operating_hours').value = operatingHours || '07.30 - 15.30 WIB';

    // Match processing time preset or custom
    const procPresetSelect = document.getElementById('edit_processing_time_preset');
    const procPresetOptions = ['15 - 30 Menit', '30 - 60 Menit', '1 - 2 Jam', '1 Hari Kerja (1x24 Jam)', '2 - 3 Hari Kerja'];
    if (procPresetOptions.includes(processingTime)) {
        procPresetSelect.value = processingTime;
        document.getElementById('edit_custom_processing_box').classList.add('hidden');
    } else if (processingTime) {
        procPresetSelect.value = 'Kustom';
        document.getElementById('edit_custom_processing_box').classList.remove('hidden');
        document.getElementById('edit_processing_custom_input').value = processingTime;
    } else {
        procPresetSelect.value = '1 Hari Kerja (1x24 Jam)';
        document.getElementById('edit_custom_processing_box').classList.add('hidden');
    }
    document.getElementById('edit_processing_time').value = processingTime || '1 Hari Kerja (1x24 Jam)';

    document.getElementById('edit_cost').value = cost || 'GRATIS';
    document.getElementById('edit_is_active').checked = Boolean(isActive);

    const filePreview = document.getElementById('edit_file_preview_container');
    const fileNameEl = document.getElementById('edit_current_file_name');
    const fileUrlEl = document.getElementById('edit_current_file_url');
    document.getElementById('edit_pdf_label').textContent = 'Pilih Berkas Baru (Opsional)';

    if (fileUrl) {
        fileNameEl.textContent = fileName || 'dokumen.pdf';
        fileUrlEl.href = fileUrl;
        filePreview.classList.remove('hidden');
    } else {
        filePreview.classList.add('hidden');
    }

    openModal('editServiceModal');
}

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    @if(old('_form_type') === 'edit')
        openModal('editServiceModal');
    @else
        openModal('createServiceModal');
    @endif
});
@endif
</script>

@push('scripts')
<script>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable().destroy();
    }
    const table = $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        "pageLength": 10,
        "order": [],
        "columnDefs": [
            { "orderable": false, "targets": 0 }
        ]
    });

    table.on('draw.dt', function () {
        let pageInfo = table.page.info();
        table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            $(cell).find('span.index-number').text(pageInfo.start + i + 1);
        });
    });
});
</script>
@endpush
@endsection
