@extends('layouts.admin')

@section('title', 'Kelola Dokumen PDF Publik')

@section('content')
<div x-data="{ uploadModal: false, editModal: false, editDoc: { id: '', title: '', category: '', published_date: '', organization: '', description: '', file_url: '' } }" @open-edit-modal.window="editDoc = $event.detail; editModal = true;">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Dokumen PDF Publik</h1>
            <p class="text-sm text-slate-500 mt-1">Manajemen arsip dokumen resmi kelurahan (Musrenbang, Renstra & Renja, SK Kelembagaan).</p>
        </div>

        <button @click="uploadModal = true" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            + Unggah Dokumen PDF
        </button>
    </div>

    <!-- Modal Form Unggah Dokumen PDF -->
    <div x-show="uploadModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
                <!-- Modal Dark Emerald Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                                DOKUMEN PDF PUBLIK
                            </span>
                            <h3 class="text-base font-black text-white mt-0.5">Unggah Berkas PDF Baru</h3>
                        </div>
                    </div>
                    <button type="button" @click="uploadModal = false" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('dashboard.documents.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateDocumentForm(this)" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                    @csrf

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium" placeholder="Contoh: Berita Acara Musrenbang 2026">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Dokumen <span class="text-rose-500">*</span></label>
                            <select name="category" id="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->slug ?: $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                @else
                                    <option value="musrenbang">Musrenbang</option>
                                    <option value="renstra_renja">Renstra & Renja</option>
                                    <option value="sk_kelembagaan">SK Kelembagaan</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="published_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Dokumen</label>
                            <input type="date" name="published_date" id="published_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                        </div>
                    </div>

                    <div>
                        <label for="organization" class="block text-xs font-bold text-slate-700 mb-1.5">Organisasi / Lembaga (Opsional)</label>
                        <input type="text" name="organization" id="organization" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Contoh: RT / RW, TP-PKK, LPMK">
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400" placeholder="Ringkasan isi dokumen..."></textarea>
                    </div>

                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Opsi A: Upload Berkas PDF (Maks. 10 MB)</label>
                            <input type="file" name="document_file" id="document_file" accept=".pdf,application/pdf" onchange="validatePdfUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                        </div>

                        <div class="text-[10px] text-slate-400 text-center font-bold uppercase">atau link tautan online pdf</div>

                        <div>
                            <input type="url" name="file_url" id="file_url" onchange="validatePdfUrlInput(this)" onblur="validatePdfUrlInput(this)" placeholder="https://example.com/dokumen.pdf" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="uploadModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Unggah Berkas</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Form Edit Dokumen PDF -->
    <div x-show="editModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         x-cloak>
        
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs transition-opacity"></div>

        <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 my-auto">
                <!-- Modal Dark Emerald Header -->
                <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">
                                DOKUMEN PDF PUBLIK
                            </span>
                            <h3 class="text-base font-black text-white mt-0.5">Edit Dokumen PDF</h3>
                        </div>
                    </div>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-white/10 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/dashboard/documents/' + editDoc.id" method="POST" enctype="multipart/form-data" onsubmit="return validateDocumentForm(this)" class="p-6 space-y-4 max-h-[85vh] overflow-y-auto custom-scrollbar">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="edit_title" class="block text-xs font-bold text-slate-700 mb-1.5">Judul Dokumen <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="edit_title" x-model="editDoc.title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-2xs text-xs font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_category" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Dokumen <span class="text-rose-500">*</span></label>
                            <select name="category" id="edit_category" x-model="editDoc.category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-bold bg-white">
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->slug ?: $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                @else
                                    <option value="musrenbang">Musrenbang</option>
                                    <option value="renstra_renja">Renstra & Renja</option>
                                    <option value="sk_kelembagaan">SK Kelembagaan</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="edit_published_date" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Dokumen</label>
                            <input type="date" name="published_date" id="edit_published_date" x-model="editDoc.published_date" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 font-medium">
                        </div>
                    </div>

                    <div>
                        <label for="edit_organization" class="block text-xs font-bold text-slate-700 mb-1.5">Organisasi / Lembaga (Opsional)</label>
                        <input type="text" name="organization" id="edit_organization" x-model="editDoc.organization" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-800 placeholder-slate-400">
                    </div>

                    <div>
                        <label for="edit_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                        <textarea name="description" id="edit_description" x-model="editDoc.description" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 text-xs font-medium text-slate-800 placeholder-slate-400"></textarea>
                    </div>

                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 bg-slate-50 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Berkas PDF (Opsional, biarkan kosong jika tidak diganti)</label>
                            <input type="file" name="document_file" id="edit_document_file" accept=".pdf,application/pdf" onchange="validatePdfUpload(this, null, '', 10)" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                        </div>

                        <div class="text-[10px] text-slate-400 text-center font-bold uppercase">atau ubah link tautan online</div>

                        <div>
                            <input type="url" name="file_url" id="edit_file_url" x-model="editDoc.file_url" onchange="validatePdfUrlInput(this)" onblur="validatePdfUrlInput(this)" placeholder="https://example.com/dokumen.pdf" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="editModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    

    <!-- Filter Kategori Dropdown dihilangkan sesuai permintaan -->

    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden p-2 sm:p-4">
        <div class="overflow-x-auto">
            <table id="dataTable" class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-semibold border-b border-slate-200 text-[11px] tracking-wider">
                    <tr>
                        <th scope="col" class="px-4 py-3.5">Tanggal</th>
                        <th scope="col" class="px-6 py-3.5">Judul Dokumen</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Kategori</th>
                        <th scope="col" class="px-4 py-3.5 text-center">Ukuran</th>
                        <th scope="col" class="px-6 py-3.5 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-700 font-semibold">
                            {{ $doc->published_date ? $doc->published_date->translatedFormat('d M Y') : $doc->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 max-w-[200px] lg:max-w-[300px]">
                            <div class="font-bold text-slate-800 text-sm mb-1 leading-snug line-clamp-2 break-words">{{ $doc->title }}</div>
                            @if($doc->description)
                            <div class="text-xs text-slate-500 truncate">{{ $doc->description }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-[10px] font-extrabold uppercase tracking-wider">
                                {{ $doc->category_label }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center whitespace-nowrap">
                            <span class="text-xs font-mono text-slate-500 font-bold">{{ $doc->file_size }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('dashboard.documents.download', $doc->id) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-lg transition" title="Unduh PDF">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                </a>

                                <button type="button" onclick='window.dispatchEvent(new CustomEvent("open-edit-modal", { detail: {{ json_encode([
                                    "id" => (string)$doc->id,
                                    "title" => (string)$doc->title,
                                    "category" => (string)$doc->category,
                                    "published_date" => $doc->published_date ? $doc->published_date->format("Y-m-d") : "",
                                    "organization" => (string)($doc->organization ?? ""),
                                    "description" => (string)($doc->description ?? ""),
                                    "file_url" => Str::startsWith($doc->file_path ?? "", ["http://", "https://"]) ? (string)$doc->file_path : "",
                                ]) }} }))' class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" title="Edit Dokumen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>

                                <form action="{{ route('dashboard.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen PDF {{ addslashes($doc->title) }}?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Hapus Dokumen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 font-medium">
                            Tidak ada dokumen ditemukan untuk kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
