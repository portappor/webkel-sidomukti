@extends('layouts.admin')

@section('title', isset($apbd) ? 'Edit Data APBD' : 'Buat Data APBD Baru')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">{{ isset($apbd) ? 'Edit Data APBD' : 'Buat Data APBD Baru' }}</h2>
            <p class="text-slate-500 text-sm mt-1">Formulir komprehensif untuk memasukkan data umum dan rincian anggaran dalam sekali simpan.</p>
        </div>
        <a href="{{ route('dashboard.apbd.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl">
        <div class="font-bold text-sm mb-1">Periksa kembali isian Anda:</div>
        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ isset($apbd) ? route('dashboard.apbd.update', $apbd->id) : route('dashboard.apbd.store') }}" method="POST" enctype="multipart/form-data" id="apbdForm" class="space-y-6">
        @csrf
        @if(isset($apbd))
            @method('PUT')
        @endif

        <!-- Section 1: Informasi Umum & Berkas -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="font-bold text-blue-700 text-lg">Informasi Umum & Berkas</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                    <div class="col-span-1 md:col-span-8">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $apbd->title ?? '') }}" required placeholder="Contoh: Anggaran Pendapatan dan Belanja Kelurahan Sidomukti Tahun 2026" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Anggaran <span class="text-rose-500">*</span></label>
                        <input type="number" name="year" value="{{ old('year', $apbd->year ?? date('Y')) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Rilis <span class="text-rose-500">*</span></label>
                        <input type="date" name="date" value="{{ old('date', isset($apbd) && $apbd->date ? \Carbon\Carbon::parse($apbd->date)->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    
                    <div class="col-span-1 md:col-span-12">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi / Narasi Pengantar</label>
                        <textarea name="description" rows="3" placeholder="Narasi singkat mengenai publikasi APBD ini..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('description', $apbd->description ?? '') }}</textarea>
                    </div>

                    <div class="col-span-1 md:col-span-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Gambar Sampul / Thumbnail (Opsional)</label>
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg p-1 bg-white">
                        <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                        @if(isset($apbd) && $apbd->thumbnail)
                            <div class="mt-3">
                                <img src="{{ Storage::url($apbd->thumbnail) }}" alt="Thumbnail" class="h-24 w-auto rounded border border-slate-200 object-cover">
                            </div>
                        @endif
                    </div>

                    <div class="col-span-1 md:col-span-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lampiran Dokumen (PDF) (Opsional)</label>
                        <input type="file" name="document" accept=".pdf" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-lg p-1 bg-white">
                        <p class="text-xs text-slate-500 mt-1">Format: PDF. Maks 10MB.</p>
                        @if(isset($apbd) && $apbd->document)
                            <div class="mt-3">
                                <a href="{{ Storage::url($apbd->document) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded border border-slate-300 transition-colors">
                                    <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9v-2H7v-2h2V9h2v7zm4 0h-2v-7h2v7z"/></svg>
                                    Lihat File Saat Ini
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="col-span-1 md:col-span-12 mt-2 pt-4 border-t border-slate-100">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $apbd->is_published ?? true) ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-slate-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-bold text-slate-700">Langsung Publikasikan (Publish)</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container for dynamic items -->
        <div id="dynamicSections" class="space-y-6">
            <!-- Rincian akan di-generate via JavaScript -->
        </div>

        <!-- Total Summary Section -->
        <div class="bg-slate-800 rounded-xl shadow-md overflow-hidden text-white mb-6">
            <div class="p-4 bg-slate-900 border-b border-slate-700 text-center">
                <h5 class="font-bold text-lg text-slate-100 tracking-wide uppercase">Ringkasan Total Otomatis</h5>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-slate-700">
                    <div class="pt-4 md:pt-0">
                        <h6 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Total Pendapatan</h6>
                        <h4 class="text-2xl font-bold text-emerald-400" id="summaryTotalPendapatan">Rp 0</h4>
                    </div>
                    <div class="pt-4 md:pt-0">
                        <h6 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Total Belanja</h6>
                        <h4 class="text-2xl font-bold text-rose-400" id="summaryTotalBelanja">Rp 0</h4>
                    </div>
                    <div class="pt-4 md:pt-0">
                        <h6 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Surplus / Defisit</h6>
                        <h4 class="text-2xl font-bold text-blue-400" id="summarySurplusDefisit">Rp 0</h4>
                    </div>
                    <div class="pt-4 md:pt-0">
                        <h6 class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Pembiayaan Netto</h6>
                        <h4 class="text-2xl font-bold text-amber-400" id="summaryTotalPembiayaan">Rp 0</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 pb-12">
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-base rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                {{ isset($apbd) ? 'Simpan Perubahan' : 'Simpan Data APBD' }}
            </button>
        </div>
    </form>

