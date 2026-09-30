@extends('layouts.admin')

@section('title', 'Kelola Data & Statistik')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Data & Statistik Kelurahan</h2>
        <p class="text-slate-500 text-sm mt-1">Manajemen data demografi, monografi, angka statistik kependudukan, serta sebaran wilayah RT & RW.</p>
    </div>
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

<form action="{{ route('dashboard.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <!-- 1. Angka Demografi Terkini -->
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">1. Angka Demografi & Wilayah Terkini</h3>
                    <p class="text-xs text-slate-500">Statistik kependudukan umum dan luas cakupan wilayah kelurahan.</p>
                </div>
            </div>
            <span class="text-xs font-semibold px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200 hidden sm:inline-block">Modul Demografi</span>
        </div>
        
        <div class="p-6 space-y-6">
            <!-- Sub-group A: Data Kependudukan -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Jumlah Penduduk & Jenis Kelamin
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/80 focus-within:border-emerald-500 transition">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Total Penduduk (Jiwa) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="demografi_total" id="demografi_total" value="{{ $settings['demografi_total'] ?? '2776' }}" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 bg-slate-100 font-semibold text-slate-500 text-sm cursor-not-allowed" readonly required>
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">Jiwa</span>
                        </div>
                    </div>

                    <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/80 focus-within:border-emerald-500 transition">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Total KK <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="demografi_kk" value="{{ $settings['demografi_kk'] ?? '850' }}" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-emerald-500 bg-white font-semibold text-slate-800 text-sm" required>
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">KK</span>
                        </div>
                    </div>

                    <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/80 focus-within:border-emerald-500 transition">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Penduduk Laki-Laki</label>
                            <span id="pct_laki" class="text-[10px] font-extrabold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full border border-emerald-200">0%</span>
                        </div>
                        <div class="relative">
                            <input type="number" name="demografi_laki" value="{{ $settings['demografi_laki'] ?? '1402' }}" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-emerald-500 bg-white font-semibold text-slate-800 text-sm">
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">Jiwa</span>
                        </div>
                    </div>

                    <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/80 focus-within:border-emerald-500 transition">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Penduduk Perempuan</label>
                            <span id="pct_perempuan" class="text-[10px] font-extrabold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full border border-emerald-200">0%</span>
                        </div>
                        <div class="relative">
                            <input type="number" name="demografi_perempuan" value="{{ $settings['demografi_perempuan'] ?? '1374' }}" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-emerald-500 bg-white font-semibold text-slate-800 text-sm">
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-medium">Jiwa</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Tombol Simpan Statistik Utama -->
    <div class="flex justify-end mb-8">
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-md shadow-emerald-600/20 hover:-translate-y-0.5 transition flex items-center gap-2 cursor-pointer text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Perubahan Statistik
        </button>
    </div>
</form>

