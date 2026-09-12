# Album Gallery Feature Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Overhaul the single-image gallery into a fully functional Album-based documentation system with thumbnail covers, category filters, multi-photo album support, dedicated album detail pages (`/galeri/{slug}`), Alpine.js lightbox viewer, and comprehensive admin dashboard CRUD.

**Architecture:** Database schema using 2 relational tables (`albums` and `album_photos`). Laravel Eloquent models with `hasMany`/`belongsTo` relationships. Front-end public views built with Blade, Tailwind CSS, and Alpine.js for full-screen image lightbox modal navigation. Admin dashboard views updated with multi-file uploads and individual image removal capabilities.

**Tech Stack:** PHP 8.x, Laravel 11, Blade Templates, Tailwind CSS, Alpine.js, SQLite/MySQL.

## Global Constraints

- Preserve responsive design and deep dark header styling consistent with `webkel-sidomukti` theme.
- All file deletion operations must call `Storage::disk('public')->delete()`.
- Record admin actions via `ActivityLogger::log()`.
- Use slug routing for public album detail URLs (`/galeri/{slug}`).

---

### Task 1: Database Migrations & Eloquent Models

**Files:**
- Create: `database/migrations/2026_09_12_100000_create_albums_table.php`
- Create: `database/migrations/2026_09_12_100001_create_album_photos_table.php`
- Create: `app/Models/Album.php`
- Create: `app/Models/AlbumPhoto.php`

**Interfaces:**
- Produces: `App\Models\Album` (`title`, `slug`, `category`, `description`, `cover_image`, `event_date`, `photos()`)
- Produces: `App\Models\AlbumPhoto` (`album_id`, `image_path`, `caption`, `album()`)

- [ ] **Step 1: Create `albums` table migration**

Create file `database/migrations/2026_09_12_100000_create_albums_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('pemerintahan');
            $table->text('description')->nullable();
            $table->string('cover_image');
            $table->date('event_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
```

- [ ] **Step 2: Create `album_photos` table migration**

Create file `database/migrations/2026_09_12_100001_create_album_photos_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('album_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('albums')->onDelete('cascade');
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_photos');
    }
};
```

- [ ] **Step 3: Create `Album` model**

Create file `app/Models/Album.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'cover_image',
        'event_date',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class);
    }

    public getCoverUrlAttribute()
    {
        if (Str::startsWith($this->cover_image, ['http://', 'https://'])) {
            return $this->cover_image;
        }
        return Storage::url($this->cover_image);
    }
}
```

- [ ] **Step 4: Create `AlbumPhoto` model**

Create file `app/Models/AlbumPhoto.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'image_path',
        'caption',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public getImageUrlAttribute()
    {
        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }
        return Storage::url($this->image_path);
    }
}
```

- [ ] **Step 5: Run migrations and verify schema**

Run: `php artisan migrate`  
Expected: `2026_09_12_100000_create_albums_table` and `2026_09_12_100001_create_album_photos_table` migrated successfully.

- [ ] **Step 6: Commit**

```bash
git add database/migrations/ app/Models/Album.php app/Models/AlbumPhoto.php
git commit -m "feat: add albums and album_photos migrations and Eloquent models"
```

---

### Task 2: Public Controller, Routes, and Blade Views (Index & Album Detail with Lightbox)

**Files:**
- Modify: `routes/web.php`
- Modify: `app/Http/Controllers/GalleryController.php`
- Modify: `resources/views/galleries/index.blade.php`
- Create: `resources/views/galleries/show.blade.php`

**Interfaces:**
- Consumes: `App\Models\Album`, `App\Models\AlbumPhoto`
- Produces: Public routes `GET /galeri` (`galleries.index`) and `GET /galeri/{slug}` (`galleries.show`)

- [ ] **Step 1: Update `routes/web.php`**

Add public routes for gallery index and show:

```php
Route::get('/galeri', [App\Http\Controllers\GalleryController::class, 'publicIndex'])->name('galleries.index');
Route::get('/galeri/{slug}', [App\Http\Controllers\GalleryController::class, 'publicShow'])->name('galleries.show');
```

- [ ] **Step 2: Update `GalleryController.php` for public endpoints**

Update `app/Http/Controllers/GalleryController.php` to handle `publicIndex` and `publicShow`:

```php
    public function publicIndex(Request $request)
    {
        $category = $request->query('category', 'all');
        
        $query = Album::withCount('photos')->latest();
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $albums = $query->paginate(12);

        return view('galleries.index', compact('albums', 'category'));
    }

    public function publicShow($slug)
    {
        $album = Album::with('photos')->where('slug', $slug)->firstOrFail();
        
        // Fetch related albums
        $relatedAlbums = Album::where('id', '!=', $album->id)
            ->where('category', $album->category)
            ->latest()
            ->take(4)
            ->get();

        return view('galleries.show', compact('album', 'relatedAlbums'));
    }
```

- [ ] **Step 3: Update `resources/views/galleries/index.blade.php`**

Replace dummy inline data with database `$albums` collection, linking each album card to `route('galleries.show', $album->slug)`.

Key card details to display:
- `cover_url`
- `$album->category` badge
- `$album->title`
- `$album->event_date ? $album->event_date->translatedFormat('d F Y') : $album->created_at->translatedFormat('d F Y')`
- `$album->photos_count . ' Foto'`

- [ ] **Step 4: Create `resources/views/galleries/show.blade.php`**

