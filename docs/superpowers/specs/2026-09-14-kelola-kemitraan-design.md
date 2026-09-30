# Design Document: Fitur Kelola Kemitraan (Partnership Management)

**Tanggal:** 14 September 2026  
**Module:** Dashboard Admin & Portal Publik  
**Target Files:**
- `database/migrations/2026_09_14_200000_create_partnerships_table.php`
- `app/Models/Partnership.php`
- `app/Http/Controllers/Dashboard/PartnershipController.php`
- `resources/views/dashboard/partnerships/index.blade.php`
- `resources/views/components/admin-sidebar.blade.php`
- `routes/web.php`
- `database/seeders/PartnershipSeeder.php`

---

## 1. Ringkasan Fitur
Menambahkan modul **Kelola Kemitraan** pada Admin Panel Kelurahan Sidomukti di bawah kelompok menu **PELAYANAN & KONTEN** (sesuai posisi pada gambar sidebar). Modul ini digunakan untuk mengelola data lembaga, instansi pemerintah, BUMN/BUMD, perguruan tinggi, maupun perusahaan swasta yang menjadi mitra strategis Kelurahan Sidomukti.

---

## 2. Struktur Data (`partnerships` Table)

| Field | Tipe Data | Keterangan |
|---|---|---|
| `id` | BigIncrements | Primary Key |
| `name` | String | Nama Instansi / Perusahaan Mitra |
| `category` | String | Kategori (Government, BUMN/BUMD, Education, Private/UMKM, NGO/Komunitas) |
| `logo` | String (Nullable) | URL / Path Logo Mitra |
| `description` | Text (Nullable) | Deskripsi Ringkas Bentuk Kerjasama |
| `website` | String (Nullable) | URL Situs Resmi Mitra |
| `contact_person` | String (Nullable) | Penanggung Jawab / Kontak Person |
| `phone` | String (Nullable) | Nomor Telepon / Whatsapp Kontak |
| `is_active` | Boolean | Status Aktif/Nonaktif (Default: `true`) |
| `sort_order` | Integer | Urutan Tampilan (Default: `0`) |
| `created_at`, `updated_at` | Timestamps | Log Waktu |

---

## 3. Komponen Dashboard Admin (`/dashboard/partnerships`)

### A. Sidebar Navigation (`components/admin-sidebar.blade.php`)
- Ditambahkan menu **"Kelola Kemitraan"** pada kelompok **PELAYANAN & KONTEN** tepat di bawah *Kelola Lembaga Kemasyarakatan* dan di atas *Kelola Maklumat Pelayanan*.
- Menggunakan state active `request()->routeIs('dashboard.partnerships.*')`.

### B. Halaman Management (`dashboard.partnerships.index`)
- **Header Stat Cards**: 
  - Total Mitra Kerja
  - Mitra Sektor Pemerintah & BUMN
  - Mitra Sektor Swasta & Pendidikan
- **Tombol Action**: "Tambah Mitra Baru" (Membuka Modal Form dengan Alpine.js).
- **Tabel / Card Grid Data**:
  - Kolom Logo, Nama & Kategori Mitra.
  - Deskripsi Kerjasama & Link Website.
  - Toggle / Badge Status Aktif.
  - Aksi Edit & Hapus (Lengkap dengan Modal & Konfirmasi).
- **Activity Logger Integration**: Mencatat setiap aksi `CREATE`, `UPDATE`, dan `DELETE` ke log aktivitas admin.

---

## 4. Rencana Pengujian (Verification Plan)
1. Jalankan migrasi dan seeder untuk tabel `partnerships`.
2. Buka Admin Panel dan pastikan menu **Kelola Kemitraan** muncul di sidebar sesuai posisi gambar.
3. Uji fungsi Tambah Mitra Baru (Upload logo / URL logo, Nama, Kategori, Website).
4. Uji fungsi Edit Mitra dan Hapus Mitra.
5. Verifikasi bahwa log aktivitas mencatat aksi penambahan/perubahan mitra.
