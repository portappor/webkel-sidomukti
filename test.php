<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$content = file_get_contents('resources/views/components/admin-sidebar.blade.php');
preg_match_all('/route\(\'([^\']+)\'/', $content, $matches);

$routes = array_unique($matches[1]);

foreach ($routes as $name) {
    if (strpos($name, '.*') !== false) {
        // request()->routeIs() uses patterns with .* so skip them
        continue;
    }
    try {
        route($name);
        // echo $name . " OK\n";
    } catch (\Exception $e) {
        echo "FAILED: " . $name . "\n";
    }
}
echo "Done checking all routes in admin-sidebar.blade.php\n";
