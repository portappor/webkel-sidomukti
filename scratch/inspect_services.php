<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

$services = Service::with('kategoriLayanan')->get();
foreach ($services as $s) {
    echo "ID: {$s->id}\n";
    echo "  Title: {$s->title}\n";
    echo "  Cat ID: {$s->kategori_layanan_id} | Name: " . ($s->kategoriLayanan ? $s->kategoriLayanan->nama_kategori : 'NULL') . "\n";
    echo "  Operating Hours: {$s->operating_hours}\n";
    echo "  Processing Time: {$s->processing_time}\n";
    echo "  Cost: {$s->cost}\n";
    echo "  File Path: {$s->file_path}\n";
    echo "--------------------------------------------------------\n";
}