Create `resources/views/galleries/show.blade.php` containing:
- Breadcrumb (`Beranda > Galeri > $album->title`)
- Album title, event date, category badge, and description paragraph
- Photo grid showing thumbnail of each `$photo->image_url`
- Alpine.js Lightbox component:
  ```html
  <div x-data="{ open: false, activeIndex: 0, photos: {{ json_encode($album->photos->map(fn($p) => ['url' => $p->image_url, 'caption' => $p->caption])) }} }">
     ...
  </div>
  ```
  Lightbox allows `prev()`, `next()`, `close()`, keyboard arrow handling (`@keydown.right.window`, `@keydown.left.window`, `@keydown.escape.window`).

- [ ] **Step 5: Test public gallery routes**

Run: `php artisan route:list --name=galleries`  
Expected: `galleries.index` (`GET /galeri`) and `galleries.show` (`GET /galeri/{slug}`) registered.

- [ ] **Step 6: Commit**

```bash
git add routes/web.php app/Http/Controllers/GalleryController.php resources/views/galleries/
git commit -m "feat: add public album gallery index and detail views with lightbox"
```

---

### Task 3: Dashboard Admin Album Management & Controllers

**Files:**
- Modify: `app/Http/Controllers/GalleryController.php` (or Dashboard GalleryController)
- Modify: `resources/views/dashboard/galleries/index.blade.php`
- Modify: `resources/views/dashboard/galleries/create.blade.php`
- Create: `resources/views/dashboard/galleries/edit.blade.php`

**Interfaces:**
- Consumes: `App\Models\Album`, `App\Models\AlbumPhoto`, `App\Services\ActivityLogger`
- Produces: Dashboard CRUD routes (`dashboard.galleries.*` and `dashboard.galleries.photos.destroy`)

- [ ] **Step 1: Add CRUD logic to Dashboard `GalleryController`**

In `GalleryController.php`:
- `index()`: Paginated albums with `photos_count`.
- `create()`: Render `dashboard.galleries.create`.
- `store(Request $request)`:
  - Validate `title`, `category`, `event_date`, `description`, `cover_image` (file/url), `photos` (array of file/url).
  - Generate `slug` using `Str::slug($request->title) . '-' . time()`.
  - Store cover image to `storage/app/public/albums/covers/`.
  - Store uploaded photos to `storage/app/public/albums/photos/`.
  - Create `AlbumPhoto` records.
  - Log activity via `ActivityLogger::log('CREATE', 'Galeri', "Membuat album foto baru: {$album->title}")`.
- `edit(Album $gallery)` (note route parameter name): Render `dashboard.galleries.edit` with `$album`.
- `update(Request $request, Album $gallery)`: Update attributes, handle new cover image if provided, process newly added photos.
- `destroy(Album $gallery)`: Delete cover image, delete all photo files from storage, delete album record, log activity.
- `destroyPhoto(AlbumPhoto $photo)`: Delete single photo file, delete record, return back with success flash.

- [ ] **Step 2: Update `resources/views/dashboard/galleries/index.blade.php`**

Render table/grid of albums with thumbnail cover, title, category, photo count, Edit link, and Delete button.

- [ ] **Step 3: Update `resources/views/dashboard/galleries/create.blade.php`**

Form inputs:
- `title` (text, required)
- `category` (select: `pemerintahan`, `pembangunan`, `pemberdayaan`, `keagamaan`, `hut-ri`)
- `event_date` (date)
- `description` (textarea)
- `cover_image` (file/url options)
- `photos[]` (multi-file input `<input type="file" name="photos[]" multiple accept="image/*">`)
- `photo_urls` (textarea for pasting multiple URLs line by line)

- [ ] **Step 4: Create `resources/views/dashboard/galleries/edit.blade.php`**

Form to edit album info, plus a grid of existing photos in the album with individual "Hapus Foto" buttons pointing to `route('dashboard.galleries.photos.destroy', $photo->id)`.

- [ ] **Step 5: Register routes in `routes/web.php`**

In `routes/web.php` inside `middleware(['auth'])` dashboard group:
```php
Route::resource('galleries', App\Http\Controllers\GalleryController::class);
Route::delete('galleries/photos/{photo}', [App\Http\Controllers\GalleryController::class, 'destroyPhoto'])->name('galleries.photos.destroy');
```

- [ ] **Step 6: Commit**

```bash
git add routes/web.php app/Http/Controllers/GalleryController.php resources/views/dashboard/galleries/
git commit -m "feat: add admin dashboard album CRUD and photo management"
```

---

### Task 4: Database Seeder & End-to-End Verification

**Files:**
- Create: `database/seeders/AlbumSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`

- [ ] **Step 1: Create `AlbumSeeder.php`**

Create `database/seeders/AlbumSeeder.php` with sample albums and interior photos so the site has immediate rich content:
- Album 1: *Pelatihan & Pemberdayaan UMKM Kripik Warga Sidomukti* (Pemberdayaan, 5 photos)
- Album 2: *Pengajian Rutin & Santunan Anak Yatim Kelurahan Sidomukti* (Keagamaan, 4 photos)
- Album 3: *Gotong Royong Perbaikan Jalan Gang & Pemasangan Lampu* (Pembangunan, 6 photos)
- Album 4: *Semarak Lomba & Malam Puncak Peringatan HUT RI* (HUT RI, 5 photos)

- [ ] **Step 2: Run Seeder**

Run: `php artisan db:seed --class=AlbumSeeder`  
Expected: Albums and photos created in database.

- [ ] **Step 3: Verify Public Pages & Lightbox**

Test URL `/galeri` and click an album to check detail page `/galeri/{slug}`. Check lightbox navigation.

- [ ] **Step 4: Commit**

```bash
git add database/seeders/
git commit -m "seed: add sample album gallery data"
```
