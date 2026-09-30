# Album Sidebar & Search Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Menambahkan sidebar "Album Lainnya" di sebelah kanan halaman detail galeri foto (`/galeri/{slug}`) lengkap dengan pencarian interaktif real-time dan tautan ke album-album terkait.

**Architecture:** Mengubah layout `resources/views/galleries/show.blade.php` menjadi grid 2-kolom (Utama 8-kolom, Sidebar 4-kolom). Controller `PublicGalleryController` akan menyediakan data `$otherAlbums`. Alpine.js digunakan untuk filter real-time pencarian album di sisi klien.

**Tech Stack:** Laravel Blade, Tailwind CSS, Alpine.js, PHP.

## Global Constraints
- Gunakan skema warna dan komponen konsisten dengan theme utama (`slate-100`, `emerald-600`, `#0b1329`).
- Pastikan Lightbox Modal preview foto tetap bekerja sempurna.

---

### Task 1: Controller Data Handoff (`PublicGalleryController.php`)

**Files:**
- Modify: `app/Http/Controllers/PublicGalleryController.php:24-35`

**Interfaces:**
- Consumes: Model `Album`
- Produces: `$otherAlbums` collection with `photos_count` sent to view `galleries.show`

- [ ] **Step 1: Update controller `show` method to load `otherAlbums` with `photos_count`**

```php
    public function show(Request $request, $slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->firstOrFail();
        
        $otherAlbums = Album::withCount('photos')
            ->where('id', '!=', $album->id)
            ->latest()
            ->get();

        return view('galleries.show', compact('album', 'otherAlbums'));
    }
```

- [ ] **Step 2: Verify controller syntax and routes**

Run: `php -l app/Http/Controllers/PublicGalleryController.php`
Expected: `No syntax errors detected`

---

### Task 2: Layout & Sidebar Implementation (`show.blade.php`)

**Files:**
- Modify: `resources/views/galleries/show.blade.php`

**Interfaces:**
- Consumes: `$album`, `$otherAlbums`
- Produces: 2-Column Responsive Layout with Photo Grid on Left and Interactive Search Sidebar on Right.

- [ ] **Step 1: Update `show.blade.php` layout and Alpine state**
  Add `searchQuery: ''` to `x-data` state on the root wrapper.
  Wrap content in `grid grid-cols-1 lg:grid-cols-12 gap-8`.
  Left side (`lg:col-span-8`) for photo documentation.
  Right side (`lg:col-span-4`) for search box & "Album Lainnya" card list with `x-show="searchQuery === '' || '{{ strtolower($other->title) }}'.includes(searchQuery.toLowerCase())"`.

- [ ] **Step 2: Verify in browser**
  Check the gallery detail page to ensure layout alignment and search filtering.
