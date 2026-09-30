@extends('layouts.admin')

@section('title', 'Kelola Wilayah RT & RW')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Kelola Wilayah RT & RW</h2>
    <p class="text-slate-500 text-sm">Kelola data Sebaran Lingkungan Rukun Warga (RW) dan Rukun Tetangga (RT) Kelurahan Sidomukti.</p>
</div>



@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Sebaran Lingkungan Rukun Warga (RW) -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
            <h3 class="text-lg font-bold text-slate-800">Sebaran Lingkungan Rukun Warga (RW)</h3>
        </div>
        <button type="button" onclick="openModal('addModal')" class="bg-green-50 text-green-700 font-bold py-2 px-4 rounded-lg text-sm hover:bg-green-100 transition">
            + Tambah RW
        </button>
    </div>
    
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4">Nama Lingkungan / RW</th>
                        <th scope="col" class="px-6 py-4">Jumlah RT</th>
                        <th scope="col" class="px-6 py-4">Estimasi Penduduk</th>
                        <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rukunWargas as $rw)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $rw->nama_rw }}</td>
                        <td class="px-6 py-4 font-bold text-green-600">{{ $rw->jumlah_rt }} RT</td>
                        <td class="px-6 py-4"><span class="font-bold text-slate-800">{{ $rw->estimasi_penduduk }}</span> Jiwa</td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openEditModal({{ $rw->id }}, '{{ addslashes($rw->nama_rw) }}', {{ $rw->jumlah_rt }}, {{ $rw->estimasi_penduduk }})" class="text-slate-600 hover:text-slate-900 bg-slate-100 px-3 py-1.5 rounded-md text-xs font-semibold mr-2 transition">Edit</button>
                            <form action="{{ route('dashboard.rt-rw.destroy', $rw->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data RW ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 px-3 py-1.5 rounded-md text-xs font-semibold transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500 italic">Belum ada data sebaran Rukun Warga.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah RW -->
<div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-lg my-auto transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Wilayah RT / RW</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Tambah Rukun Warga</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('addModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('dashboard.rt-rw.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <div class="p-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lingkungan / RW <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_rw" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" placeholder="Contoh: RW 01 Kraksaan Timur" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Jumlah RT <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_rt" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Estimasi Penduduk (Jiwa) <span class="text-red-500">*</span></label>
                    <input type="number" name="estimasi_penduduk" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" required>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('addModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit RW -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-lg my-auto transform scale-95 overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100 flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-950 px-6 py-5 border-b border-emerald-800/50 flex items-center justify-between text-white relative shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Wilayah RT / RW</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Edit Rukun Warga</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('editModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="editForm" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lingkungan / RW <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_rw" id="edit_nama_rw" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Jumlah RT <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_rt" id="edit_jumlah_rt" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Estimasi Penduduk (Jiwa) <span class="text-red-500">*</span></label>
                    <input type="number" name="estimasi_penduduk" id="edit_estimasi_penduduk" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" required>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('editModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        const inner = modal.querySelector('div');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            inner.classList.remove('scale-95');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const inner = modal.querySelector('div');
        modal.classList.add('opacity-0');
        inner.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, nama, rt, penduduk) {
        document.getElementById('edit_nama_rw').value = nama;
        document.getElementById('edit_jumlah_rt').value = rt;
        document.getElementById('edit_estimasi_penduduk').value = penduduk;
        
        // Update form action
        const form = document.getElementById('editForm');
        form.action = `/dashboard/rt-rw/${id}`;
        
        openModal('editModal');
    }
</script>
@endsection
