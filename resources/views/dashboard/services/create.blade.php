@extends('layouts.admin')

@section('title', 'Tambah Dokumen SOP / Standar Pelayanan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
            <a href="{{ route('dashboard.services.index') }}" class="hover:text-emerald-600 transition">Standar Pelayanan & SOP</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-slate-700 font-medium">Tambah Dokumen</span>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Dokumen SOP / Layanan</h2>
        <p class="text-slate-500 text-sm">Tambahkan repositori dokumen SOP atau Standar Pelayanan publik baru.</p>
    </div>
    <a href="{{ route('dashboard.services.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 font-medium py-2 px-4 border border-slate-200 rounded-xl shadow-sm bg-white hover:bg-slate-50 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-semibold text-slate-800">Formulir Dokumen SOP</h3>
        <p class="text-xs text-slate-500">Unggah berkas PDF dan isi detail informasi layanan.</p>
    </div>

    <form action="{{ route('dashboard.services.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul Dokumen / Layanan <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 rounded-xl border @error('title') border-red-500 ring-1 ring-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" placeholder="Contoh: SOP Pelayanan Surat Keterangan Usaha (SKU)">
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
                    <option value="{{ $kat->id }}" {{ old('kategori_layanan_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
            <p class="text-[11px] text-slate-500 mt-1">Kategori dikelola melalui menu <a href="{{ route('dashboard.categories.index', ['module' => 'layanan']) }}" target="_blank" class="text-emerald-600 hover:underline">Master Kategori Terpadu</a>.</p>
            @error('kategori_layanan_id')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi / Ringkasan Layanan</label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border @error('description') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" placeholder="Tuliskan ringkasan prosedur atau petunjuk singkat...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="requirements" class="block text-sm font-semibold text-slate-700 mb-2">Persyaratan Dokumen</label>
            <textarea name="requirements" id="requirements" rows="3" class="w-full px-4 py-2.5 rounded-xl border @error('requirements') border-red-500 @else border-slate-200 @enderror focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" placeholder="Contoh: Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW (pisahkan dengan koma atau baris baru)">{{ old('requirements') }}</textarea>
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
                        <option value="Senin - Jumat" selected>Senin - Jumat</option>
                        <option value="Senin - Sabtu">Senin - Sabtu</option>
                        <option value="Setiap Hari (Senin - Minggu)">Setiap Hari (Senin - Minggu)</option>
                    </select>
                </div>
                <!-- Jam Operasional -->
                <div>
                    <label for="operating_hours_preset" class="block text-xs font-semibold text-slate-700 mb-1">Jam Operasional</label>
                    <select id="operating_hours_preset" onchange="document.getElementById('operating_hours').value = this.value" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs bg-white">
                        <option value="07.30 - 15.30 WIB" selected>07.30 - 15.30 WIB</option>
                        <option value="08.00 - 14.00 WIB">08.00 - 14.00 WIB</option>
                        <option value="08.00 - 12.00 WIB">08.00 - 12.00 WIB</option>
                        <option value="24 Jam (Layanan Online Mandiri)">24 Jam (Layanan Online Mandiri)</option>
                    </select>
                    <input type="hidden" name="operating_hours" id="operating_hours" value="07.30 - 15.30 WIB">
                </div>
                <!-- Estimasi Waktu -->
                <div>
                    <label for="processing_time_preset" class="block text-xs font-semibold text-slate-700 mb-1">Estimasi Waktu</label>
                    <select id="processing_time_preset" onchange="document.getElementById('processing_time').value = this.value" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs bg-white">
                        <option value="15 - 30 Menit">15 - 30 Menit</option>
                        <option value="30 - 60 Menit">30 - 60 Menit</option>
                        <option value="1 - 2 Jam">1 - 2 Jam</option>
                        <option value="1 Hari Kerja (1x24 Jam)" selected>1 Hari Kerja (1x24 Jam)</option>
                        <option value="2 - 3 Hari Kerja">2 - 3 Hari Kerja</option>
                    </select>
                    <input type="hidden" name="processing_time" id="processing_time" value="1 Hari Kerja (1x24 Jam)">
                </div>
            </div>

            <div>
                <label for="cost" class="block text-xs font-semibold text-slate-700 mb-1">Biaya Pelayanan</label>
                <input type="text" name="cost" id="cost" value="{{ old('cost', 'GRATIS') }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-xs" placeholder="GRATIS">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Berkas Dokumen PDF (Maks. 10MB)</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-emerald-400 transition bg-slate-50/50">
                <div class="space-y-2 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v24a4 4 0 004 4h24a4 4 0 004-4V20l-12-12z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M28 8v12h12M16 26h16M16 32h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-slate-600 justify-center">
                        <label for="pdf_file" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                            <span id="pdf_label">Pilih Berkas PDF</span>
                            <input id="pdf_file" name="pdf_file" type="file" accept="application/pdf" class="sr-only" onchange="validatePdfUpload(this, 'pdf_label', 'Pilih Berkas PDF', 10)">
                        </label>
                    </div>
                    <p class="text-xs text-slate-400">PDF hingga ukuran 10MB</p>
                </div>
            </div>
            @error('pdf_file')
                <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded focus:ring-emerald-500 focus:ring-2">
            <label for="is_active" class="ml-3 text-sm font-medium text-slate-700">Tampilkan dokumen ini di menu dan halaman publik (Aktif)</label>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('dashboard.services.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium text-sm transition">Batal</a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Dokumen
            </button>
        </div>
    </form>
</div>
@endsection
