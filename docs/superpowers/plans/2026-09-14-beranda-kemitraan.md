# Implementation Plan - Menampilkan Kemitraan di Beranda Utama

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Menampilkan seksi "Mitra Kerja & Kemitraan Strategis" di halaman utama Beranda (`/`) berbasis data dinamis dari tabel `partnerships`.

**Architecture:** Memperbarui `HomeController.php` untuk mengambil data `$partnerships` aktif dan menyisipkan seksi UI baru di `resources/views/home.blade.php`.

**Tech Stack:** Laravel Blade, Tailwind CSS, PHP.

## Global Constraints
- Tampilan responsif dan menyatu dengan estetika beranda (badge emerald, font Inter/Roboto, card hover transition).

---

### Task 1: Update Controller (`HomeController.php`)

**Files:**
- Modify: `app/Http/Controllers/HomeController.php`

- [ ] **Step 1: Import model `Partnership` and fetch `$partnerships` in `index()`**

```php
use App\Models\Partnership;

$partnerships = Partnership::where('is_active', true)->orderBy('sort_order', 'asc')->get();

return view('home', compact('services', 'posts', 'announcements', 'galleries', 'videos', 'settings', 'maklumat', 'partnerships'));
```

---

### Task 2: Homepage View Integration (`home.blade.php`)

**Files:**
- Modify: `resources/views/home.blade.php`

- [ ] **Step 1: Add "Kemitraan Strategis & Mitra Kerja" section to `home.blade.php`**
- [ ] **Step 2: Verify in browser**
