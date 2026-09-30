# Implementation Plan: Navigation Menu Image Upload & Access Denied Validation

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add photo/image upload capability to Navigation Menu management (Create & Edit modals) with strict client-side & server-side validation that rejects documents/PDFs with an "Akses Ditolak" notification.

**Architecture:** Database migration adds an `image` column to `navigation_menus`. `NavigationMenuController` handles file validation, storage in `storage/app/public/navigation`, and cleanup. `resources/views/dashboard/navigation/index.blade.php` includes file inputs with client-side image validation (`validateImageUpload`) and image thumbnails.

**Tech Stack:** Laravel, Blade, Tailwind CSS, JavaScript (Vanilla), PHP, SQLite/MySQL.

## Global Constraints

- Backend validation must reject non-images with error: `🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya berkas Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.`
- Client-side validation must reject non-images using `validateImageUpload(this)` on file change.
- Allowed file extensions: `jpg, jpeg, png, webp, gif, svg`. Max size: `5MB`.
- File upload forms must use `enctype="multipart/form-data"`.

---

### Task 1: Create Database Migration & Update Model

**Files:**
- Create: `database/migrations/2026_09_22_000003_add_image_to_navigation_menus_table.php`
- Modify: `app/Models/NavigationMenu.php`

**Interfaces:**
- Consumes: None
- Produces: `NavigationMenu::$fillable` containing `'image'`

- [ ] **Step 1: Create Migration File**

Create file `database/migrations/2026_09_22_000003_add_image_to_navigation_menus_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('navigation_menus', function (Blueprint $table) {
            if (!Schema::hasColumn('navigation_menus', 'image')) {
                $table->string('image')->nullable()->after('icon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('navigation_menus', function (Blueprint $table) {
            if (Schema::hasColumn('navigation_menus', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
```

- [ ] **Step 2: Run Migration**

Execute command: `php artisan migrate`

- [ ] **Step 3: Update `NavigationMenu` Model**

Modify `app/Models/NavigationMenu.php`: add `'image'` to `$fillable` array.

```php
    protected $fillable = [
        'title',
        'url',
        'parent_id',
        'order',
        'target',
        'is_active',
        'show_on_homepage',
        'description',
        'content',
        'icon',
        'image',
    ];
```

---

### Task 2: Update `NavigationMenuController` Store and Update Logic

**Files:**
- Modify: `app/Http/Controllers/Dashboard/NavigationMenuController.php`

**Interfaces:**
- Consumes: `NavigationMenu` model with `image` fillable
- Produces: File upload validation and storage logic in `store()`, `update()`, and `destroy()` methods.

- [ ] **Step 1: Modify `NavigationMenuController.php`**

Add image upload handling, file storage, file deletion, and validation with error messages for `store()`, `update()`, and `destroy()`:

In `store()`:
```php
$request->validate([
    'title' => 'required|string|max:255',
    'url' => 'nullable|string|max:255',
    'parent_id' => 'nullable|exists:navigation_menus,id',
    'target' => 'nullable|in:_self,_blank',
    'is_active' => 'boolean',
    'show_on_homepage' => 'boolean',
    'description' => 'nullable|string|max:500',
    'content' => 'nullable|string',
    'icon' => 'nullable|string|max:100',
    'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
], [
    'image.file' => '🚫 AKSES DITOLAK! Berkas yang diunggah harus berupa FOTO / GAMBAR.',
    'image.mimes' => '🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
    'image.max' => '🚫 AKSES DITOLAK! Ukuran berkas gambar maksimal adalah 5 MB.',
]);

$imagePath = null;
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('navigation', 'public');
}

$menu = NavigationMenu::create([
    'title' => $request->title,
    'url' => $url,
    'parent_id' => $parentId,
    'order' => $order,
    'target' => $request->target ?? '_self',
    'is_active' => $request->has('is_active') ? true : false,
    'show_on_homepage' => $request->has('show_on_homepage') ? true : false,
    'description' => $request->description,
    'content' => $request->content,
    'icon' => $request->icon,
    'image' => $imagePath,
]);
```

