<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::all();
foreach ($users as $u) {
    if (empty($u->phone)) {
        $u->phone = '081234567890';
    }
    if (empty($u->referral_code)) {
        $u->referral_code = ($u->role === 'admin' ? 'ADM001' : 'STF888');
    }
    $u->save();
    echo "Updated User ID {$u->id} ({$u->email}) -> Phone: {$u->phone} | Referral Code: {$u->referral_code}\n";
}
