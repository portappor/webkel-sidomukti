# Design Spec: Seksi Galeri Album & Video Kegiatan Redesign

## Overview
Memperbarui tampilan seksi "Galeri Album & Video Kegiatan" di beranda (`resources/views/home.blade.php`) agar tampak lebih modern, elegan, profesional, dan selaras dengan seksi Mitra Kerja. Redesain mencakup penyempurnaan header seksi, penyatuan gaya kartu album foto dan video kegiatan, tombol navigasi yang seimbang, top accent hover lines, serta glassmorphism badges.

## Requirements
- Menyelaraskan header seksi dengan seksi lainnya (badge netral, judul `text-slate-900 font-extrabold text-3xl md:text-4xl`, subtitle, pembatas tipis `border-b border-slate-200/80`).
- Menyediakan 2 tombol navigasi yang seimbang di kanan atas: `Semua Album Foto` (Soft Emerald) dan `Semua Video Dokumentasi` (Soft Rose).
- Kartu Album Foto (2 kartu pertama):
  - Top Accent Line saat hover: `bg-gradient-to-r from-emerald-500 to-teal-400`.
  - Badges: Category badge glassmorphism `bg-slate-900/80 text-emerald-400 border border-slate-700` (kiri atas) & Photo count badge `bg-emerald-600/90 text-white` (kanan bawah).
  - Typography: Judul `text-slate-900 font-bold text-base group-hover:text-emerald-700 transition`, info tanggal dengan icon kalender mikro.
  - Link: "Lihat Album" dengan animasi panah meluncur.
- Kartu Video Kegiatan (2 kartu berikutnya):
  - Top Accent Line saat hover: `bg-gradient-to-r from-rose-500 to-amber-500`.
  - Play Button: Glowing circle `w-12 h-12 bg-rose-600 text-white shadow-lg shadow-rose-600/40 border-2 border-white/90 group-hover:scale-110 group-hover:bg-rose-500 transition`.
  - Badges: Category badge `bg-rose-600/90 text-white` & Duration badge `bg-slate-900/90 text-slate-200`.
  - Typography: Judul `text-slate-900 font-bold text-base group-hover:text-rose-600 transition` (menggantikan merah mencolok), deskripsi singkat.
  - Link: "Putar Video" dengan icon play dan hover animation.

## File Target
- `resources/views/home.blade.php` (Seksi Galeri Album & Video Kegiatan, sekitar baris 520-775).

## Verification Criteria
- Grid 4 kolom berfungsi dengan baik pada desktop (2 Album Foto + 2 Video Kegiatan).
- Header seksi tampil rapi dan simetris.
- Hover effect top accent bar dan animasi tombol play/panah berjalan dengan lancar.
