<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\PublicServiceController;
use App\Http\Controllers\Dashboard\DemographicController;
use App\Http\Controllers\Dashboard\RtRwController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ComplaintController;
use App\Http\Controllers\Dashboard\AgendaController as DashboardAgendaController;
use App\Http\Controllers\Dashboard\DocumentController as DashboardDocumentController;
use App\Http\Controllers\Dashboard\LembagaController as DashboardLembagaController;
use App\Http\Controllers\Dashboard\ActivityLogController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil/visi-misi', [ProfileController::class, 'visiMisi'])->name('profil.visi-misi');
Route::get('/profil/struktur-organisasi', [ProfileController::class, 'struktur'])->name('profil.struktur');
Route::get('/profil/sejarah', [ProfileController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/profil/demografi', [ProfileController::class, 'demografi'])->name('profil.demografi');
Route::get('/statistik-penduduk', [ProfileController::class, 'demografi'])->name('statistik.index');
Route::get('/hubungi', function () {
    $settingsRaw = \App\Models\Setting::all();
    $settings = $settingsRaw->pluck('value', 'key')->toArray();
    return view('contact', compact('settings'));
})->name('contact');

Route::get('/berita', [App\Http\Controllers\PublicPostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [App\Http\Controllers\PublicPostController::class, 'show'])->name('posts.show');

Route::get('/galeri', [App\Http\Controllers\PublicGalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{slug}', [App\Http\Controllers\PublicGalleryController::class, 'show'])->name('galleries.show');
Route::get('/agenda', [App\Http\Controllers\AgendaController::class, 'index'])->name('agendas.index');
Route::get('/lembaga', [App\Http\Controllers\LembagaController::class, 'index'])->name('lembaga.index');
Route::get('/lembaga-kemasyarakatan', [App\Http\Controllers\LembagaController::class, 'index']);

Route::get('/transparansi', [App\Http\Controllers\PublicBudgetController::class, 'index'])->name('budgets.public_index');
Route::get('/dokumen/musrenbang', [App\Http\Controllers\DocumentController::class, 'musrenbang'])->name('documents.musrenbang');
Route::get('/dokumen/renstra-renja', [App\Http\Controllers\DocumentController::class, 'renstraRenja'])->name('documents.renstra_renja');
Route::get('/dokumen/sk-kelembagaan', [App\Http\Controllers\DocumentController::class, 'skKelembagaan'])->name('documents.sk_kelembagaan');

// ----------------------------------------------------------------
// LAYANAN & SOP ROUTES (PUBLIC)
// ----------------------------------------------------------------
Route::get('/layanan', [PublicServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [PublicServiceController::class, 'show'])->name('services.show');
Route::get('/layanan/{slug}/download', [PublicServiceController::class, 'download'])->name('services.download');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard Route (All Auth Users)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Berita Routes (All Auth Users)
    Route::resource('/dashboard/posts', PostController::class, ['as' => 'dashboard'])->except(['show']);

    // Galeri Routes (All Auth Users)
    Route::resource('/dashboard/galleries', GalleryController::class, ['as' => 'dashboard'])->except(['show']);
    Route::delete('/dashboard/galleries/photos/{photo}', [GalleryController::class, 'destroyPhoto'])->name('dashboard.galleries.photos.destroy');

    // Pengumuman Routes (All Auth Users)
    Route::resource('/dashboard/announcements', AnnouncementController::class, ['as' => 'dashboard'])->except(['show']);

    // Transparansi Anggaran Routes (All Auth Users)
    Route::resource('/dashboard/budgets', BudgetController::class, ['as' => 'dashboard'])->except(['show']);

    // Agenda Kegiatan Admin Routes
    Route::get('/dashboard/agendas', [DashboardAgendaController::class, 'index'])->name('dashboard.agendas.index');
    Route::post('/dashboard/agendas', [DashboardAgendaController::class, 'store'])->name('dashboard.agendas.store');
    Route::delete('/dashboard/agendas/{id}', [DashboardAgendaController::class, 'destroy'])->name('dashboard.agendas.destroy');

    // Pengaduan & Pesan Warga Admin Routes
    Route::get('/dashboard/complaints', [ComplaintController::class, 'index'])->name('dashboard.complaints.index');
    Route::put('/dashboard/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('dashboard.complaints.update-status');
    Route::delete('/dashboard/complaints/{id}', [ComplaintController::class, 'destroy'])->name('dashboard.complaints.destroy');

    // Kelola & Unggah Dokumen PDF
    Route::get('/dashboard/documents', [DashboardDocumentController::class, 'index'])->name('dashboard.documents.index');

    // ----------------------------------------------------------------
    // ADMIN ONLY ROUTES
    // ----------------------------------------------------------------
    Route::middleware('role:admin')->group(function () {
        // Standar Pelayanan & SOP Routes (Master)
        Route::resource('/dashboard/services', ServiceController::class, ['as' => 'dashboard'])->except(['show']);

        // Master Data Routes
        Route::get('/dashboard/demographics', [DemographicController::class, 'index'])->name('dashboard.demographics.index');
        Route::resource('/dashboard/categories', CategoryController::class, ['as' => 'dashboard'])->except(['show', 'create', 'edit']);
        
        // Data RT/RW Routes
        Route::get('/dashboard/rt-rw', [RtRwController::class, 'index'])->name('dashboard.rt-rw.index');
        Route::post('/dashboard/rt-rw', [RtRwController::class, 'store'])->name('dashboard.rt-rw.store');
        Route::put('/dashboard/rt-rw/{id}', [RtRwController::class, 'update'])->name('dashboard.rt-rw.update');
        Route::delete('/dashboard/rt-rw/{id}', [RtRwController::class, 'destroy'])->name('dashboard.rt-rw.destroy');

        // Lembaga Kemasyarakatan Admin Routes
        Route::get('/dashboard/lembagas', [DashboardLembagaController::class, 'index'])->name('dashboard.lembagas.index');
        Route::post('/dashboard/lembagas', [DashboardLembagaController::class, 'store'])->name('dashboard.lembagas.store');
        Route::put('/dashboard/lembagas/{id}', [DashboardLembagaController::class, 'update'])->name('dashboard.lembagas.update');
        Route::delete('/dashboard/lembagas/{id}', [DashboardLembagaController::class, 'destroy'])->name('dashboard.lembagas.destroy');

        // Settings / Profil Dedicated Sections
        Route::get('/dashboard/settings/profile', [SettingController::class, 'profile'])->name('dashboard.settings.profile');
        Route::get('/dashboard/settings/visi-misi', [SettingController::class, 'visiMisi'])->name('dashboard.settings.visi-misi');
        Route::get('/dashboard/settings/sejarah', [SettingController::class, 'sejarah'])->name('dashboard.settings.sejarah');
        Route::get('/dashboard/settings/aparatur', [SettingController::class, 'aparatur'])->name('dashboard.settings.aparatur');
        Route::delete('/dashboard/settings/key/{key}', [SettingController::class, 'destroyKey'])->name('dashboard.settings.destroy-key');
        Route::delete('/dashboard/settings/{key}', [SettingController::class, 'destroyKey'])->name('dashboard.settings.destroy');
        
        Route::get('/dashboard/settings', [SettingController::class, 'index'])->name('dashboard.settings.index');
        Route::put('/dashboard/settings', [SettingController::class, 'update'])->name('dashboard.settings.update');

        // User Management (Akun Operator)
        Route::resource('/dashboard/users', UserController::class, ['as' => 'dashboard'])->except(['show']);

        // Log Aktivitas Sistem
        Route::get('/dashboard/activity-logs', [ActivityLogController::class, 'index'])->name('dashboard.activity-logs.index');
        Route::post('/dashboard/activity-logs/clear', [ActivityLogController::class, 'clear'])->name('dashboard.activity-logs.clear');
    });
});
