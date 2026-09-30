<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$deleted = Category::whereNotIn('module', ['berita', 'galeri'])->delete();

echo "Deleted {$deleted} categories belonging to removed modules.\n";
echo "Remaining categories count: " . Category::count() . "\n";
foreach (Category::all() as $cat) {
    echo "- [{$cat->module}] {$cat->name} ({$cat->slug})\n";
}
