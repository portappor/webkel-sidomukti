@extends('layouts.admin')

@section('title', isset($lembaga) ? 'Edit Lembaga: ' . $lembaga->nama_lembaga : 'Tambah Lembaga Baru')

@section('content')
<div x-data="lembagaForm()">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ isset($lembaga) ? 'Edit Lembaga' : 'Tambah Lembaga Baru' }}</h1>
            <p class="text-sm text-slate-500 mt-1">Formulir komprehensif untuk memasukkan data profil dan struktur kepengurusan sekaligus.</p>
        </div>
        <a href="{{ route('dashboard.lembagas.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm px-4 py-2 rounded-xl shadow-sm border border-slate-200 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($lembaga) ? route('dashboard.lembagas.update', $lembaga->id) : route('dashboard.lembagas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($lembaga))
            @method('PUT')
        @endif

        <!-- Section 1: Identitas & Media -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <h3 class="font-bold text-emerald-700 text-lg">Identitas & Media</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lembaga <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lembaga" value="{{ old('nama_lembaga', $lembaga->nama_lembaga ?? '') }}" required placeholder="Contoh: BADAN PERMUSYAWARATAN DESA" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Singkatan / Akronim</label>
                        <input type="text" name="singkatan" value="{{ old('singkatan', $lembaga->singkatan ?? '') }}" placeholder="Contoh: BPD" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Dasar Hukum / Nomor SK Pembentukan</label>
                        <input type="text" name="dasar_hukum" value="{{ old('dasar_hukum', $lembaga->dasar_hukum ?? '') }}" placeholder="Contoh: SK Kepala Desa No..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Kantor / Sekretariat</label>
                        <input type="text" name="alamat_kantor" value="{{ old('alamat_kantor', $lembaga->alamat_kantor ?? '') }}" placeholder="Contoh: Jl. Raya Sidomukti No. 1" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Logo / Foto Lembaga (Opsional) <span class="text-xs font-normal text-slate-500">(Maks 5MB)</span></label>
                        <input type="file" name="foto_logo" accept="image/*" onchange="validateImageUpload(this)" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm bg-slate-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                        @if(isset($lembaga) && $lembaga->foto_logo_url)
                            <div class="mt-3">
                                <span class="text-xs text-slate-500 block mb-1">Logo Saat Ini:</span>
                                <img src="{{ $lembaga->foto_logo_url }}" alt="Logo" class="h-20 object-contain bg-slate-100 rounded p-1">
                            </div>
                        @endif
                    </div>
                    <div class="md:col-span-2 mt-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $lembaga->status ?? true) ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                            <span class="ms-3 text-sm font-bold text-slate-700">Lembaga Aktif / Ditampilkan</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Konten Naratif -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <h3 class="font-bold text-emerald-700 text-lg">Narasi & Profil</h3>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Profil Lembaga</label>
                    <textarea name="profil" rows="4" placeholder="Jelaskan secara singkat profil dan sejarah lembaga ini..." class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">{{ old('profil', $lembaga->profil ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Visi & Misi</label>
                    <textarea name="visi_misi" rows="4" placeholder="Tuliskan visi dan misi lembaga..." class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">{{ old('visi_misi', $lembaga->visi_misi ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tugas Pokok & Fungsi (Tupoksi)</label>
                    <textarea name="tupoksi" rows="4" placeholder="Tuliskan tupoksi lembaga, gunakan list jika perlu..." class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">{{ old('tupoksi', $lembaga->tupoksi ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Kepengurusan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <h3 class="font-bold text-emerald-700 text-lg">Struktur Kepengurusan</h3>
                </div>
                <button type="button" @click="addMember" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-bold text-xs uppercase px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Pengurus
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 w-10 text-center">No</th>
                            <th class="px-4 py-3">Nama Lengkap</th>
                            <th class="px-4 py-3">Jabatan</th>
                            <th class="px-4 py-3">Pendidikan Terakhir</th>
                            <th class="px-4 py-3 w-16 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(member, index) in members" :key="index">
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-4 py-3 text-center text-slate-500 font-medium" x-text="index + 1"></td>
                                <td class="px-4 py-2">
                                    <input type="text" x-model="member.nama" :name="`members[${index}][nama]`" placeholder="Nama Lengkap" required class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" x-model="member.jabatan" :name="`members[${index}][jabatan]`" placeholder="Ketua / Sekretaris / Dll" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" x-model="member.pendidikan" :name="`members[${index}][pendidikan]`" placeholder="SMA / S1 / Dll" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button" @click="removeMember(index)" class="text-rose-500 hover:text-rose-700 bg-rose-50 p-2 rounded-lg transition-colors" title="Hapus Baris">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="members.length === 0">
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                Belum ada pengurus ditambahkan. Klik tombol "Tambah Pengurus" untuk memulai.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end pt-4 pb-12">
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base rounded-xl shadow-lg shadow-emerald-500/30 transition-all hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                {{ isset($lembaga) ? 'Simpan Perubahan' : 'Simpan Data Lembaga' }}
            </button>
        </div>
    </form>
</div>

<script>
function lembagaForm() {
    return {
        members: @json(isset($lembaga) ? $lembaga->members : []),
        init() {
            if (this.members.length === 0) {
                this.addMember();
            }
        },
        addMember() {
            this.members.push({
                nama: '',
                jabatan: '',
                pendidikan: ''
            });
        },
        removeMember(index) {
            this.members.splice(index, 1);
        }
    }
}
</script>
@endsection