window.validatePdfUrlInput = function(input) {
    const val = input.value ? input.value.trim() : '';
    if (!val) return true;

    // Validate that input URL starts with http:// or https:// and contains/ends with .pdf
    const isPdfUrl = /^https?:\/\/.+/i.test(val) && /\.pdf($|\?|#)/i.test(val);
    if (!isPdfUrl) {
        input.value = '';
        input.dispatchEvent(new Event('input'));
        alert('🚫 AKSES DITOLAK!\n\nTautan link URL berkas \'' + val + '\' tidak diperbolehkan.\n\nHanya tautan link URL berkas PDF yang diperbolehkan (harus diawali http:// atau https:// dan berakhiran .pdf)!');
        return false;
    }
    return true;
};

window.validateDocumentForm = function(form) {
    const fileInput = form.querySelector('input[type="file"]');
    if (fileInput && fileInput.files && fileInput.files.length > 0) {
        if (!validatePdfUpload(fileInput, null, '', 10)) {
            return false;
        }
    }

    const urlInput = form.querySelector('input[name="file_url"]');
    if (urlInput && urlInput.value.trim() !== '') {
        if (!validatePdfUrlInput(urlInput)) {
            return false;
        }
    }

    const isEdit = form.getAttribute('method') && form.getAttribute('method').toUpperCase() === 'POST' && form.querySelector('input[name="_method"]');
    if (!isEdit) {
        const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
        const hasUrl = urlInput && urlInput.value.trim() !== '';
        if (!hasFile && !hasUrl) {
            alert('🚫 AKSES DITOLAK!\n\nSilakan pilih berkas PDF untuk diunggah atau masukkan link tautan online berkas PDF!');
            return false;
        }
    }

    return true;
};
</script>

@push('scripts')
<script>
    $(document).ready(function() {
        // Wait for DataTables to fully initialize if it's async, 
        // though document.ready usually suffices because DT initializes synchronously here.
        // setTimeout(function() { ...
        // }, 100);
    });
</script>
@endpush
@endsection