In `update()`:
```php
$request->validate([
    'title' => 'required|string|max:255',
    'url' => 'nullable|string|max:255',
    'parent_id' => 'nullable|exists:navigation_menus,id',
    'target' => 'nullable|in:_self,_blank',
    'order' => 'nullable|integer',
    'is_active' => 'boolean',
    'show_on_homepage' => 'boolean',
    'description' => 'nullable|string|max:500',
    'content' => 'nullable|string',
    'icon' => 'nullable|string|max:100',
    'image' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
], [
    'image.file' => '🚫 AKSES DITOLAK! Berkas yang diunggah harus berupa FOTO / GAMBAR.',
    'image.mimes' => '🚫 AKSES DITOLAK! Format berkas tidak diperbolehkan. Hanya Foto/Gambar (JPG, PNG, JPEG, WEBP, GIF, SVG) yang diperbolehkan.',
    'image.max' => '🚫 AKSES DITOLAK! Ukuran berkas gambar maksimal adalah 5 MB.',
]);

$imagePath = $menu->image;
if ($request->hasFile('image')) {
    if ($menu->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->image)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
    }
    $imagePath = $request->file('image')->store('navigation', 'public');
} elseif ($request->has('remove_image') && $request->remove_image == '1') {
    if ($menu->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->image)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
    }
    $imagePath = null;
}

$menu->update([
    'title' => $request->title,
    'url' => $url,
    'parent_id' => $parentId,
    'order' => $request->filled('order') ? (int) $request->order : $menu->order,
    'target' => $request->target ?? '_self',
    'is_active' => $request->has('is_active') ? true : false,
    'show_on_homepage' => $request->has('show_on_homepage') ? true : false,
    'description' => $request->description,
    'content' => $request->content,
    'icon' => $request->icon,
    'image' => $imagePath,
]);
```

In `destroy()`:
```php
if ($menu->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->image)) {
    \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
}
```

---

### Task 3: Update Modal UI Forms & JavaScript in Blade View

**Files:**
- Modify: `resources/views/dashboard/navigation/index.blade.php`

**Interfaces:**
- Consumes: Navigation Menu Create & Edit Modals
- Produces: Image upload fields with client-side validation (`validateImageUpload`), thumbnail previews, and table display.

- [ ] **Step 1: Add `enctype="multipart/form-data"` to Forms**
Add `enctype="multipart/form-data"` to `#createNavigationForm` and `#editNavigationForm`.

- [ ] **Step 2: Add File Upload Section in Create Modal**
Add Image Upload block to `createNavigationModal`:
```html
<div>
    <label for="create_image" class="block text-xs font-bold text-slate-700 mb-1.5">Foto / Gambar Halaman (Opsional):</label>
    <div class="flex items-center gap-3">
        <input type="file" name="image" id="create_image" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" onchange="validateImageUpload(this, 'create_image_label', 'Pilih Berkas Foto', 5)" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer">
    </div>
    <span id="create_image_label" class="text-[11px] text-slate-500 mt-1 block">Format: JPG, PNG, WEBP, GIF, SVG (Maks. 5MB). Berkas dokumen PDF/lainnya akan <b>DITOLAK</b>.</span>
</div>
```

- [ ] **Step 3: Add File Upload Section in Edit Modal**
Add Image Upload block & existing preview thumbnail to `editNavigationModal`:
```html
<div>
    <label for="edit_image" class="block text-xs font-bold text-slate-700 mb-1.5">Foto / Gambar Halaman (Opsional):</label>
    <div id="edit_image_preview_container" class="mb-2 hidden">
        <div class="relative inline-block border border-slate-200 rounded-xl p-1 bg-slate-50">
            <img id="edit_image_preview" src="" alt="Preview" class="h-20 w-32 object-cover rounded-lg">
            <label class="mt-1 flex items-center gap-1.5 text-xs text-rose-600 font-semibold cursor-pointer">
                <input type="checkbox" name="remove_image" id="edit_remove_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                Hapus Foto Ini
            </label>
        </div>
    </div>
    <input type="file" name="image" id="edit_image" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml" onchange="validateImageUpload(this, 'edit_image_label', 'Pilih Berkas Foto', 5)" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer">
    <span id="edit_image_label" class="text-[11px] text-slate-500 mt-1 block">Format: JPG, PNG, WEBP, GIF, SVG (Maks. 5MB). Berkas dokumen PDF/lainnya akan <b>DITOLAK</b>.</span>
</div>
```

- [ ] **Step 4: Update JS Edit Modal Populate Function**
Update `openEditModal(menuData)` JavaScript function in `index.blade.php` to populate `#edit_image_preview` if `menuData.image` is present.

- [ ] **Step 5: Add Image Thumbnail to Navigation Table / List**
In the menu list/table of `index.blade.php`, display thumbnail icon/image if `$menu->image` exists.

---

### Task 4: Verification & Testing

- [ ] **Step 1: Test PDF / Document Upload Blocking**
Open create navigation modal, select a `.pdf` file. Verify JS alert pops up with `🚫 AKSES DITOLAK!` and clears input field.

- [ ] **Step 2: Test Image Upload & Storage**
Upload a valid image file (`.png` / `.jpg`). Submit form. Verify menu is created and image is saved in storage.
