# Mitra Kerja & Kemitraan Strategis Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Redesign section "Mitra Kerja & Kemitraan Strategis" on `resources/views/home.blade.php` into a minimalist, clean, and elegant header-inline card layout.

**Architecture:** Update HTML/Blade structure and Tailwind CSS classes in `resources/views/home.blade.php` to align logo and category badge inline, remove heavy grey logo containers, add subtle top hover accent gradients, dynamic category badge styling, and smooth hover micro-interactions.

**Tech Stack:** Laravel Blade, Tailwind CSS.

## Global Constraints

- Modify only `resources/views/home.blade.php` in section `#kemitraan`.
- Do not modify database schemas or backend controllers.
- Ensure all existing dynamic data variables (`$partner->logo`, `$partner->name`, `$partner->category`, `$partner->description`, `$partner->website`) remain fully wired up.

---

### Task 1: Update Section Header & Card Layout in Blade View

**Files:**
- Modify: `resources/views/home.blade.php:783-842`

**Interfaces:**
- Consumes: `$partnerships` collection from `HomeController`.
- Produces: Minimalist Header-Inline Partner Cards view.

- [ ] **Step 1: Inspect existing HTML section block**

Verify lines 783-842 in `resources/views/home.blade.php`.

- [ ] **Step 2: Apply Minimalist Header-Inline blade layout edit**

Replace the `#kemitraan` section in `resources/views/home.blade.php` with:

```blade
    <!-- Seksi Kemitraan Strategis & Mitra Kerja -->
    <section id="kemitraan" class="py-16 sm:py-20 bg-slate-50/50 relative z-10 border-t border-slate-200/60">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-50 text-emerald-800 text-[11px] font-extrabold tracking-widest uppercase rounded-full mb-4 border border-emerald-200/80 shadow-xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Sinergi & Kolaborasi
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Mitra Kerja & Kemitraan Strategis</h2>
                <p class="text-slate-500 mt-3 font-medium max-w-2xl mx-auto text-sm sm:text-base leading-relaxed">
                    Kelurahan Sidomukti menjalin kerjasama berkelanjutan dengan instansi pemerintah, BUMN/BUMD, lembaga pendidikan, dan sektor swasta demi kemajuan warga.
                </p>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-4 rounded-full"></div>
            </div>

            @if(isset($partnerships) && $partnerships->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($partnerships as $index => $partner)
                @php
                    $cat = strtolower($partner->category ?? '');
                    $badgeStyle = 'bg-amber-50 text-amber-700 border-amber-200/60';
                    if (str_contains($cat, 'pemerintah') || str_contains($cat, 'instansi')) {
                        $badgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
                    } elseif (str_contains($cat, 'bumn') || str_contains($cat, 'bumd')) {
                        $badgeStyle = 'bg-sky-50 text-sky-700 border-sky-200/60';
                    } elseif (str_contains($cat, 'pendidikan') || str_contains($cat, 'sekolah') || str_contains($cat, 'kampus')) {
                        $badgeStyle = 'bg-indigo-50 text-indigo-700 border-indigo-200/60';
                    }
                @endphp
                <div class="group bg-white rounded-2xl p-6 border border-slate-200/70 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden reveal fade-up" data-delay="{{ $index * 80 }}">
                    <!-- Top Accent Line on Hover -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div>
                        <!-- Header Baris Kartu: Logo (Kiri) & Category (Kanan) -->
                        <div class="flex items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100">
                            <!-- Logo Frame Ringkas -->
                            <div class="w-12 h-12 rounded-xl bg-slate-50 p-2 border border-slate-100 flex items-center justify-center shrink-0 group-hover:bg-emerald-50/50 group-hover:border-emerald-200/60 transition duration-300">
                                <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain filter group-hover:scale-105 transition duration-300">
                            </div>

                            <!-- Category Badge -->
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-lg border truncate max-w-[140px] text-right {{ $badgeStyle }}">
                                {{ $partner->category }}
                            </span>
                        </div>

                        <!-- Partner Name & Description -->
                        <h3 class="font-bold text-base text-slate-900 group-hover:text-emerald-700 transition leading-snug mb-2 line-clamp-2">
                            {{ $partner->name }}
                        </h3>
                        @if($partner->description)
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-4 font-normal">
                            {{ $partner->description }}
                        </p>
                        @endif
                    </div>

                    @if($partner->website)
                    <div class="pt-3 border-t border-slate-100 mt-auto">
                        <a href="{{ $partner->website }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1.5 group-hover:translate-x-1 transition-transform duration-200">
                            <span>Kunjungi Situs Resmi</span>
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-100 text-slate-400 text-xs">
                Belum ada data kemitraan aktif yang ditampilkan.
            </div>
            @endif
        </div>
    </section>
```

- [ ] **Step 3: Test and verify the page rendering**

Check local dev server or run a check command.

- [ ] **Step 4: Commit changes**

```bash
git add resources/views/home.blade.php docs/superpowers/specs/2026-09-21-mitra-kerja-design.md docs/superpowers/plans/2026-09-21-mitra-kerja-minimalis.md
git commit -m "feat: redesign Mitra Kerja section to minimalist elegant header-inline layout"
```
