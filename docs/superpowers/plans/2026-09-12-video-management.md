# Video Documentation Management Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Separate admin gallery management into "Kelola Album" and "Kelola Video", add "Video Dokumentasi" sub-menu under the public Information navbar, create a dedicated public video page (`/video`) with YouTube lightbox modal, and build complete admin video CRUD at `/dashboard/videos`.

**Architecture:** Database table `videos`, Eloquent model `App\Models\Video` with automatic YouTube ID/embed/thumbnail URL accessors, public controller `PublicVideoController`, admin controller `App\Http\Controllers\Dashboard\VideoController`, public Blade view with Alpine.js video modal, and updated admin sidebar.

**Tech Stack:** PHP 8.x, Laravel 11, Blade Templates, Tailwind CSS, Alpine.js, SQLite/MySQL.

## Global Constraints

- Preserve Sidomukti deep dark theme styling and responsive design.
- Admin video CRUD must record operations via `ActivityLogger::log()`.
- Public navbar dropdown under "Informasi" must include both "Galeri Album" and "Video Dokumentasi".
- Admin sidebar menu must replace "Galeri Foto & Video" with "Kelola Album" and "Kelola Video".

---

### Task 1: Migration, Model & Seeder for Videos

**Files:**
- Create: `database/migrations/2026_09_12_200000_create_videos_table.php`
- Create: `app/Models/Video.php`
- Create: `database/seeders/VideoSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`

**Interfaces:**
- Produces: `App\Models\Video` (`title`, `category`, `youtube_url`, `duration`, `description`, `embed_url`, `thumbnail_url`, `youtube_id`)

- [ ] **Step 1: Create `videos` table migration**

Create file `database/migrations/2026_09_12_200000_create_videos_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('pemerintahan');
            $table->string('youtube_url');
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
```

- [ ] **Step 2: Create `Video` Eloquent Model**

Create file `app/Models/Video.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'youtube_url',
        'duration',
        'description',
    ];

    public function getYoutubeIdAttribute()
    {
        $url = $this->youtube_url;
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getEmbedUrlAttribute()
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube.com/embed/{$id}" : $this->youtube_url;
    }

    public function getThumbnailUrlAttribute()
    {
        $id = $this->youtube_id;
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop';
    }
}
```

- [ ] **Step 3: Run migration**

Run: `php artisan migrate`  
Expected: `2026_09_12_200000_create_videos_table` migrated successfully.

- [ ] **Step 4: Create `VideoSeeder.php`**

Create file `database/seeders/VideoSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Video Profil & Potensi Kelurahan Sidomukti 2026',
                'category' => 'pemerintahan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '05:30',
                'description' => 'Gambaran umum pelayanan publik, tata kelola pemerintahan, dan potensi wilayah Kelurahan Sidomukti.',
            ],
            [
                'title' => 'Dokumentasi Peresmian Drainase Lingkungan & Gotong Royong RW 03',
                'category' => 'pembangunan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '04:15',
                'description' => 'Kerja bakti gotong royong warga RW 03 bersama peresmian sistem drainase lingkungan.',
            ],
            [
                'title' => 'Semarak Lomba & Malam Puncak Peringatan HUT RI ke-81',
                'category' => 'hut-ri',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '08:45',
                'description' => 'Kemeriahan pesta rakyat, lomba jalan sehat, dan pentas seni warga Kelurahan Sidomukti.',
            ],
            [
                'title' => 'Pelatihan Digital Marketing & Sertifikasi Halal UMKM Sidomukti',
                'category' => 'pemberdayaan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '06:20',
                'description' => 'Kegiatan pelatihan pemberdayaan ekonomi masyarakat bagi para pelaku usaha mikro di Sidomukti.',
            ],
        ];

        foreach ($videos as $v) {
            Video::firstOrCreate(['title' => $v['title']], $v);
        }
    }
}
```

- [ ] **Step 5: Register and run seeder**

Add `$this->call(VideoSeeder::class);` to `database/seeders/DatabaseSeeder.php` and run:  
`php artisan db:seed --class=VideoSeeder`

- [ ] **Step 6: Commit Task 1**

```bash
git add database/migrations/ database/seeders/ app/Models/Video.php
git commit -m "feat: add videos migration, model and seeder"
```

---

### Task 2: Public Navbar Updates & Public Video Feature (`/video`)

**Files:**
- Create: `app/Http/Controllers/PublicVideoController.php`
- Create: `resources/views/videos/index.blade.php`
- Modify: `routes/web.php`
- Modify: `resources/views/layouts/app.blade.php`

**Interfaces:**
- Consumes: `App\Models\Video`
- Produces: Public route `GET /video` (`videos.index`)

- [ ] **Step 1: Create `PublicVideoController.php`**

Create `app/Http/Controllers/PublicVideoController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class PublicVideoController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');

        $query = Video::latest();
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $videos = $query->paginate(12);

        return view('videos.index', compact('videos', 'category'));
    }
}
```

- [ ] **Step 2: Create `resources/views/videos/index.blade.php`**

