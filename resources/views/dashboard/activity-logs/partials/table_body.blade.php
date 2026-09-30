@forelse($logs as $log)
<tr class="hover:bg-slate-50/80 transition">
    <!-- Waktu -->
    <td class="p-4 whitespace-nowrap text-slate-500 font-medium">
        <div>{{ $log->created_at->format('d M Y') }}</div>
        <div class="text-[11px] text-slate-400">{{ $log->created_at->format('H:i:s') }} WIB</div>
    </td>

    <!-- Pengguna -->
    <td class="p-4 whitespace-nowrap">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                {{ strtoupper(substr($log->user_name, 0, 1)) }}
            </div>
            <div class="flex flex-col">
                <span class="font-bold text-slate-800">{{ $log->user_name }}</span>
                @if($log->user_role === 'admin')
                    <span class="text-[9px] font-extrabold uppercase text-purple-600">Admin</span>
                @elseif($log->user_role === 'staf')
                    <span class="text-[9px] font-extrabold uppercase text-blue-600">Staf</span>
                @else
                    <span class="text-[9px] font-extrabold uppercase text-slate-400">Guest</span>
                @endif
            </div>
        </div>
    </td>

    <!-- Modul -->
    <td class="p-4 whitespace-nowrap">
        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-[11px]">
            {{ $log->module }}
        </span>
    </td>

    <!-- Aksi Badge -->
    <td class="p-4 whitespace-nowrap">
        @switch($log->action)
            @case('CREATE')
                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase tracking-wider">CREATE</span>
                @break
            @case('UPDATE')
                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-extrabold text-[10px] uppercase tracking-wider">UPDATE</span>
                @break
            @case('DELETE')
                <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 font-extrabold text-[10px] uppercase tracking-wider">DELETE</span>
                @break
            @case('LOGIN')
                <span class="px-2.5 py-1 rounded-full bg-sky-100 text-sky-800 font-extrabold text-[10px] uppercase tracking-wider">LOGIN</span>
                @break
            @case('LOGOUT')
                <span class="px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 font-extrabold text-[10px] uppercase tracking-wider">LOGOUT</span>
                @break
            @case('UPDATE_STATUS')
                <span class="px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800 font-extrabold text-[10px] uppercase tracking-wider">STATUS</span>
                @break
            @default
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-extrabold text-[10px] uppercase tracking-wider">{{ $log->action }}</span>
        @endswitch
    </td>

    <!-- Deskripsi -->
    <td class="p-4 font-medium text-slate-700 max-w-md">
        {{ $log->description }}
    </td>

    <!-- IP Address -->
    <td class="p-4 whitespace-nowrap text-slate-500 font-mono text-[11px]">
        {{ $log->ip_address ?? '-' }}
    </td>

    <!-- Detail Button -->
    <td class="p-4 whitespace-nowrap text-center">
        <button @click="selectedLog = {{ json_encode($log) }}" 
                class="p-2 bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-600 rounded-lg transition" 
                title="Lihat Rincian Meta">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="p-12 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="font-bold text-sm text-slate-600">Tidak ada log aktivitas ditemukan</p>
        <p class="text-xs text-slate-400 mt-1">Coba atur ulang kata kunci atau filter pencarian Anda.</p>
    </td>
</tr>
@endforelse
