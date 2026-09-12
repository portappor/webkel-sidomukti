# Video Documentation Management Design Specification

**Date:** 2026-09-12  
**Status:** Approved  
**Topic:** Separate Gallery into Kelola Album and Add Dedicated Video Documentation Feature (Public Page & Admin Dashboard)

---

## 1. Overview

This feature introduces a dedicated Video Documentation system for Kelurahan Sidomukti. It reorganizes the admin sidebar into separate **Kelola Album** and **Kelola Video** sections, adds a **Video Dokumentasi** sub-menu under the *Informasi* dropdown in the public header navigation, creates a standalone public video page (`/video`), and provides complete admin CRUD for YouTube video management (`/dashboard/videos`).

---

## 2. User Experience & User Interface

### 2.1 Public Header & Mobile Navigation Updates
- **Desktop Navbar Dropdown (*Informasi*)**:
  - Contains: *Berita*, *Galeri Album*, *Video Dokumentasi*, *Agenda Kegiatan*, *Lembaga Kemasyarakatan*, *Statistik & Monografi*.
  - Link for Video Dokumentasi: `route('videos.index')` (`/video`).
- **Mobile Navigation Drawer**:
  - Includes *Video Dokumentasi* under the Informasi accordion section.

### 2.2 Public Video Page (`/video`)
- **Header**: Deep Dark theme banner (*Video Dokumentasi Resmi*), breadcrumbs (`Beranda > Informasi > Video Dokumentasi`).
- **Filter Bar**: Filter videos by category (*Semua*, *Pembangunan*, *Pemberdayaan*, *Keagamaan*, *HUT RI*, *Pemerintahan*).
- **Video Grid**: Responsive 16:9 aspect ratio cards displaying YouTube thumbnail, play icon overlay, duration badge, category badge, video title, and published date.
- **Interactive Lightbox Video Player**: Clicking a video card opens an Alpine.js full-screen modal featuring an embedded YouTube responsive iframe player (`allowfullscreen`).

### 2.3 Admin Dashboard Sidebar & CRUD (`/dashboard/videos`)
- **Admin Sidebar Navigation**:
  - Menu item: **Kelola Album** (`route('dashboard.galleries.index')`)
  - Menu item: **Kelola Video** (`route('dashboard.videos.index')`)
- **Video Index Page (`/dashboard/videos`)**: Grid/Table listing all video entries with YouTube thumbnail preview, title, category, duration, Edit link, and Delete button.
- **Create Video Page (`/dashboard/videos/create`)**: Form for title, category, YouTube URL, duration, and optional description.
- **Edit Video Page (`/dashboard/videos/{video}/edit`)**: Form for updating existing video fields.

---

## 3. Data Model & Architecture

### 3.1 Database Schema (`videos` Table)

| Column | Type | Constraints | Description |
| :--- | :--- | :--- | :--- |
| `id` | BigIncrements | Primary Key | Unique Video ID |
| `title` | String | Not Null | Video title |
| `category` | String | Default: `'pemerintahan'` | Category key |
| `youtube_url` | String | Not Null | Original YouTube watch/share URL |
| `duration` | String | Nullable | Video duration string (e.g. `'04:15'`) |
| `description` | Text | Nullable | Brief video summary |
| `created_at` | Timestamp | Nullable | Creation timestamp |
| `updated_at` | Timestamp | Nullable | Update timestamp |

### 3.2 Eloquent Model (`App\Models\Video`)
- `fillable`: `['title', 'category', 'youtube_url', 'duration', 'description']`
- Accessor `youtube_id`: Extracts the 11-character YouTube video ID using regex from standard watch (`v=...`), short link (`youtu.be/...`), or embed URLs.
- Accessor `embed_url`: Returns `https://www.youtube.com/embed/{youtube_id}`.
- Accessor `thumbnail_url`: Returns `https://img.youtube.com/vi/{youtube_id}/hqdefault.jpg`.

---

## 4. Controllers & Routes

### 4.1 Public Controller (`App\Http\Controllers\PublicVideoController`)
- `index(Request $request)`: Fetch paginated videos filtered by category. Render `videos.index`.

### 4.2 Dashboard Controller (`App\Http\Controllers\Dashboard\VideoController`)
- `index()`: Paginated video list for admin.
- `create()`: Render video creation view.
- `store(Request $request)`: Validate & create video entry. Log activity.
- `edit(Video $video)`: Render video edit view.
- `update(Request $request, Video $video)`: Validate & update video entry. Log activity.
- `destroy(Video $video)`: Delete video entry. Log activity.

---

## 5. Security & Activity Logging

- Input validation for `youtube_url` (`required|url`).
- Admin actions logged via `ActivityLogger::log('CREATE'|'UPDATE'|'DELETE', 'Video', ...)`.
