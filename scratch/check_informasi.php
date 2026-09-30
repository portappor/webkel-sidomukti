<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NavigationMenu;

$informasi = NavigationMenu::whereNull('parent_id')->where('title', 'Informasi')->with('children')->first();
if ($informasi) {
    echo "Parent: " . $informasi->title . "\n";
    foreach ($informasi->children as $child) {
        echo " - [" . $child->order . "] " . $child->title . " (" . $child->url . ")\n";
    }
}