</div>

<!-- Template HTML (Hidden) -->
<template id="sectionTemplate">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden section-card">
        <div class="p-4 border-b border-slate-100 flex justify-between items-center header-bg">
            <h5 class="font-bold text-white text-lg section-title">Title</h5>
            <button type="button" class="btn-add-row inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-bold rounded-lg transition-colors border border-white/30 backdrop-blur-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Baris
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 w-1/5">Sub-Kategori</th>
                        <th class="px-4 py-3 w-2/5">Uraian Pos</th>
                        <th class="px-4 py-3 w-1/5 text-right">Rencana (Rp)</th>
                        <th class="px-4 py-3 w-1/5 text-right">Realisasi (Rp)</th>
                        <th class="px-4 py-3 text-center w-12"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 section-tbody">
                    <!-- Rows will be added here -->
                </tbody>
                <tfoot class="bg-slate-50 border-t border-slate-200 font-bold text-slate-700">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right text-slate-500 uppercase tracking-wider text-xs">Sub-Total:</td>
                        <td class="px-4 py-3 text-right subtotal-anggaran text-slate-800">0</td>
                        <td class="px-4 py-3 text-right subtotal-realisasi text-slate-800">0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<template id="rowTemplate">
    <tr class="item-row hover:bg-slate-50/50 transition-colors">
        <td class="px-4 py-2">
            <input type="hidden" name="items[INDEX][jenis]" class="input-jenis">
            <select name="items[INDEX][kategori]" class="w-full px-3 py-1.5 text-xs sm:text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-kategori" required>
                <option value="">Pilih Kategori...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </td>
        <td class="px-4 py-2">
            <input type="text" name="items[INDEX][uraian]" class="w-full px-3 py-1.5 text-xs sm:text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-uraian" placeholder="Uraian Rincian" required>
        </td>
        <td class="px-4 py-2">
            <input type="text" name="items[INDEX][anggaran]" class="w-full px-3 py-1.5 text-xs sm:text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-anggaran text-right font-mono" value="0" required>
        </td>
        <td class="px-4 py-2">
            <input type="text" name="items[INDEX][realisasi]" class="w-full px-3 py-1.5 text-xs sm:text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 input-realisasi text-right font-mono" value="0" required>
        </td>
        <td class="px-4 py-2 text-center">
            <button type="button" class="btn-remove-row p-1.5 text-rose-500 hover:bg-rose-100 rounded-lg transition-colors" title="Hapus Baris">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </td>
    </tr>
</template>

@endsection

