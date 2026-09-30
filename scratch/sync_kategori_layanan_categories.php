<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\KategoriLayanan;

$katLayanans = KategoriLayanan::all();
foreach ($katLayanans as $idx => $kl) {
    Category::updateOrCreate(
        ['slug' => $kl->slug],
        [
            'name' => $kl->nama_kategori,
            'description' => $kl->deskripsi,
            'module' => 'layanan',
            'color' => 'emerald',
            'order' => $idx + 1,
            'status' => 'aktif',
        ]
    );
}

// And reverse sync from Category (module = 'layanan') to KategoriLayanan
$categoriesLayanan = Category::where('module', 'layanan')->get();
foreach ($categoriesLayanan as $c) {
    KategoriLayanan::updateOrCreate(
        ['slug' => $c->slug],
        [
            'nama_kategori' => $c->name,
            'deskripsi' => $c->description,
        ]
    );
}

echo "Synced Categories with module='layanan': " . Category::where('module', 'layanan')->count() . "\n";
echo "Total KategoriLayanan: " . KategoriLayanan::count() . "\n";
