<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$galeriCategories = [
    ['module' => 'galeri', 'name' => 'Pemerintahan', 'slug' => 'galeri-pemerintahan', 'description' => 'Dokumentasi kegiatan dinas dan aparatur kelurahan.', 'color' => 'emerald', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Pelayanan', 'slug' => 'galeri-pelayanan', 'description' => 'Dokumentasi pelayanan publik tatap muka kelurahan.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Pembangunan', 'slug' => 'galeri-pembangunan', 'description' => 'Dokumentasi proyek infrastruktur dan pembangunan fisik kelurahan.', 'color' => 'amber', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Pemberdayaan & UMKM', 'slug' => 'galeri-pemberdayaan', 'description' => 'Dokumentasi kegiatan pelatihan usaha, UMKM, dan pemuda kelurahan.', 'color' => 'purple', 'order' => 4, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Kemasyarakatan', 'slug' => 'galeri-kemasyarakatan', 'description' => 'Dokumentasi kegiatan gotong royong, kerja bakti, dan warga.', 'color' => 'cyan', 'order' => 5, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Keagamaan & Budaya', 'slug' => 'galeri-keagamaan', 'description' => 'Dokumentasi kegiatan keagamaan, hari besar, dan pentas seni budaya.', 'color' => 'indigo', 'order' => 6, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Kesehatan & Posyandu', 'slug' => 'galeri-kesehatan', 'description' => 'Dokumentasi posyandu balita, lansia, dan bakti kesehatan.', 'color' => 'rose', 'order' => 7, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Sosial & Bantuan', 'slug' => 'galeri-sosial', 'description' => 'Dokumentasi kegiatan penyaluran bantuan sosial dan penanganan bencana.', 'color' => 'emerald', 'order' => 8, 'status' => 'aktif'],
];

foreach ($galeriCategories as $data) {
    Category::updateOrCreate(
        ['slug' => $data['slug']],
        $data
    );
}

echo "Successfully updated Galeri categories. Count for galeri module: " . Category::where('module', 'galeri')->count() . "\n";