Create `resources/views/videos/index.blade.php` with:
- Deep dark header (*Video Dokumentasi Kelurahan*)
- Category filter tabs
- Grid of 16:9 video cards displaying `$video->thumbnail_url`, `$video->duration`, category badge, title, and published date
- Alpine.js Lightbox Video Player modal (`x-data="{ videoModal: false, activeEmbed: '' }"`)

- [ ] **Step 3: Update `routes/web.php`**

Add public video route:
```php
Route::get('/video', [App\Http\Controllers\PublicVideoController::class, 'index'])->name('videos.index');
```

- [ ] **Step 4: Update Public Header Navigation in `resources/views/layouts/app.blade.php`**

In `resources/views/layouts/app.blade.php`:
- In Desktop Informasi dropdown (around line 347):
  - Rename/ensure: `<a href="{{ route('galleries.index') }}" ...>Galeri Album Foto</a>`
  - Add: `<a href="{{ route('videos.index') }}" @click="active = '/video'" class="block px-3.5 py-2.5 text-[13px] font-semibold text-slate-700 hover:bg-emerald-50 hover:text-[#008c5f] rounded-xl transition-colors">Video Dokumentasi</a>`
- In Mobile Navigation dropdown (around line 465):
  - Add: `<a @click="mobileMenuOpen = false" href="{{ route('videos.index') }}" class="py-2 hover:text-[#008c5f]">Video Dokumentasi</a>`

- [ ] **Step 5: Test public video route**

Run: `php artisan route:list --name=videos`  
Expected: `videos.index` (`GET /video`) registered.

- [ ] **Step 6: Commit Task 2**

```bash
git add routes/web.php app/Http/Controllers/PublicVideoController.php resources/views/videos/ resources/views/layouts/app.blade.php
git commit -m "feat: add public video page and update navbar Informasi dropdown"
```

---

### Task 3: Admin Sidebar Updates & Dashboard Video CRUD

**Files:**
- Create: `app/Http/Controllers/Dashboard/VideoController.php`
- Create: `resources/views/dashboard/videos/index.blade.php`
- Create: `resources/views/dashboard/videos/create.blade.php`
- Create: `resources/views/dashboard/videos/edit.blade.php`
- Modify: `routes/web.php`
- Modify: `resources/views/components/admin-sidebar.blade.php`

**Interfaces:**
- Consumes: `App\Models\Video`, `App\Services\ActivityLogger`
- Produces: Dashboard CRUD routes `dashboard.videos.*`

- [ ] **Step 1: Create `App\Http\Controllers\Dashboard\VideoController.php`**

Create `app/Http/Controllers/Dashboard/VideoController.php`:

```php
<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(12);
        return view('dashboard.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('dashboard.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'youtube_url' => 'required|url',
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $video = Video::create($request->all());

        ActivityLogger::log('CREATE', 'Video', "Menambahkan video dokumentasi baru: {$video->title}", [
            'video_id' => $video->id
        ]);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        return view('dashboard.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'youtube_url' => 'required|url',
            'duration' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $video->update($request->all());

        ActivityLogger::log('UPDATE', 'Video', "Perubahan video dokumentasi: {$video->title}", [
            'video_id' => $video->id
        ]);

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $title = $video->title;
        $video->delete();

        ActivityLogger::log('DELETE', 'Video', "Menghapus video dokumentasi: {$title}");

        return redirect()->route('dashboard.videos.index')->with('success', 'Video dokumentasi berhasil dihapus.');
    }
}
```

- [ ] **Step 2: Update `resources/views/components/admin-sidebar.blade.php`**

In `resources/views/components/admin-sidebar.blade.php`:
- Change existing "Galeri Foto & Video" menu item (line 106 & line 290) to **"Kelola Album"** (`route('dashboard.galleries.index')`).
- Add new menu item **"Kelola Video"** (`route('dashboard.videos.index')`) with active check `request()->routeIs('dashboard.videos.*')`.

- [ ] **Step 3: Register dashboard video routes in `routes/web.php`**

Inside `middleware(['auth'])` group:
```php
Route::resource('/dashboard/videos', App\Http\Controllers\Dashboard\VideoController::class, ['as' => 'dashboard'])->except(['show']);
```

- [ ] **Step 4: Create Admin Video Blade Views**

- `resources/views/dashboard/videos/index.blade.php`: Table/grid of videos with YouTube thumbnail, title, category, duration, Edit button, Delete button, and "Buat Video Baru" header button.
- `resources/views/dashboard/videos/create.blade.php`: Form to input title, category select, YouTube URL, duration, description.
- `resources/views/dashboard/videos/edit.blade.php`: Form to edit video.

- [ ] **Step 5: Verify routes**

Run: `php artisan route:list --name=dashboard.videos`  
Expected: `dashboard.videos.index`, `dashboard.videos.create`, `dashboard.videos.store`, `dashboard.videos.edit`, `dashboard.videos.update`, `dashboard.videos.destroy` registered.

- [ ] **Step 6: Commit Task 3**

```bash
git add app/Http/Controllers/Dashboard/VideoController.php routes/web.php resources/views/components/admin-sidebar.blade.php resources/views/dashboard/videos/
git commit -m "feat: add admin dashboard video CRUD and update admin sidebar"
```
