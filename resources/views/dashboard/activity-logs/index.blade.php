@extends('layouts.admin')

@section('title', 'Kelola Log Aktivitas')

@section('content')
<div x-data="{ 
    showClearModal: false, 
    selectedLog: null, 
    autoUpdate: localStorage.getItem('auto_update_log') === 'true',
    timer: null,
    countdown: 10,
    isFetching: false,
    statTotalLogs: '{{ number_format($totalLogs) }}',
    statTodayLogs: '{{ number_format($todayLogs) }}',
    statAdminLogs: '{{ number_format($adminLogs) }}',
    statStaffLogs: '{{ number_format($staffLogs) }}',
    toggleAutoUpdate() {
        this.autoUpdate = !this.autoUpdate;
        localStorage.setItem('auto_update_log', this.autoUpdate);
        if (this.autoUpdate) {
            this.startTimer();
        } else {
            this.stopTimer();
        }
    },
    fetchLatestData() {
        this.isFetching = true;
        let url = new URL(window.location.href);
        url.searchParams.set('ajax', '1');

        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.stats) {
                this.statTotalLogs = data.stats.totalLogs;
                this.statTodayLogs = data.stats.todayLogs;
                this.statAdminLogs = data.stats.adminLogs;
                this.statStaffLogs = data.stats.staffLogs;
            }

            const tbody = document.getElementById('logs-table-body');
            if (tbody && data.table_html) {
                tbody.innerHTML = data.table_html;
            }

            const paginContainer = document.getElementById('logs-pagination-container');
            if (paginContainer) {
                paginContainer.innerHTML = data.pagination_html || '';
            }
        })
        .catch(err => console.error('Silent auto update error:', err))
        .finally(() => {
            this.isFetching = false;
        });
    },
    startTimer() {
        this.stopTimer();
        this.countdown = 10;
        this.timer = setInterval(() => {
            this.countdown--;
            if (this.countdown <= 0) {
                this.fetchLatestData();
                this.countdown = 10;
            }
        }, 1000);
    },
    stopTimer() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },
    init() {
        if (this.autoUpdate) {
            this.startTimer();
        }
    }
}">

    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5 flex-wrap">
                <div class="p-2 bg-emerald-500/10 text-emerald-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span>Log Aktivitas Sistem</span>
                <span x-show="autoUpdate" x-cloak class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-700 border border-emerald-300 shadow-xs animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    LIVE AUTO UPDATE (<span x-text="countdown"></span>s)
                </span>
            </h2>
            <p class="text-slate-500 text-sm mt-1">Audit trail & riwayat seluruh aktivitas Admin dan Staf pada sistem secara real-time.</p>
        </div>
        
        <div class="flex items-center gap-2.5 flex-wrap">
            <!-- Tombol Manual Refresh Instant -->
            <button @click="fetchLatestData()" 
                    :class="isFetching ? 'animate-spin text-emerald-600' : 'text-slate-600 hover:text-emerald-600'"
                    class="p-2.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition shadow-xs cursor-pointer" title="Refresh Log Sekarang">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>

            <!-- Tombol Auto Update Real-time Toggle -->
            <button @click="toggleAutoUpdate()" 
                    :class="autoUpdate ? 'bg-emerald-600 text-white border-emerald-600 hover:bg-emerald-700 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50 shadow-xs'"
                    class="border font-bold py-2.5 px-4 rounded-xl text-xs transition-all duration-200 flex items-center gap-2 cursor-pointer select-none">
                <template x-if="autoUpdate">
                    <span class="flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-200 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Auto Update ON (<span x-text="countdown"></span>s)
                    </span>
                </template>
                <template x-if="!autoUpdate">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Auto Update OFF
                    </span>
                </template>
            </button>

            <!-- Tombol Bersihkan Log -->
            <button @click="showClearModal = true" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold py-2.5 px-4 rounded-xl text-xs transition flex items-center gap-2 shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Bersihkan Log
            </button>
        </div>
    </div>

    

    <!-- 4 Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Log -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Log</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1" x-text="statTotalLogs"></h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Keseluruhan entri aktivitas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>

        <!-- Hari Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Aktivitas Hari Ini</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-1" x-text="statTodayLogs"></h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Tercatat {{ date('d M Y') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <!-- Aktivitas Admin -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-purple-600">Aktivitas Admin</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1" x-text="statAdminLogs"></h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Tindakan akun Admin</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>

        <!-- Aktivitas Staf -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Aktivitas Staf</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1" x-text="statStaffLogs"></h3>
                <p class="text-[11px] text-slate-500 mt-0.5">Tindakan Operator/Staf</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar Card -->
    <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-100 mb-6">
        <form action="{{ route('dashboard.activity-logs.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <!-- Search Input -->
                <div class="lg:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cari Kata Kunci</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi, nama, IP..." 
                               class="w-full pl-9 pr-3 py-2 rounded-xl text-xs border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Peran -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Peran User</label>
                    <select name="role" class="w-full py-2 px-3 rounded-xl text-xs border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        <option value="">Semua Peran</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staf" {{ request('role') === 'staf' ? 'selected' : '' }}>Staf</option>
                    </select>
                </div>

                <!-- Modul -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Modul / Fitur</label>
                    <select name="module" class="w-full py-2 px-3 rounded-xl text-xs border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        <option value="">Semua Modul</option>
                        @foreach($modulesList as $mod)
                            <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Aksi -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Jenis Aksi</label>
                    <select name="action" class="w-full py-2 px-3 rounded-xl text-xs border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                        <option value="">Semua Aksi</option>
                        @foreach($actionsList as $act)
                            <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" 
                           class="w-full py-2 px-3 rounded-xl text-xs border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                @if(request()->anyFilled(['search', 'role', 'module', 'action', 'start_date', 'end_date', 'user_id']))
                <a href="{{ route('dashboard.activity-logs.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset Filter
                </a>
                @endif

                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition flex items-center gap-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-100 overflow-hidden relative">
        <!-- Loading Overlay during Silent Auto Update -->
        <div x-show="isFetching" x-cloak class="absolute inset-0 bg-white/50 backdrop-blur-[1px] z-10 flex items-center justify-center">
            <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-900/80 text-white rounded-xl text-xs font-bold shadow-lg">
                <svg class="w-4 h-4 animate-spin text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Memperbarui log...
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs border-b border-slate-200">
                        <th class="p-4 font-bold uppercase tracking-wider">Waktu</th>
                        <th class="p-4 font-bold uppercase tracking-wider">Pengguna</th>
                        <th class="p-4 font-bold uppercase tracking-wider">Modul</th>
                        <th class="p-4 font-bold uppercase tracking-wider">Aksi</th>
                        <th class="p-4 font-bold uppercase tracking-wider">Deskripsi Aktivitas</th>
                        <th class="p-4 font-bold uppercase tracking-wider">IP Address</th>
                        <th class="p-4 font-bold uppercase tracking-wider text-center">Rincian</th>
                    </tr>
                </thead>
                <tbody id="logs-table-body" class="divide-y divide-slate-100 text-xs">
                    @include('dashboard.activity-logs.partials.table_body')
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="logs-pagination-container" class="p-4 border-t border-slate-100 bg-slate-50/50">
            @if($logs->hasPages())
                {{ $logs->links() }}
            @endif
        </div>
    </div>

    <!-- Modal Detail Log -->
    <div x-show="selectedLog" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"></div>
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all border border-slate-100">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rincian Log Aktivitas #<span x-text="selectedLog?.id"></span>
                    </h3>
                    <button @click="selectedLog = null" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-4 space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block mb-0.5">Waktu Eksekusi:</span>
                        <p class="font-bold text-slate-800" x-text="selectedLog ? new Date(selectedLog.created_at).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'medium' }) : ''"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class="text-slate-400 font-medium block mb-0.5">Pelaksana:</span>
                            <p class="font-bold text-slate-800" x-text="selectedLog?.user_name"></p>
                            <span class="text-[10px] uppercase font-bold text-emerald-600" x-text="selectedLog?.user_role"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block mb-0.5">Modul & Aksi:</span>
                            <p class="font-bold text-slate-800" x-text="selectedLog?.module"></p>
                            <span class="text-[10px] uppercase font-bold text-indigo-600" x-text="selectedLog?.action"></span>
                        </div>
                    </div>

                    <div>
                        <span class="text-slate-400 font-medium block mb-0.5">Deskripsi Lengkap:</span>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 font-medium text-slate-700 leading-relaxed" x-text="selectedLog?.description"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class="text-slate-400 font-medium block mb-0.5">IP Address:</span>
                            <p class="font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded inline-block" x-text="selectedLog?.ip_address || '-'"></p>
                        </div>
                    </div>

                    <div>
                        <span class="text-slate-400 font-medium block mb-0.5">User Agent (Browser):</span>
                        <p class="font-mono text-[10px] text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-200 break-all" x-text="selectedLog?.user_agent || '-'"></p>
                    </div>

                    <template x-if="selectedLog?.properties">
                        <div>
                            <span class="text-slate-400 font-medium block mb-0.5">Metadata (Properties JSON):</span>
                            <pre class="bg-slate-900 text-emerald-400 text-[10px] p-3 rounded-xl overflow-x-auto font-mono" x-text="JSON.stringify(selectedLog.properties, null, 2)"></pre>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="selectedLog = null" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold text-xs transition">
                        Tutup Rincian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Clear Log -->
    <div x-show="showClearModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs transition-opacity"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Pembersihan Log Aktivitas
                </h3>
                <p class="text-xs text-slate-500 mt-2">Pilih rentang waktu log aktivitas yang ingin dibersihkan dari database sistem.</p>

                <form action="{{ route('dashboard.activity-logs.clear') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Hapus log yang lebih lama dari:</label>
                        <select name="days" class="w-full py-2 px-3 rounded-xl text-xs border border-slate-200 focus:ring-2 focus:ring-emerald-500">
                            <option value="30">30 Hari yang lalu</option>
                            <option value="60">60 Hari yang lalu</option>
                            <option value="90">90 Hari yang lalu</option>
                            <option value="0" class="text-rose-600 font-bold">Hapus Seluruh Log (Reset Total)</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showClearModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                            Batal
                        </button>
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data log tersebut?');" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition shadow-xs">
                            Ya, Hapus Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
