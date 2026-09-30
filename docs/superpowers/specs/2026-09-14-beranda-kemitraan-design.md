# Design Document: Penampilan Kemitraan Strategis di Beranda Utama

**Tanggal:** 14 September 2026  
**Target Files:**
- `app/Http/Controllers/HomeController.php`
- `resources/views/home.blade.php`

---

## 1. Ringkasan Fitur
Menampilkan seksi **Mitra Kerja & Kemitraan Strategis** di halaman depan (Beranda Utama `/`) yang mengambil data dinamis mitra aktif (`is_active = true`) dari database yang dikelola melalui Admin Dashboard.

---

## 2. Desain Antarmuka Beranda (`home.blade.php`)

### Lokasi Seksi
Di letakkan di atas footer/modal galeri, memberikan penutup yang anggun dan memperkuat kepercayaan masyarakat (*social proof* & legitimasi kerjasama instansi).

### Struktur Komponen UI:
- **Header Seksi**:
  - Badge: "SINERGI & KOLABORASI"
  - Judul: "Kemitraan Strategis & Mitra Kerja"
  - Subjudul: Deskripsi sinergi bersama instansi pemerintah, BUMN, kampus, dan sektor swasta.
- **Grid Kartu Mitra**:
  - Grid responsif (`grid-cols-2 md:grid-cols-4 gap-6`).
  - Kartu Mitra dengan latar belakang putih, border halus, bayangan `shadow-sm`, dan efek `hover:-translate-y-1`.
  - Display Logo Mitra (fit contain).
  - Badge Kategori (Pemerintah, BUMN/BUMD, Pendidikan, Swasta).
  - Nama Mitra & Deskripsi Kerjasama.
  - Tautan ke situs web resmi mitra jika tersedia.

---

## 3. Integrasi Backend (`HomeController.php`)
- Mengambil data `Partnership`:
  `$partnerships = Partnership::where('is_active', true)->orderBy('sort_order', 'asc')->get();`
- Mengirimkan variabel `$partnerships` ke view `home`.

---

## 4. Verification Plan
1. Verifikasi data mitra muncul di halaman beranda `http://127.0.0.1:8002/`.
2. Uji filter status aktif pada dashboard admin (nonaktifkan mitra dan pastikan hilang di beranda).
3. Verifikasi tautan situs web mitra terbuka di tab baru (`target="_blank"`).
