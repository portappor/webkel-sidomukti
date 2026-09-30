@extends('layouts.admin')

@section('title', 'Edit Dokumen SOP / Standar Pelayanan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard.services.index') }}" class="hover:text-emerald-600 transition">Standar Pelayanan & SOP</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-700 font-medium">Edit Dokumen</span>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Edit Dokumen SOP</h2>
        <p class="text-slate-500 text-sm">Perbarui informasi atau unggah ulang dokumen PDF.</p>
    </div>
    <div class="flex items-center gap-2">
        @if($service->file_path)
            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-700 hover:text-emerald-800 font-medium py-2 px-4 border border-emerald-200 rounded-xl shadow-sm bg-emerald-50 hover:bg-emerald-100/70 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat di Web
            </a>
        @endif
        <a href="{{ route('dashboard.services.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium py-2 px-4 border border-slate-200 rounded-xl shadow-sm bg-white hover:bg-slate-50 transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-semibold text-slate-800">Perbarui Dokumen SOP</h3>
        <p class="text-xs text-slate-500">Slug URL: <span class="font-mono text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200/60">{{ $service->slug }}</span></p>
    </div>

    <form action="{{ route('dashboard.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Dokumen / Layanan <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" required class="w-full px-4 py-2.5 rounded-xl border @error('title') border-red-500 ring-1 ring-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm">
            @error('title')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Master Kategori Layanan (Dinamis dari Master Kategori Terpadu) -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="kategori_layanan_id" class="block text-sm font-semibold text-slate-700">
                    Kategori Layanan <span class="text-red-500">*</span>
                </label>
                <a href="{{ route('dashboard.categories.index', ['module' => 'layanan']) }}" target="_blank" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 transition">
                    <span>Kelola di Master Kategori</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
            <select name="kategori_layanan_id" id="kategori_layanan_id" required class="w-full px-4 py-2.5 rounded-xl border @error('kategori_layanan_id') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm bg-white">
                <option value="">-- Pilih Kategori Layanan --</option>
                @foreach($kategoriLayanan as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_layanan_id', $service->kategori_layanan_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            <p class="text-[11px] text-slate-500 mt-1">Kategori dikelola melalui menu <a href="{{ route('dashboard.categories.index', ['module' => 'layanan']) }}" target="_blank" class="text-emerald-600 hover:underline">Master Kategori Terpadu</a>.</p>
            @error('kategori_layanan_id')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi / Ringkasan Layanan</label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border @error('description') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm">{{ old('description', $service->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="requirements" class="block text-sm font-semibold text-slate-700 mb-2">Persyaratan Dokumen</label>
            <textarea name="requirements" id="requirements" rows="3" class="w-full px-4 py-2.5 rounded-xl border @error('requirements') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" placeholder="Contoh: Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW (pisahkan dengan koma atau baris baru)">{{ old('requirements', $service->requirements) }}</textarea>
            <p class="text-xs text-slate-500 mt-1.5">Pisahkan tiap poin persyaratan dengan koma (,) atau baris baru.</p>
            @error('requirements')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ketentuan Pelayanan Presets -->
        <div class="border-t border-slate-100 pt-4 space-y-4">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Ketentuan Pelayanan</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Hari Operasional -->
                <div>
                    <label for="operating_days" class="block text-xs font-semibold text-slate-700 mb-1">Hari Operasional</label>
                    <select name="operating_days" id="operating_days" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs bg-white">
                        <option value="Senin - Jumat" {{ old('operating_days', 'Senin - Jumat') == 'Senin - Jumat' ? 'selected' : '' }}>Senin - Jumat</option>
                        <option value="Senin - Sabtu" {{ old('operating_days') == 'Senin - Sabtu' ? 'selected' : '' }}>Senin - Sabtu</option>
                        <option value="Setiap Hari (Senin - Minggu)" {{ old('operating_days') == 'Setiap Hari (Senin - Minggu)' ? 'selected' : '' }}>Setiap Hari (Senin - Minggu)</option>
                    </select>
                </div>
                <!-- Jam Operasional -->
                <div>
                    <label for="operating_hours_preset" class="block text-xs font-semibold text-slate-700 mb-1">Jam Operasional</label>
                    <select id="operating_hours_preset" onchange="document.getElementById('operating_hours').value = this.value" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs bg-white">
                        <option value="07.30 - 15.30 WIB" {{ old('operating_hours', $service->operating_hours) == '07.30 - 15.30 WIB' ? 'selected' : '' }}>07.30 - 15.30 WIB</option>
                        <option value="08.00 - 14.00 WIB" {{ old('operating_hours', $service->operating_hours) == '08.00 - 14.00 WIB' ? 'selected' : '' }}>08.00 - 14.00 WIB</option>
                        <option value="08.00 - 12.00 WIB" {{ old('operating_hours', $service->operating_hours) == '08.00 - 12.00 WIB' ? 'selected' : '' }}>08.00 - 12.00 WIB</option>
                        <option value="24 Jam (Layanan Online Mandiri)" {{ old('operating_hours', $service->operating_hours) == '24 Jam (Layanan Online Mandiri)' ? 'selected' : '' }}>24 Jam (Layanan Online Mandiri)</option>
                    </select>
                    <input type="hidden" name="operating_hours" id="operating_hours" value="{{ old('operating_hours', $service->operating_hours ?? '07.30 - 15.30 WIB') }}">
                </div>
                <!-- Estimasi Waktu -->
                <div>
                    <label for="processing_time_preset" class="block text-xs font-semibold text-slate-700 mb-1">Estimasi Waktu</label>
                    <select id="processing_time_preset" onchange="document.getElementById('processing_time').value = this.value" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs bg-white">
                        <option value="15 - 30 Menit" {{ old('processing_time', $service->processing_time) == '15 - 30 Menit' ? 'selected' : '' }}>15 - 30 Menit</option>
                        <option value="30 - 60 Menit" {{ old('processing_time', $service->processing_time) == '30 - 60 Menit' ? 'selected' : '' }}>30 - 60 Menit</option>
                        <option value="1 - 2 Jam" {{ old('processing_time', $service->processing_time) == '1 - 2 Jam' ? 'selected' : '' }}>1 - 2 Jam</option>
                        <option value="1 Hari Kerja (1x24 Jam)" {{ old('processing_time', $service->processing_time) == '1 Hari Kerja (1x24 Jam)' ? 'selected' : '' }}>1 Hari Kerja (1x24 Jam)</option>
                        <option value="2 - 3 Hari Kerja" {{ old('processing_time', $service->processing_time) == '2 - 3 Hari Kerja' ? 'selected' : '' }}>2 - 3 Hari Kerja</option>
                    </select>
                    <input type="hidden" name="processing_time" id="processing_time" value="{{ old('processing_time', $service->processing_time ?? '1 Hari Kerja (1x24 Jam)') }}">
                </div>
            </div>

            <div>
                <label for="cost" class="block text-xs font-semibold text-slate-700 mb-1">Biaya Pelayanan</label>
                <input type="text" name="cost" id="cost" value="{{ old('cost', $service->cost ?? 'GRATIS') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs" placeholder="GRATIS">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Berkas Dokumen PDF (Maks. 10MB)</label>
            
            @if($service->file_path)
            <div class="mb-4 p-3 bg-emerald-50/70 border border-emerald-200 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 text-emerald-700 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-emerald-900">Berkas PDF Tersedia</p>
                        <p class="text-[11px] text-emerald-700 font-mono">{{ basename($service->file_path) }}</p>
                    </div>
                </div>
                <a href="{{ Storage::url($service->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 hover:text-emerald-800 bg-white px-3 py-1.5 rounded-lg border border-emerald-200 shadow-sm transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Buka PDF
                </a>
            </div>
            @else
            <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p class="text-xs text-amber-800">Belum ada file PDF yang diunggah untuk dokumen ini.</p>
            </div>
            @endif

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-emerald-400 transition bg-slate-50/50">
                <div class="space-y-2 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v24a4 4 0 004 4h24a4 4 0 004-4V20l-12-12z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M28 8v12h12M16 26h16M16 32h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-slate-600 justify-center">
                        <label for="pdf_file" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                            <span id="pdf_label">{{ $service->file_path ? 'Ganti Berkas PDF' : 'Pilih Berkas PDF' }}</span>
                            <input id="pdf_file" name="pdf_file" type="file" accept="application/pdf" class="sr-only" onchange="validatePdfUpload(this, 'pdf_label', '{{ $service->file_path ? 'Ganti Berkas PDF' : 'Pilih Berkas PDF' }}', 10)">
                        </label>
                    </div>
                    <p class="text-xs text-slate-400">PDF hingga ukuran 10MB. Biarkan kosong jika tidak ingin mengubah.</p>
                </div>
            </div>
            @error('pdf_file')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
            <label for="is_active" class="ml-3 text-sm font-medium text-slate-700">Tampilkan dokumen ini di menu dan halaman publik (Aktif)</label>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('dashboard.services.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium text-sm transition">Batal</a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Perbarui Dokumen
            </button>
        </div>
    </form>
</div>
@endsection
