<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NavigationMenu;

$informasi = NavigationMenu::whereNull('parent_id')->where('title', 'Informasi')->first();
if ($informasi) {
    NavigationMenu::updateOrCreate(
        ['parent_id' => $informasi->id, 'url' => '/informasi/apbd'],
        ['title' => 'Transparansi APBD', 'order' => 6, 'target' => '_self', 'is_active' => true]
    );
    NavigationMenu::where('parent_id', $informasi->id)->where('url', '/profil/demografi')->update(['order' => 7]);
    echo "APBD Navigation Menu updated successfully!\n";
} else {
    echo "Parent menu 'Informasi' not found.\n";
}
