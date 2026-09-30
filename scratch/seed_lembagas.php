<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Lembaga;

$initialLembagas = [
    [
        'name' => 'LPMK (Lembaga Pemberdayaan Masyarakat Kelurahan)',
        'description' => 'Mitra utama Pemerintah KELURAHAN SIDOMUKTI dalam perencanaan, pelaksanaan, dan pengendalian pembangunan yang berorientasi pada aspirasi warga.',
        'leader_title' => 'Ketua LPMK',
        'leader_name' => 'Bapak H. Sugeng Riyadi',
        'icon' => 'building',
        'color_theme' => 'emerald',
        'sort_order' => 1,
        'is_active' => true,
    ],
    [
        'name' => 'TP-PKK (Tim Penggerak PKK KELURAHAN SIDOMUKTI)',
        'description' => 'Gerakan pemberdayaan keluarga yang aktif mengelola program kesehatan posyandu, ketahanan pangan keluarga, dan peningkatan UMKM perempuan.',
        'leader_title' => 'Ketua TP-PKK',
        'leader_name' => 'Ibu Hj. Nurul Syarif',
        'icon' => 'user-female',
        'color_theme' => 'rose',
        'sort_order' => 2,
        'is_active' => true,
    ],
    [
        'name' => 'Karang Taruna "Sidomukti Kraksaan Mandiri"',
        'description' => 'Wadah pengembangan generasi muda kelurahan dalam kegiatan sosial, olahraga, seni budaya, serta wirausaha pemuda digital.',
        'leader_title' => 'Ketua Karang Taruna',
        'leader_name' => 'Mas Arif Hidayat',
        'icon' => 'user-male',
        'color_theme' => 'blue',
        'sort_order' => 3,
        'is_active' => true,
    ],
    [
        'name' => 'Tiga Pilar & Satlinmas KELURAHAN SIDOMUKTI',
        'description' => 'Sinergi LURAH SIDOMUKTI, Babinsa (TNI), Bhabinkamtibmas (Polri), dan Anggota Satlinmas dalam menjaga ketertiban, keamanan poskamling, dan perlindungan warga.',
        'leader_title' => 'Babinsa & Bhabinkamtibmas',
        'leader_name' => 'Babinsa: Sertu Bambang | Bhabinkamtibmas: Aiptu Didik',
        'icon' => 'shield',
        'color_theme' => 'amber',
        'sort_order' => 4,
        'is_active' => true,
    ],
];

foreach ($initialLembagas as $data) {
    Lembaga::updateOrCreate(
        ['name' => $data['name']],
        $data
    );
}

echo "Lembaga seeded: " . Lembaga::count() . "\n";
