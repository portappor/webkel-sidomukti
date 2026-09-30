<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$videoCategories = [
    ['module' => 'video', 'name' => 'Pemerintahan', 'slug' => 'video-pemerintahan', 'description' => 'Dokumentasi video kegiatan dinas dan aparatur kelurahan.', 'color' => 'emerald', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'video', 'name' => 'Pembangunan', 'slug' => 'video-pembangunan', 'description' => 'Dokumentasi video proyek infrastruktur dan pembangunan.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'video', 'name' => 'Pemberdayaan', 'slug' => 'video-pemberdayaan', 'description' => 'Dokumentasi video pelatihan UMKM & pemberdayaan warga.', 'color' => 'purple', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'video', 'name' => 'Keagamaan', 'slug' => 'video-keagamaan', 'description' => 'Dokumentasi video kegiatan keagamaan & safari kelurahan.', 'color' => 'indigo', 'order' => 4, 'status' => 'aktif'],
    ['module' => 'video', 'name' => 'HUT RI & Seni Budaya', 'slug' => 'video-hut-ri', 'description' => 'Dokumentasi video perlombaan HUT RI & festival seni budaya.', 'color' => 'rose', 'order' => 5, 'status' => 'aktif'],
];

foreach ($videoCategories as $data) {
    Category::updateOrCreate(
        ['slug' => $data['slug']],
        $data
    );
}

echo "Successfully seeded video categories. Count for video module: " . Category::where('module', 'video')->count() . "\n";