<!-- 2. Sebaran Lingkungan Rukun Warga (RW) & RT -->
<div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-sm shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0v5"></path></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">2. Sebaran Lingkungan Rukun Warga (RW) & RT</h3>
                <p class="text-xs text-slate-500">Daftar wilayah RW, jumlah RT, dan estimasi penduduk di tiap lingkungan.</p>
            </div>
        </div>
        <button type="button" onclick="openModal('addModal')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-md transition flex items-center gap-2 text-xs uppercase tracking-wider cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah RW Baru
        </button>
    </div>
    
    <div class="p-4 sm:p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-xs tracking-wider border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-3.5">Nama Lingkungan / RW</th>
                        <th scope="col" class="px-6 py-3.5">Jumlah RT</th>
                        <th scope="col" class="px-6 py-3.5">Estimasi Penduduk</th>
                        <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rukunWargas as $rw)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $rw->nama_rw }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $rw->jumlah_rt }} RT
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-700">
                            <span class="font-bold text-slate-900">{{ number_format($rw->estimasi_penduduk, 0, ',', '.') }}</span> Jiwa
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" 
                                        onclick="openEditModal({{ $rw->id }}, '{{ addslashes($rw->nama_rw) }}', {{ $rw->jumlah_rt }}, {{ $rw->estimasi_penduduk }})" 
                                        class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition cursor-pointer" 
                                        title="Edit Data RW">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('dashboard.rt-rw.destroy', $rw->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data RW ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition cursor-pointer" title="Hapus Data RW">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 italic">Belum ada data sebaran Rukun Warga.</td>
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
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Demografi & Wilayah</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Tambah Rukun Warga (RW)</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('addModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form action="{{ route('dashboard.rt-rw.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf

            <!-- Form Body -->
            <div class="p-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Nama Lingkungan / RW <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_rw" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" placeholder="Contoh: RW 01 Kraksaan Timur" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Jumlah RT <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_rt" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" placeholder="Contoh: 4" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Estimasi Penduduk (Jiwa) <span class="text-red-500">*</span></label>
                    <input type="number" name="estimasi_penduduk" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 text-sm transition" placeholder="Contoh: 450" required>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModal('addModal')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition cursor-pointer">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Simpan RW</span>
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
                        <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-400 text-[9px] font-extrabold rounded-full uppercase tracking-wider border border-emerald-500/30">Demografi & Wilayah</span>
                    </div>
                    <h3 class="text-base font-bold text-white tracking-wide">Edit Rukun Warga (RW)</h3>
                </div>
            </div>
            <button type="button" onclick="closeModal('editModal')" class="text-slate-400 hover:text-white transition p-1.5 rounded-xl hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Form -->
        <form id="editForm" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')

            <!-- Form Body -->
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

            <!-- Footer Actions -->
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
        if (!modal) return;
        const inner = modal.firstElementChild;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            if (inner) {
                inner.classList.remove('scale-95');
                inner.classList.add('scale-100');
            }
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        const inner = modal.firstElementChild;
        modal.classList.add('opacity-0');
        if (inner) {
            inner.classList.remove('scale-100');
            inner.classList.add('scale-95');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(id, nama, rt, penduduk) {
        document.getElementById('edit_nama_rw').value = nama;
        document.getElementById('edit_jumlah_rt').value = rt;
        document.getElementById('edit_estimasi_penduduk').value = penduduk;
        
        const form = document.getElementById('editForm');
        form.action = `/dashboard/rt-rw/${id}`;
        
        openModal('editModal');
    }

    // Dynamic Live Percentage Calculator
    function calculatePercentages() {
        const laki = parseFloat(document.querySelector('input[name="demografi_laki"]')?.value) || 0;
        const perempuan = parseFloat(document.querySelector('input[name="demografi_perempuan"]')?.value) || 0;

        // Auto Calculate Total Pop
        const totalPop = laki + perempuan;
        
        const totalInput = document.getElementById('demografi_total');
        if (totalInput) {
            totalInput.value = totalPop;
        }

        // Gender vs Total Pop
        const pctLaki = totalPop > 0 ? ((laki / totalPop) * 100).toFixed(1) : 0;
        const pctPerempuan = totalPop > 0 ? ((perempuan / totalPop) * 100).toFixed(1) : 0;

        // Update UI badges
        const elLaki = document.getElementById('pct_laki');
        if (elLaki) elLaki.innerText = pctLaki + '%';

        const elPerempuan = document.getElementById('pct_perempuan');
        if (elPerempuan) elPerempuan.innerText = pctPerempuan + '%';
    }

    document.addEventListener('DOMContentLoaded', function() {
        calculatePercentages();

        const targetInputs = [
            'demografi_laki', 'demografi_perempuan'
        ];

        targetInputs.forEach(name => {
            const input = document.querySelector(`input[name="${name}"]`);
            if (input) {
                input.addEventListener('input', calculatePercentages);
                input.addEventListener('keyup', calculatePercentages);
                input.addEventListener('change', calculatePercentages);
            }
        });
    });
</script>
@endsection
