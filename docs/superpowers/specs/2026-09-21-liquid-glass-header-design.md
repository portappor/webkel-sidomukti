# Design Spec: Header Navigation & Ticker Liquid Glass Effect

## Overview
Memperbarui seksi `<header>` di `resources/views/layouts/app.blade.php` agar secara otomatis bertransformasi menjadi **Liquid Glass** saat halaman di-scroll ke bawah. Efek ini memadukan *backdrop-blur-2xl*, *backdrop-saturate-150*, latar semi-transparan `bg-white/70`, bayangan ambient halus `shadow-xl shadow-slate-900/5`, serta rim lighting gradasi kilau kaca di garis atas.

## User Intent & Requirements
- Saat di-scroll, area navbar utama dan ticker berita otomatis mengadopsi tampilan Liquid Glass.
- Transisi berjalan secara responsif dan sangat mulus (*smooth transition 500ms*).
- Menjaga fungsionalitas menu dropdown desktop dan menu mobile Alpine.js.

## Structural Details

### 1. Header Container
- State Alpine.js: `x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 15)"`
- Container: `<header class="sticky top-0 z-50 flex flex-col w-full transition-all duration-500">`

### 2. Main Navigation Bar
- Top Ambient Rim Glow Line: `<div class="h-[1px] w-full bg-gradient-to-r from-transparent via-emerald-500/40 to-transparent transition-opacity duration-500" :class="scrolled ? 'opacity-100' : 'opacity-0'"></div>`
- Navigation Bar Wrapper:
  - Class dinamis: `:class="scrolled ? 'bg-white/75 backdrop-blur-2xl backdrop-saturate-150 border-b border-slate-200/60 shadow-xl shadow-slate-900/5 py-2' : 'bg-white backdrop-blur-md border-b border-gray-100 py-3'"`
  - Transisi: `transition-all duration-500 ease-out`

### 3. Ticker Bar & Capsule
- Ticker Wrapper: `:class="scrolled ? 'bg-slate-50/60 backdrop-blur-xl border-b border-slate-200/50 py-1.5' : 'bg-slate-50/80 border-b border-slate-200/60 py-2'"`
- Inner Capsule: `:class="scrolled ? 'bg-white/70 backdrop-blur-xl border-white/80 shadow-md shadow-emerald-950/5' : 'bg-white border-slate-200/80 shadow-2xs'"`

## Target File
- `resources/views/layouts/app.blade.php` (lines 115-410).

## Verification Criteria
- `php artisan view:cache` mengeksekusi kompilasi Blade tanpa error.
- Saat scroll di atas 15px, navbar dan ticker berubah menjadi kaca transparan liquid glass.
