# Design Spec: Compact Micro-Glass Announcement Ticker

## Overview
Memperbaiki tampilan seksi Announcement Ticker di `resources/views/layouts/app.blade.php` yang sebelumnya terlalu tinggi dan kaku. Seksi ini dirampingkan menjadi **Compact Micro-Glass Ticker** setinggi ~32px dengan padding mikro, badge "Berita Terkini" berukuran compact `text-[10px]`, kapsul kaca transparan ramping `h-8 py-1 px-3`, serta transisi liquid glass yang mulus.

## Requirements
- Ketinggian outer bar: `py-1 sm:py-1.5` (menggantikan `py-2`).
- Kapsul inner ticker: `h-8 px-3 py-0.5 rounded-full flex items-center gap-2.5 transition-all duration-500`.
- Badge "Berita Terkini": `bg-emerald-600 text-white px-2.5 py-0.5 rounded-md font-extrabold text-[10px] uppercase tracking-wider shrink-0 flex items-center gap-1.5 shadow-2xs`.
- Teks berita & tanggal: `text-[11.5px] font-medium text-slate-700`, tanggal dalam badge soft `text-[10px] text-slate-500 bg-slate-100/90 px-1.5 py-0.2 rounded border border-slate-200/50`.

## Target File
- `resources/views/layouts/app.blade.php` (bagian Ticker Announcement, sekitar baris 380-430).

## Verification Criteria
- `php artisan view:cache` berhasil tanpa error.
- Ticker bar tampil jauh lebih ringkas, tipis, dan tidak kaku di layar.
