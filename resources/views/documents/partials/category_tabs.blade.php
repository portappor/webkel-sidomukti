@php
    $docCategories = \App\Models\Category::where('module', 'dokumen')
        ->where('status', 'aktif')
        ->orderBy('order', 'asc')
        ->orderBy('id', 'asc')
        ->get();

    $reqCat = request()->get('kategori');
    $isSemuaActive = request()->routeIs('documents.index') && (empty($reqCat) || $reqCat === 'all');
@endphp

<div class="flex flex-wrap items-center gap-2 mb-8 pb-3 border-b border-slate-200/80">
    <!-- Semua Dokumen -->
    <a href="{{ route('documents.index') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ $isSemuaActive ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/20' : 'bg-white text-slate-700 border border-slate-200/90 hover:bg-slate-50 hover:text-emerald-700 font-medium' }}">
        <span>Semua Dokumen</span>
    </a>

    @foreach($docCategories as $cat)
        @php 
            $cVal = $cat->slug ?: $cat->name;
            $cSlug = \Illuminate\Support\Str::slug($cat->slug ?: $cat->name);

            if (in_array($cSlug, ['musrenbang', 'dokumen-musrenbang'])) {
                $catRoute = route('documents.musrenbang');
                $isTabActive = request()->routeIs('documents.musrenbang') || request()->is('dokumen/musrenbang');
            } elseif (in_array($cSlug, ['renstra-renja', 'renstra_renja', 'dokumen-renstra-renja'])) {
                $catRoute = route('documents.renstra_renja');
                $isTabActive = request()->routeIs('documents.renstra_renja') || request()->is('dokumen/renstra-renja');
            } elseif (in_array($cSlug, ['sk-kelembagaan', 'sk_kelembagaan', 'dokumen-sk-kelembagaan'])) {
                $catRoute = route('documents.sk_kelembagaan');
                $isTabActive = request()->routeIs('documents.sk_kelembagaan') || request()->is('dokumen/sk-kelembagaan');
            } else {
                $catRoute = route('documents.index', ['kategori' => $cVal]);
                $isTabActive = request()->routeIs('documents.index') && ($reqCat === $cVal || $reqCat === $cSlug || $reqCat === $cat->name || $reqCat === $cat->slug);
            }
        @endphp
        <a href="{{ $catRoute }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ $isTabActive ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-600/20' : 'bg-white text-slate-700 border border-slate-200/90 hover:bg-slate-50 hover:text-emerald-700 font-medium' }}">
            <span>{{ $cat->name }}</span>
        </a>
    @endforeach
</div>