@push('scripts')
<script>
    const existingItems = @json($apbd->items ?? []);
    
    const sectionsConfig = [
        { id: 'pendapatan', title: '1. Pendapatan', bgClass: 'bg-emerald-600' },
        { id: 'belanja', title: '2. Belanja', bgClass: 'bg-rose-600' },
        { id: 'pembiayaan', title: '3. Pembiayaan', bgClass: 'bg-sky-600' }
    ];

    let globalRowIndex = 0;

    function formatCurrency(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function parseCurrency(str) {
        let val = str.toString().replace(/[^0-9-]/g, '');
        return parseInt(val) || 0;
    }

    function calculateTotals() {
        let totals = {
            pendapatan: { anggaran: 0, realisasi: 0 },
            belanja: { anggaran: 0, realisasi: 0 },
            pembiayaan: { anggaran: 0, realisasi: 0 }
        };

        sectionsConfig.forEach(sec => {
            let sectionAnggaran = 0;
            let sectionRealisasi = 0;
            
            document.querySelectorAll(`.section-card[data-jenis="${sec.id}"] .item-row`).forEach(row => {
                let ang = parseCurrency(row.querySelector('.input-anggaran').value);
                let real = parseCurrency(row.querySelector('.input-realisasi').value);
                sectionAnggaran += ang;
                sectionRealisasi += real;
            });

            totals[sec.id].anggaran = sectionAnggaran;
            totals[sec.id].realisasi = sectionRealisasi;

            let card = document.querySelector(`.section-card[data-jenis="${sec.id}"]`);
            if(card) {
                card.querySelector('.subtotal-anggaran').innerText = formatCurrency(sectionAnggaran);
                card.querySelector('.subtotal-realisasi').innerText = formatCurrency(sectionRealisasi);
            }
        });

        document.getElementById('summaryTotalPendapatan').innerText = 'Rp ' + formatCurrency(totals.pendapatan.anggaran);
        document.getElementById('summaryTotalBelanja').innerText = 'Rp ' + formatCurrency(totals.belanja.anggaran);
        document.getElementById('summaryTotalPembiayaan').innerText = 'Rp ' + formatCurrency(totals.pembiayaan.anggaran);
        
        let surplus = totals.pendapatan.anggaran - totals.belanja.anggaran;
        document.getElementById('summarySurplusDefisit').innerText = 'Rp ' + formatCurrency(surplus);
    }

    function setupCurrencyInput(input) {
        input.addEventListener('input', function(e) {
            let val = parseCurrency(this.value);
            this.value = formatCurrency(val);
            calculateTotals();
        });
        
        input.addEventListener('focus', function(e) {
            if(parseCurrency(this.value) === 0) this.value = '';
        });
        
        input.addEventListener('blur', function(e) {
            if(this.value === '') this.value = '0';
        });
    }

    function addRow(tbody, jenis, data = {}) {
        let template = document.getElementById('rowTemplate').innerHTML;
        template = template.replace(/INDEX/g, globalRowIndex++);
        
        tbody.insertAdjacentHTML('beforeend', template);
        let row = tbody.lastElementChild;
        
        row.querySelector('.input-jenis').value = jenis;
        row.querySelector('.input-kategori').value = data.kategori || '';
        row.querySelector('.input-uraian').value = data.uraian || '';
        
        let inAnggaran = row.querySelector('.input-anggaran');
        let inRealisasi = row.querySelector('.input-realisasi');
        
        inAnggaran.value = formatCurrency(data.anggaran || 0);
        inRealisasi.value = formatCurrency(data.realisasi || 0);

        setupCurrencyInput(inAnggaran);
        setupCurrencyInput(inRealisasi);

        row.querySelector('.btn-remove-row').addEventListener('click', function() {
            row.remove();
            calculateTotals();
        });
    }

    function initSections() {
        const container = document.getElementById('dynamicSections');
        
        sectionsConfig.forEach(sec => {
            let template = document.getElementById('sectionTemplate').innerHTML;
            container.insertAdjacentHTML('beforeend', template);
            
            let card = container.lastElementChild;
            card.setAttribute('data-jenis', sec.id);
            
            let header = card.querySelector('.header-bg');
            header.classList.add(sec.bgClass);
            
            card.querySelector('.section-title').innerText = sec.title;
            
            let tbody = card.querySelector('.section-tbody');
            
            card.querySelector('.btn-add-row').addEventListener('click', () => {
                addRow(tbody, sec.id);
                calculateTotals();
            });

            // Load existing items for this section
            let sectionItems = existingItems.filter(item => item.jenis === sec.id);
            if(sectionItems.length > 0) {
                sectionItems.forEach(item => addRow(tbody, sec.id, item));
            } else {
                // Add one default empty row if no items
                addRow(tbody, sec.id);
            }
        });
        
        calculateTotals();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initSections();
        
        // Remove formatting before submit
        document.getElementById('apbdForm').addEventListener('submit', function(e) {
            this.querySelectorAll('.input-anggaran, .input-realisasi').forEach(input => {
                input.value = parseCurrency(input.value);
            });
        });
    });
</script>
@endpush
