# Design Spec: Seksi Mitra Kerja & Kemitraan Strategis Minimalis Elegan

## Overview
Memperbaiki dan memperbarui tampilan seksi "Mitra Kerja & Kemitraan Strategis" di beranda (`resources/views/home.blade.php`) agar lebih minimalis, bersih, dan profesional. Perubahan difokuskan pada kartu mitra (partner cards), eliminasi container logo abu-abu besar yang kaku, penerapan tata letak header-inline (logo dan badge kategori di baris atas), pewarnaan badge kategori kontekstual, serta aksen hover gradasi yang halus.

## User Intent & Requirements
- Tampilan kartu harus tampak lebih minimalis dan elegan.
- Menghilangkan bingkai abu-abu besar (`bg-slate-50 h-20`) yang memuat logo secara terisolasi.
- Mengatur logo (ukuran ringkas `w-12 h-12`) dan badge kategori agar berada sejajar (*inline*) di baris atas kartu.
- Menambahkan aksen bar gradasi hijau-teal di atas kartu saat di-hover.
- Pewarnaan badge kategori secara dinamis sesuai kategori instansi/mitra.
- Link "Kunjungi Situs Resmi" dengan animasi micro-slide pada panah.

## Visual & Structural Design Details

### 1. Section Level
- Container seksi: `<section id="kemitraan" class="py-16 sm:py-20 bg-slate-50/50 relative z-10 border-t border-slate-200/60">`
- Header badge: Pill badge `bg-emerald-50 text-emerald-800 border border-emerald-200/80` dengan ikon sinergi/kemitraan.
- Title & Subtitle: Judul `Mitra Kerja & Kemitraan Strategis` dengan garis aksen gradasi `w-16 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-4 rounded-full`.

### 2. Header-Inline Card Design
- **Card Wrapper**:
  - `group bg-white rounded-2xl p-6 border border-slate-200/70 shadow-sm hover:shadow-xl hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden reveal fade-up`
  - Top Accent Line: `absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300`

- **Inline Card Header**:
  - Flex container: `flex items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-100`
  - Logo Frame (Kiri): `w-12 h-12 rounded-xl bg-slate-50 p-2 border border-slate-100 flex items-center justify-center shrink-0 group-hover:bg-emerald-50/50 group-hover:border-emerald-200/60 transition duration-300`
  - Logo Image: `max-h-full max-w-full object-contain filter group-hover:scale-105 transition duration-300`
  - Category Badge (Kanan): Badge mikro dengan warna kontekstual berdasar nama kategori:
    - Instansi / Pemerintah: `bg-emerald-50 text-emerald-700 border-emerald-200/60`
    - BUMN / BUMD: `bg-sky-50 text-sky-700 border-sky-200/60`
    - Pendidikan: `bg-indigo-50 text-indigo-700 border-indigo-200/60`
    - Swasta / Default: `bg-amber-50 text-amber-700 border-amber-200/60`

- **Card Body**:
  - Title: `<h3 class="font-bold text-base text-slate-900 group-hover:text-emerald-700 transition leading-snug mb-2 line-clamp-2">`
  - Description: `<p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-4">`

- **Card Footer**:
  - Website link: `<a href="..." target="_blank" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1.5 group-hover:translate-x-1 transition-transform duration-200 pt-3 border-t border-slate-100 mt-auto">`

## Implementation Target
- File target: `resources/views/home.blade.php` (Seksi Kemitraan Strategis & Mitra Kerja).

## Verification Criteria
- Kartu mitra tampil sejajar dengan grid 4 kolom pada desktop dan 2/1 kolom pada tablet/mobile.
- Logo tampil rapi di sudut kiri atas kartu tanpa box abu-abu besar.
- Badge kategori tampil di sudut kanan atas dengan pewarnaan yang sesuai.
- Hover efek top accent line dan kartu terangkat halus berjalan tanpa glitch.
