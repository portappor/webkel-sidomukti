# Design Document: Sidebar Album Lainnya & Pencarian pada Detail Galeri

**Tanggal:** 14 September 2026  
**File Target:** 
- `app/Http/Controllers/PublicGalleryController.php`
- `resources/views/galleries/show.blade.php`

---

## 1. Ringkasan Fitur
Menambahkan kolom sidebar di sebelah kanan halaman detail album (`/galeri/{slug}`) yang memuat:
1. **Fitur Pencarian Album**: Input pencarian interaktif untuk mencari album lainnya secara langsung (*real-time filter* via Alpine.js) serta opsi pencarian ke seluruh galeri.
2. **Daftar Album Lainnya**: Kartu-kartu album kegiatan terbaru/terkait yang dilengkapi dengan thumbnail cover, judul, tanggal kegiatan, jumlah foto, badge kategori, dan efek hover yang responsif dan modern.

---

## 2. Struktur Layout & UI Design

### Grid Layout
Ubah container utama dari 1 kolom menjadi layout 2 kolom responsif:
- `lg:col-span-8` (Area Utama Kiri):
  - Judul section "Dokumentasi Foto dalam Album".
  - Grid Foto Album (3 kolom pada layar sedang/besar).
  - Lightbox modal preview foto tetap berfungsi normal.
- `lg:col-span-4` (Sidebar Kanan):
  - Widget Pencarian Album.
  - Widget "Album Lainnya".
  - Link "Lihat Semua Album →".

---

## 3. Komponen Sidebar Kanan

### A. Widget Pencarian (Search Input Box)
- Input text dengan ikon kaca pembesar (`search icon`) & tombol reset (`clear icon`).
- `x-model="searchQuery"` pada Alpine.js untuk menyaring daftar album secara instan di sisi klien.
- Tombol submit/enter yang mengarah ke pencarian galeri lengkap (`/galeri?search=...`).

### B. Widget Album Lainnya (Cards List)
- Daftar album lainnya (`$otherAlbums`).
- Kartu album ringkas (horizontal/vertical hybrid):
  - Cover image (16:9 ratio, object-cover).
  - Badge Kategori (misal: Pembangunan, Pemberdayaan, dll).
  - Judul Album (line-clamp-2).
  - Tanggal Kegiatan & Jumlah Foto.
- Filter real-time Alpine.js: elemen disembunyikan/ditampilkan berdasarkan kata kunci pencarian.
- Pesan "Album tidak ditemukan" jika hasil pencarian lokal tidak cocok.

---

## 4. Perubahan Controller (`PublicGalleryController.php`)
- `PublicGalleryController@show`:
  - Mengambil daftar album lainnya: `Album::withCount('photos')->where('id', '!=', $album->id)->latest()->take(10)->get()`.
  - Mengirimkan variabel `$otherAlbums` ke view `galleries.show`.

---

## 5. Rencana Pengujian (Verification Plan)
1. Buka halaman detail album (misal `/galeri/pelatihan-pemberdayaan-umkm-kripik-warga-sidomukti`).
2. Pastikan di sebelah kanan muncul sidebar "Album Lainnya" dan input pencarian.
3. Ketik kata kunci pada kotak pencarian dan verifikasi daftar album tersaring secara real-time.
4. Klik salah satu album di sidebar dan pastikan navigasi ke album tersebut berjalan lancar.
5. Uji responsivitas pada tampilan mobile (sidebar akan berada di bawah grid foto secara rapi).
