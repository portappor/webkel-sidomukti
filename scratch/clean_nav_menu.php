<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NavigationMenu;

$dokumenParent = NavigationMenu::where('title', 'Dokumen')->orWhere('url', '/dokumen')->first();

if ($dokumenParent) {
    echo "Dokumen Parent ID: {$dokumenParent->id}\n";
    $children = NavigationMenu::where('parent_id', $dokumenParent->id)->get();
    foreach ($children as $c) {
        echo " - Child ID {$c->id}: {$c->title} ({$c->url})\n";
        // Delete child items under Dokumen to prevent duplication
        $c->delete();
        echo "   -> Deleted child item ID {$c->id}\n";
    }
} else {
    echo "Dokumen parent menu not found.\n";
}
