<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\KategoriLayanan;
use App\Models\Service;

$cats = [
    [
        'nama_kategori' => 'Kependudukan & Catatan Sipil',
        'slug' => 'kependudukan-catatan-sipil',
        'deskripsi' => 'Layanan terkait kartu keluarga, KTP, akta lahir, dan surat pindah.'
    ],
    [
        'nama_kategori' => 'Perizinan & Usaha',
        'slug' => 'perizinan-usaha',
        'deskripsi' => 'Layanan pembuatan surat keterangan usaha (SKU), domisili usaha, dan rekomendasi.'
    ],
    [
        'nama_kategori' => 'Bantuan Sosial & Kesejahteraan',
        'slug' => 'bantuan-sosial-kesejahteraan',
        'deskripsi' => 'Layanan terkait SKTM, rekomendasi KIS/BPJS, dan jaminan sosial.'
    ],
    [
        'nama_kategori' => 'Surat Keterangan Umum',
        'slug' => 'surat-keterangan-umum',
        'deskripsi' => 'Layanan surat keterangan umum, SKCK, berkelakuan baik, dan pertanahan.'
    ]
];

foreach ($cats as $c) {
    KategoriLayanan::firstOrCreate(['slug' => $c['slug']], $c);
}

// Assign existing services to categories based on title keyword
$services = Service::all();
$catKependudukan = KategoriLayanan::where('slug', 'kependudukan-catatan-sipil')->first();
$catUsaha = KategoriLayanan::where('slug', 'perizinan-usaha')->first();
$catBansos = KategoriLayanan::where('slug', 'bantuan-sosial-kesejahteraan')->first();
$catUmum = KategoriLayanan::where('slug', 'surat-keterangan-umum')->first();

foreach ($services as $service) {
    if (!$service->kategori_layanan_id) {
        $title = strtolower($service->title);
        if (str_contains($title, 'usaha') || str_contains($title, 'sku') || str_contains($title, 'izin') || str_contains($title, 'domisili')) {
            $service->kategori_layanan_id = $catUsaha->id;
        } elseif (str_contains($title, 'sktm') || str_contains($title, 'miskin') || str_contains($title, 'bantuan') || str_contains($title, 'kis') || str_contains($title, 'bpjs')) {
            $service->kategori_layanan_id = $catBansos->id;
        } elseif (str_contains($title, 'ktp') || str_contains($title, 'kk') || str_contains($title, 'pindah') || str_contains($title, 'kelahiran') || str_contains($title, 'kematian')) {
            $service->kategori_layanan_id = $catKependudukan->id;
        } else {
            $service->kategori_layanan_id = $catUmum->id;
        }
        $service->save();
    }
}

echo "Success! Kategori Layanan count: " . KategoriLayanan::count() . "\n";
echo "Services count with category: " . Service::whereNotNull('kategori_layanan_id')->count() . "\n";
