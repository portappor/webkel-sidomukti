{{-- DataTables Style Toolbar & Filter --}}
<div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 mb-6">
    @php
        $queryParams = array_filter([
            'tahun' => request('tahun') && request('tahun') !== 'all' ? request('tahun') : null,
            'search' => request('search', request('q')),
            'entries' => request('entries') && (int)request('entries') !== 10 ? request('entries') : null,
        ]);

        $allCatUrl = route('documents.index', $queryParams);
        $currentRouteName = request()->route() ? request()->route()->getName() : '';
        $currentReqCat = request('kategori', $selectedCategory ?? 'all');
        
        $isMusrenbangActive = $currentRouteName === 'documents.musrenbang' || request()->is('dokumen/musrenbang') || in_array($currentReqCat, ['musrenbang', 'dokumen-musrenbang', 'transparansi-musrenbang']);
        $isRenstraActive = $currentRouteName === 'documents.renstra_renja' || request()->is('dokumen/renstra-renja') || in_array($currentReqCat, ['renstra-renja', 'renstra_renja', 'dokumen-renstra-renja', 'transparansi-renstra']);
        $isSkActive = $currentRouteName === 'documents.sk_kelembagaan' || request()->is('dokumen/sk-kelembagaan') || in_array($currentReqCat, ['sk-kelembagaan', 'sk_kelembagaan', 'dokumen-sk-kelembagaan']);
        
        $isSemuaActive = ($currentRouteName === 'documents.index' || request()->is('dokumen')) && (empty(request('kategori')) || request('kategori') === 'all') && !$isMusrenbangActive && !$isRenstraActive && !$isSkActive;
    @endphp

    <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        @if(request()->filled('kategori'))
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        @endif
        
        <!-- Left Filter Controls -->
        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Tahun -->
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-600">Tahun:</label>
                <select name="tahun" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition cursor-pointer">
                    <option value="all" {{ (string)$selectedYear === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ (string)$selectedYear === (string)$y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Kategori -->
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-600">Kategori:</label>
                <select onchange="if(this.value) window.location.href = this.value" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition cursor-pointer">
                    <option value="{{ $allCatUrl }}" {{ $isSemuaActive ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($categories as $cat)
                        @php 
                            $cVal = $cat->slug ?: $cat->name;
                            $cSlug = \Illuminate\Support\Str::slug($cat->slug ?: $cat->name);

                            if (in_array($cSlug, ['musrenbang', 'dokumen-musrenbang', 'transparansi-musrenbang'])) {
                                $catUrl = route('documents.musrenbang', $queryParams);
                                $isSelected = $isMusrenbangActive;
                            } elseif (in_array($cSlug, ['renstra-renja', 'renstra_renja', 'dokumen-renstra-renja', 'transparansi-renstra'])) {
                                $catUrl = route('documents.renstra_renja', $queryParams);
                                $isSelected = $isRenstraActive;
                            } elseif (in_array($cSlug, ['sk-kelembagaan', 'sk_kelembagaan', 'dokumen-sk-kelembagaan'])) {
                                $catUrl = route('documents.sk_kelembagaan', $queryParams);
                                $isSelected = $isSkActive;
                            } else {
                                $catUrl = route('documents.index', array_merge(['kategori' => $cVal], $queryParams));
                                $isSelected = ($currentRouteName === 'documents.index' || request()->is('dokumen')) && ($currentReqCat === $cVal || $currentReqCat === $cSlug || $currentReqCat === $cat->name || $currentReqCat === $cat->slug);
                            }
                        @endphp
                        <option value="{{ $catUrl }}" {{ $isSelected ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Entries Per Page -->
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-slate-600">Show:</label>
                <select name="entries" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition cursor-pointer">
                    <option value="10" {{ (int)$perPage === 10 ? 'selected' : '' }}>10 entries</option>
                    <option value="25" {{ (int)$perPage === 25 ? 'selected' : '' }}>25 entries</option>
                    <option value="50" {{ (int)$perPage === 50 ? 'selected' : '' }}>50 entries</option>
                    <option value="100" {{ (int)$perPage === 100 ? 'selected' : '' }}>100 entries</option>
                </select>
            </div>
        </div>

        <!-- Right Search Control -->
        <div class="flex items-center">
            <div class="relative w-full sm:w-64 flex items-center">
                <input type="text" 
                       name="search" 
                       value="{{ request('search', request('q')) }}" 
                       placeholder="Search Here..." 
                       class="w-full pl-3.5 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-2.5 rounded-r-xl transition flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

    </form>
</div>

{{-- DataTables Style Main Table Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-emerald-700 text-white text-[11.5px] font-bold uppercase tracking-wider border-b border-emerald-800">
                    <th class="py-3.5 px-4 text-center w-14">
                        <div class="flex items-center justify-center gap-1 cursor-pointer">
                            <span>No</span>
                            <span class="text-[9px] opacity-75">▲▼</span>
                        </div>
                    </th>
                    <th class="py-3.5 px-5">
                        <div class="flex items-center gap-1.5 cursor-pointer">
                            <span>Judul Dokumen</span>
                            <span class="text-[9px] opacity-75">▲▼</span>
                        </div>
                    </th>
                    <th class="py-3.5 px-4 text-center w-24">PDF</th>
                    <th class="py-3.5 px-4 text-center w-36">BACA</th>
                    <th class="py-3.5 px-4 text-center w-40">
                        <div class="flex items-center justify-center gap-1 cursor-pointer">
                            <span>Kategori</span>
                            <span class="text-[9px] opacity-75">▲▼</span>
                        </div>
                    </th>
                    <th class="py-3.5 px-5 text-center w-36">
                        <div class="flex items-center justify-center gap-1 cursor-pointer">
                            <span>Tanggal</span>
                            <span class="text-[9px] opacity-75">▲▼</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                @forelse($documents as $index => $doc)
                @php
                    $isModel = is_object($doc);
                    $docId = $isModel ? $doc->id : ($doc['id'] ?? 0);
                    $docTitle = $isModel ? $doc->title : $doc['title'];
                    $docDesc = $isModel ? $doc->description : ($doc['description'] ?? '');
                    $docCat = $isModel ? $doc->category_label : ($doc['category'] ?? 'Dokumen');
                    $docDate = $isModel ? ($doc->published_date ? $doc->published_date->format('d-m-Y') : $doc->created_at->format('d-m-Y')) : ($doc['date'] ?? '-');
                    
                    if ($isModel) {
                        $downloadUrl = route('documents.download', $doc->id);
                        $viewUrl = route('documents.view', $doc->id);
                    } else {
                        $downloadUrl = $doc['download_url'] ?? '#';
                        $viewUrl = $doc['view_url'] ?? '#';
                    }

                    $no = method_exists($documents, 'firstItem') && $documents->firstItem() ? $documents->firstItem() + $index : $index + 1;
                @endphp
                <tr class="hover:bg-slate-50/80 transition-colors">
                    {{-- 1. No --}}
                    <td class="py-4 px-4 text-center font-bold text-slate-500">
                        {{ $no }}
                    </td>

                    {{-- 2. Judul Dokumen --}}
                    <td class="py-4 px-5 max-w-[200px] lg:max-w-[300px]">
                        <div>
                            <button type="button" 
                                    @click="previewUrl = '{{ $viewUrl }}'; previewTitle = '{{ addslashes($docTitle) }}'; openPreview = true" 
                                    class="font-bold text-slate-800 text-sm hover:text-emerald-700 transition leading-snug text-left cursor-pointer block truncate w-full">
                                {{ $docTitle }}
                            </button>
                            @if($docDesc)
                                <p class="text-slate-500 text-xs mt-1 leading-relaxed truncate w-full">
                                    {{ $docDesc }}
                                </p>
                            @endif
                        </div>
                    </td>

                    {{-- 3. PDF Button --}}
                    <td class="py-4 px-4 text-center">
                        <a href="{{ $downloadUrl }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-2xs font-bold text-xs transition active:scale-95" title="Unduh Berkas PDF">
                            <svg class="w-4 h-4 shrink-0 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                            </svg>
                            <span>PDF</span>
                        </a>
                    </td>

                    {{-- 4. Baca Dokumen --}}
                    <td class="py-4 px-4 text-center whitespace-nowrap">
                        <button type="button" 
                                @click="previewUrl = '{{ $viewUrl }}'; previewTitle = '{{ addslashes($docTitle) }}'; openPreview = true" 
                                class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl border border-blue-200/80 font-bold text-xs transition cursor-pointer active:scale-95 shadow-2xs" 
                                title="Lihat Pratinjau Dokumen">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>Lihat Dokumen</span>
                        </button>
                    </td>

                    {{-- 5. Kategori --}}
                    <td class="py-4 px-4 text-center">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200/60 inline-block">
                            {{ $docCat }}
                        </span>
                    </td>

                    {{-- 6. Tanggal --}}
                    <td class="py-4 px-5 text-center font-semibold text-slate-600 font-mono">
                        {{ $docDate }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                        Tidak ada berkas dokumen ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- DataTables Style Footer (Showing entries count & Pagination) --}}
    <div class="p-4 sm:p-5 bg-slate-50/80 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-slate-500 font-medium text-center sm:text-left">
            @if(method_exists($documents, 'total') && $documents->total() > 0)
                Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} of {{ $documents->total() }} entries
                @if(request('search') || request('q'))
                    (filtered from {{ $totalTotal ?? $documents->total() }} total entries)
                @endif
            @else
                Showing 0 to 0 of 0 entries
            @endif
        </div>

        <div>
            @if(method_exists($documents, 'links'))
                {{ $documents->links() }}
            @endif
        </div>
    </div>
</div>
