# Implementation Plan - Fitur Kelola Kemitraan Dashboard Admin

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun modul "Kelola Kemitraan" di Admin Dashboard Kelurahan Sidomukti pada kelompok menu PELAYANAN & KONTEN, mencakup skema database, model, controller CRUD, integrasi logger, seeder data awal, dan komponen view sidebar & dashboard.

**Architecture:** Model Laravel `Partnership`, `PartnershipController` di namespace `App\Http\Controllers\Dashboard`, migrasi `partnerships`, view `dashboard.partnerships.index`, dan penambahan item menu di `resources/views/components/admin-sidebar.blade.php`.

**Tech Stack:** Laravel, PHP, Tailwind CSS, Alpine.js, SQLite/MySQL.

## Global Constraints
- Mengikuti estetika visual dark theme sidebar (`slate-900`, `emerald-400`).
- Mendukung pencatatan log aktivitas menggunakan `ActivityLogger::log()`.

---

### Task 1: Migration, Model & Seeder Kemitraan

**Files:**
- Create: `database/migrations/2026_09_14_200000_create_partnerships_table.php`
- Create: `app/Models/Partnership.php`
- Create: `database/seeders/PartnershipSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`

- [ ] **Step 1: Create migration `create_partnerships_table`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('Pemerintah');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partnerships');
    }
};
```

- [ ] **Step 2: Create model `Partnership.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'logo',
        'description',
        'website',
        'contact_person',
        'phone',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
```

- [ ] **Step 3: Create `PartnershipSeeder.php` and run migration**

---

### Task 2: Controller & Routes CRUD Kemitraan

**Files:**
- Create: `app/Http/Controllers/Dashboard/PartnershipController.php`
- Modify: `routes/web.php`

- [ ] **Step 1: Create `PartnershipController` with index, store, update, destroy**
- [ ] **Step 2: Register routes in `routes/web.php` under dashboard middleware group**

---

### Task 3: Views & Sidebar Menu Integration

**Files:**
- Create: `resources/views/dashboard/partnerships/index.blade.php`
- Modify: `resources/views/components/admin-sidebar.blade.php`

- [ ] **Step 1: Add "Kelola Kemitraan" item in `admin-sidebar.blade.php`**
- [ ] **Step 2: Build modern CRUD dashboard view `dashboard/partnerships/index.blade.php`**
