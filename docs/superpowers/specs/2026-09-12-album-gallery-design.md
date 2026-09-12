# Gallery Album System Design Specification

**Date:** 2026-09-12  
**Status:** Approved  
**Topic:** Overhaul Gallery System into Album-based Documentation with Dedicated Detail Pages

---

## 1. Overview

The goal of this feature is to transform the existing single-photo gallery into a structured, album-based gallery system for Kelurahan Sidomukti's website. Each album will feature a cover photo (thumbnail), category metadata, title, event date, description, and multiple interior photos. Visitors can view albums on the gallery overview page and navigate to a dedicated album detail page to view all photos in high resolution via an interactive lightbox.

---

## 2. User Experience & User Interface

### 2.1 Public Gallery Overview Page (`/galeri`)
- **Album Grid**: Displays album cards featuring 16:9 ratio cover images, category badges (e.g., *Pemberdayaan*, *Pembangunan*, *Keagamaan*, *HUT RI*, *Pemerintahan*), album title, event date, and total photo count badge (e.g., `12 Foto`).
- **Interactive Filtering**: Filter albums by category and media type (Album Foto vs Video Dokumentasi).
- **Navigation**: Clicking an album card redirects visitors to `/galeri/{album:slug}`.

### 2.2 Dedicated Album Detail Page (`/galeri/{album:slug}`)
- **Header**: Breadcrumb navigation (`Beranda > Galeri > [Nama Album]`), category badge, event date, album title, and full description.
- **Photo Grid**: Responsive masonry/grid layout presenting all photos belonging to the album.
- **Interactive Lightbox Viewer (Alpine.js)**:
  - Clicking any photo opens a full-screen modal lightbox.
  - Controls: Next/Previous photo navigation, photo index counter (`Foto X dari Y`), keyboard arrow keys support, close button, and backdrop dismissal.

### 2.3 Admin Dashboard Gallery Management (`/dashboard/galleries`)
- **Album Index**: Table/grid view of albums with thumbnail cover, title, category, photo count, created date, and actions (Edit / Delete).
- **Create Album**: Form to input title, category, event date, description, cover image (file upload or URL), and multiple album photos (multi-file upload or URL list).
- **Edit Album**: Form to update album metadata, change cover image, upload additional photos to the album, or delete individual photos from the album.
- **Delete Album**: Deleting an album cascades deletion of all associated photos from storage and database.

---

## 3. Architecture & Data Model

### 3.1 Database Schema

#### `albums` Table
| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigIncrements | Primary Key | Unique ID |
| `title` | String | Not Null | Title of the album |
| `slug` | String | Unique, Index | URL slug |
| `category` | String | Default: `'pemerintahan'` | Category key |
| `description` | Text | Nullable | Detailed album description |
| `cover_image` | String | Not Null | File path or URL to thumbnail photo |
| `event_date` | Date | Nullable | Date of the documented event |
| `created_at` | Timestamp | Nullable | Creation timestamp |
| `updated_at` | Timestamp | Nullable | Update timestamp |

#### `album_photos` Table
| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigIncrements | Primary Key | Unique ID |
| `album_id` | ForeignId | Foreign Key -> `albums(id)` ON DELETE CASCADE | Parent album reference |
| `image_path` | String | Not Null | File path or URL of photo |
| `caption` | String | Nullable | Optional caption for individual photo |
| `created_at` | Timestamp | Nullable | Creation timestamp |
| `updated_at` | Timestamp | Nullable | Update timestamp |

---

## 4. Models & Controller Logic

### 4.1 Models
- `App\Models\Album`:
  - Fillable: `title`, `slug`, `category`, `description`, `cover_image`, `event_date`
  - Relationship: `photos()` -> `hasMany(AlbumPhoto::class)`
  - Helper / Accessor: `cover_url` accessor to handle local storage vs HTTP URLs seamlessly.
- `App\Models\AlbumPhoto`:
  - Fillable: `album_id`, `image_path`, `caption`
  - Relationship: `album()` -> `belongsTo(Album::class)`
  - Accessor: `image_url` accessor for local storage vs HTTP URLs.

### 4.2 Controllers
- `App\Http\Controllers\GalleryController` (Public):
  - `index()`: Fetch paginated `Album::withCount('photos')->latest()` with category filters.
  - `show($slug)`: Fetch `Album::with('photos')->where('slug', $slug)->firstOrFail()`.
- `App\Http\Controllers\Dashboard\GalleryController` (Admin Dashboard):
  - `index()`: List all albums with photo count for admin.
  - `create()`: Render album creation view.
  - `store(Request $request)`: Validate & store album, cover image, and multi-file uploaded photos.
  - `edit(Album $album)`: Render album edit view with existing photos.
  - `update(Request $request, Album $album)`: Update album attributes, handle optional cover image replacement, and handle additional uploaded photos.
  - `destroy(Album $album)`: Delete album record & clean up storage files.
  - `destroyPhoto(AlbumPhoto $photo)`: Endpoint/action to remove single photo from album.

---

## 5. Security & Validation

- File Uploads: Validate image files (`mimes:jpeg,png,jpg,webp`, `max:5120`).
- Storage Cleanup: Ensure `Storage::disk('public')->delete()` is called when albums or individual photos are deleted.
- Activity Logging: Integrate `ActivityLogger::log()` for album creation, updates, and deletions.
