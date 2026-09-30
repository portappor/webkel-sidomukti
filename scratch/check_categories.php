<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$categories = App\Models\Category::all();
echo "TOTAL: " . $categories->count() . "\n";
foreach ($categories as $cat) {
    echo "- ID: {$cat->id} | Name: {$cat->name} | Slug: {$cat->slug}\n";
}
