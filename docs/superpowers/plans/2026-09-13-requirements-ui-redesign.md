# Requirements UI & Admin Field Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Redesign the "Persyaratan Dokumen" (Requirements) section in `resources/views/services/show.blade.php` into a responsive 2-column grid of individual cards with checkmark icons, and add `requirements` management to the admin dashboard.

**Architecture:** Parse requirements string (newline/comma/semicolon separated) into individual items in Blade, render as responsive grid cards (`grid-cols-1 sm:grid-cols-2`), and expose `requirements` textarea input in admin dashboard create/edit service views.

**Tech Stack:** Laravel 11 (Blade, Eloquent), Tailwind CSS, PHP 8.2

## Global Constraints
- Framework: Laravel / Blade templates with Tailwind CSS
- Color Palette: Emerald design system (`emerald-500`, `emerald-600`, `emerald-50`, `slate-700`, etc.)
- Icons: SVG icons (matching existing template style)

---

### Task 1: Update Service Model and Controller for Requirements Field

**Files:**
- Modify: `d:\portal-desa\webkel-sidomukti\app\Models\Service.php:12-21`
- Modify: `d:\portal-desa\webkel-sidomukti\app\Http\Controllers\ServiceController.php:33-113`

**Interfaces:**
- Consumes: `$request->requirements` input from dashboard forms.
- Produces: `$service->requirements` saved text attribute in DB and accessible in Blade templates.

- [ ] **Step 1: Update Service model fillable array**
Add `'requirements'` to `$fillable` in `app/Models/Service.php`.

- [ ] **Step 2: Update ServiceController store and update methods**
In `app/Http/Controllers/ServiceController.php`:
- Add `'requirements' => 'nullable|string'` to `store()` validation rules and `Service::create([... 'requirements' => $request->requirements ...])`.
- Add `'requirements' => 'nullable|string'` to `update()` validation rules and `$service->update([... 'requirements' => $request->requirements ...])`.

- [ ] **Step 3: Test controller logic via php artisan tinker or test execution**
Run tinker check to verify `requirements` column is fillable.

- [ ] **Step 4: Commit**
```bash
git add app/Models/Service.php app/Http/Controllers/ServiceController.php
git commit -m "feat: add requirements field to Service model fillable and controller"
```

---

### Task 2: Add Requirements Textarea Field to Admin Dashboard Views

**Files:**
- Modify: `d:\portal-desa\webkel-sidomukti\resources\views\dashboard\services\create.blade.php:48-55`
- Modify: `d:\portal-desa\webkel-sidomukti\resources\views\dashboard\services\edit.blade.php:57-64`

**Interfaces:**
- Consumes: Admin user text input for requirements list.
- Produces: Form request containing `requirements` field.

- [ ] **Step 1: Modify create.blade.php**
Add a textarea input for `requirements` with helpful placeholder (e.g. `Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW`).

- [ ] **Step 2: Modify edit.blade.php**
Add a textarea input for `requirements` pre-populated with `old('requirements', $service->requirements)`.

- [ ] **Step 3: Commit**
```bash
git add resources/views/dashboard/services/create.blade.php resources/views/dashboard/services/edit.blade.php
git commit -m "feat: add requirements field to dashboard service create and edit forms"
```

---

### Task 3: Redesign Public Requirements Section in services/show.blade.php

**Files:**
- Modify: `d:\portal-desa\webkel-sidomukti\resources\views\services\show.blade.php:129-145`

**Interfaces:**
- Consumes: `$service->requirements` string from database or fallback string.
- Produces: 2-column grid cards of requirement items with checkmark icons and count badge.

- [ ] **Step 1: Parse requirements string into array items**
Add Blade parsing block:
```blade
@php
    $rawReqs = $service->requirements ?? 'Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW';
    if (str_contains($rawReqs, "\n")) {
        $reqItems = array_map('trim', explode("\n", $rawReqs));
    } else {
        $reqItems = array_map('trim', preg_split('/[,;]+/', $rawReqs));
    }
    $reqItems = array_values(array_filter($reqItems, fn($i) => !empty($i)));
@endphp
```

- [ ] **Step 2: Render section header with total count badge and 2-column grid cards**
Replace single bullet box with:
- Header badge showing `{{ count($reqItems) }} Berkas Wajib`.
- `grid grid-cols-1 sm:grid-cols-2 gap-3`.
- Individual card items:
  - Container: `bg-white border border-slate-200/80 rounded-xl p-3 sm:p-3.5 shadow-2xs hover:border-emerald-300 hover:shadow-xs transition duration-150 flex items-start gap-3`
  - Icon: Green checkmark inside `w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center shrink-0 mt-0.5`.
  - Text: `text-xs font-semibold text-slate-700 leading-snug`.

- [ ] **Step 3: Verify visual layout and responsiveness**
Check view structure and confirm syntax correctness.

- [ ] **Step 4: Commit**
```bash
git add resources/views/services/show.blade.php
git commit -m "feat: redesign requirements section into 2-column grid cards with checkmark icons"
```
