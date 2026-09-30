# Requirements UI & Admin Field Redesign Specification

**Date:** 2026-09-13  
**Status:** Approved by User  
**Target:** `resources/views/services/show.blade.php`, `app/Models/Service.php`, `app/Http/Controllers/ServiceController.php`, `resources/views/dashboard/services/create.blade.php`, `resources/views/dashboard/services/edit.blade.php`

---

## 1. Overview
Currently, the "Persyaratan Dokumen" (Document Requirements) section in the public SOP detail view (`services/show.blade.php`) displays all requirements as a single continuous string inside a single box with a single bullet point (e.g. `Foto KTP Warga, Kartu Keluarga (KK), Foto Tempat Usaha/Rumah, Surat Pengantar RT/RW`). This lacks structure and visual clarity.

This specification outlines the redesign of the requirements section into a modern **2-Column Grid of Individual Cards with Checkmark Icons**, as well as adding admin management capabilities so admins can manage requirement lists directly from the dashboard.

---

## 2. Proposed Changes

### 2.1 Public SOP Detail View (`resources/views/services/show.blade.php`)
- **Smart Item Parsing**:
  - Extract `$service->requirements` (falling back to standard document list if empty).
  - Split requirements cleanly using `\n` (newlines) if present, or split by comma `,` / semicolon `;`.
  - Filter empty lines and trim whitespace from each requirement item.
- **Visual Design**:
  - Header: Number badge (`1`), title `PERSYARATAN DOKUMEN`, and a right-aligned pill badge showing total count (e.g. `4 Berkas Wajib`).
  - Grid Layout: Responsive 2-column grid (`grid grid-cols-1 sm:grid-cols-2 gap-3`).
  - Card Item Styling:
    - White card background with subtle border (`bg-white border border-slate-200/80 rounded-xl p-3 sm:p-3.5 shadow-2xs hover:border-emerald-300 hover:shadow-xs transition duration-150 flex items-start gap-3`).
    - Emerald checkmark icon circle (`w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center shrink-0 mt-0.5`).
    - Clear requirement title / text (`text-xs font-semibold text-slate-700 leading-snug`).

### 2.2 Model & Controller (`app/Models/Service.php`, `app/Http/Controllers/ServiceController.php`)
- Add `'requirements'` to `Service::$fillable`.
- Update `ServiceController::store` and `ServiceController::update` to validate `requirements` (`nullable|string`) and save it to the database.

### 2.3 Admin Dashboard Forms (`create.blade.php`, `edit.blade.php`)
- Add a dedicated **Persyaratan Dokumen** `textarea` field in both create and edit forms.
- Helper text guiding admins to enter requirements separated by commas or new lines.

---

## 3. Verification Plan

### Manual Verification
1. Open public SOP detail page (e.g. `/layanan/standar-pelayanan-publik-kelurahan`).
2. Verify "Persyaratan Dokumen" is rendered cleanly in 2-column grid cards with checkmark icons and badge counter.
3. Test layout responsiveness on mobile (1-column stack) and desktop (2-column grid).
4. Access Admin Dashboard -> Standar Pelayanan & SOP -> Edit document.
5. Verify `requirements` textarea field exists and updates correctly upon form submission.
