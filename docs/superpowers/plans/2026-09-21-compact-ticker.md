# Compact Micro-Glass Ticker Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Refine the Announcement Ticker on `resources/views/layouts/app.blade.php` into a slim, elegant Compact Micro-Glass Ticker (~32px height).

**Architecture:** Update HTML/Blade structure and Tailwind classes for the ticker container in `resources/views/layouts/app.blade.php` to reduce vertical padding (`py-1`), resize the category badge to `text-[10px] px-2.5 py-0.5`, and streamline the capsule wrapper.

**Tech Stack:** Laravel Blade, Tailwind CSS.

## Global Constraints

- Modify only the ticker section inside `resources/views/layouts/app.blade.php`.
- Preserve announcement data looping and marquee animation.

---

### Task 1: Refine Ticker Layout in Blade View

**Files:**
- Modify: `resources/views/layouts/app.blade.php:382-433`

**Interfaces:**
- Consumes: `$announcements` collection from `HomeController`.
- Produces: Compact Micro-Glass Ticker element.

- [ ] **Step 1: Replace Ticker HTML block in `resources/views/layouts/app.blade.php`**

Replace lines 382-433 in `resources/views/layouts/app.blade.php` with:

```blade
        <!-- Announcement Ticker with Compact Micro-Glass Transition -->
        @if(isset($announcements) && $announcements->count() > 0)
        <div class="relative z-30 w-full transition-all duration-500 ease-out" :class="scrolled ? 'bg-slate-50/50 backdrop-blur-xl border-b border-slate-200/50 py-1' : 'bg-slate-50/70 border-b border-slate-200/60 py-1.5'">
            <div class="container mx-auto px-4">
                <div class="rounded-full h-8 px-3 py-0.5 transition-all duration-500 flex items-center gap-2.5" :class="scrolled ? 'bg-white/75 backdrop-blur-xl border border-white/80 shadow-xs' : 'bg-white border border-slate-200/70 shadow-2xs hover:border-slate-300'">
                    
                    <!-- Badge Kategori "BERITA TERKINI" Micro -->
                    <div class="bg-emerald-600/90 text-white px-2.5 py-0.5 rounded-md font-extrabold text-[10px] uppercase tracking-wider shrink-0 flex items-center gap-1.5 shadow-2xs">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-white"></span>
                        </span>
                        <span>Berita Terkini</span>
                    </div>

                    <!-- Pembatas Tipis Vertikal -->
                    <div class="h-3 w-px bg-slate-200/80 shrink-0"></div>

                    <!-- Ticker Content Container -->
                    <div class="ticker-wrap flex-1 text-[11.5px] leading-none relative overflow-hidden">
                        <div class="ticker-content flex items-center">
                            @foreach($announcements as $ann)
                                <div class="inline-flex items-center gap-2 mr-8 font-medium text-slate-700 hover:text-emerald-600 transition cursor-pointer group">
                                    <span class="font-semibold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $ann->title }}</span>
                                    @if(!empty($ann->content))
                                        <span class="text-slate-500 font-normal hidden sm:inline">- {{ Str::limit($ann->content, 65) }}</span>
                                    @endif
                                    <span class="bg-slate-100/90 text-slate-600 text-[10px] px-1.5 py-0.5 rounded font-medium border border-slate-200/50 shrink-0">
                                        {{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 inline-block shrink-0 mx-3"></span>
                                </div>
                            @endforeach
                            {{-- Duplicate for seamless loop --}}
                            @foreach($announcements as $ann)
                                <div class="inline-flex items-center gap-2 mr-8 font-medium text-slate-700 hover:text-emerald-600 transition cursor-pointer group">
                                    <span class="font-semibold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $ann->title }}</span>
                                    @if(!empty($ann->content))
                                        <span class="text-slate-500 font-normal hidden sm:inline">- {{ Str::limit($ann->content, 65) }}</span>
                                    @endif
                                    <span class="bg-slate-100/90 text-slate-600 text-[10px] px-1.5 py-0.5 rounded font-medium border border-slate-200/50 shrink-0">
                                        {{ \Carbon\Carbon::parse($ann->created_at)->format('d M Y') }}
                                    </span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 inline-block shrink-0 mx-3"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
```

- [ ] **Step 2: Verify template compilation**

Verify Blade compilation.

- [ ] **Step 3: Commit changes**

```bash
git add resources/views/layouts/app.blade.php docs/superpowers/specs/2026-09-21-compact-ticker-design.md docs/superpowers/plans/2026-09-21-compact-ticker.md
git commit -m "feat: streamline Announcement Ticker to Compact Micro-Glass layout"
```
