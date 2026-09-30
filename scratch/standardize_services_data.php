<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Service;

$services = Service::all();
foreach ($services as $service) {
    // If operating_hours is just 'Senin - Jumat' or missing time, set standardized operating hours
    if ($service->operating_hours === 'Senin - Jumat' || empty($service->operating_hours)) {
        $service->operating_hours = 'Senin - Jumat (07.30 - 15.30 WIB)';
    }

    // If processing_time is 'Tergantung Layanan' or empty, set standardized default
    if ($service->processing_time === 'Tergantung Layanan' || empty($service->processing_time)) {
        $service->processing_time = '1 Hari Kerja (1x24 Jam)';
    }

    // Ensure cost default is GRATIS if null
    if (empty($service->cost)) {
        $service->cost = 'GRATIS';
    }

    $service->save();
}

echo "Updated " . count($services) . " services with standardized operating hours and processing time!\n";
