<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\KategoriLayananController;

$controller = new KategoriLayananController();
$request = Request::create('/admin/master-kategori/quick-store', 'POST', [
    'nama_kategori' => 'Layanan Khusus Disabilitas ' . rand(100, 999),
    'deskripsi' => 'Kategori tes otomatis'
]);

$response = $controller->quickStore($request);
echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Response JSON: " . $response->getContent() . "\n";
