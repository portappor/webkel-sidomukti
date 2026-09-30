<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$services = [
    [
        'title' => 'Surat Keterangan Usaha (SKU)',
        'description' => 'Layanan pembuatan Surat Keterangan Usaha bagi warga yang memiliki usaha.',
        'icon' => 'briefcase'
    ],
    [
        'title' => 'Surat Keterangan Domisili',
        'description' => 'Layanan pembuatan Surat Keterangan Domisili tempat tinggal.',
        'icon' => 'home'
    ],
    [
        'title' => 'Surat Keterangan Tidak Mampu (SKTM)',
        'description' => 'Layanan pembuatan SKTM untuk keperluan pendidikan, kesehatan, atau bantuan.',
        'icon' => 'tag'
    ],
    [
        'title' => 'Surat Pengantar Nikah (N1-N4)',
        'description' => 'Layanan pengantar nikah ke KUA atau instansi terkait.',
        'icon' => 'heart'
    ],
    [
        'title' => 'Surat Pengantar KTP / KK',
        'description' => 'Layanan pengantar pembuatan atau perubahan KTP dan Kartu Keluarga.',
        'icon' => 'id-card'
    ],
    [
        'title' => 'Surat Keterangan Kematian',
        'description' => 'Layanan pengurusan surat keterangan kematian warga.',
        'icon' => 'cross'
    ],
    [
        'title' => 'Surat Keterangan Kelahiran',
        'description' => 'Layanan pengurusan surat keterangan kelahiran anak.',
        'icon' => 'baby'
    ],
    [
        'title' => 'Surat Keterangan Belum Menikah',
        'description' => 'Layanan surat pernyataan belum menikah.',
        'icon' => 'user'
    ],
    [
        'title' => 'Surat Keterangan Ahli Waris / Beda Nama',
        'description' => 'Layanan surat keterangan ahli waris atau perbedaan data nama.',
        'icon' => 'file'
    ]
];

foreach ($services as $s) {
    \App\Models\Service::firstOrCreate(
        ['title' => $s['title']],
        ['description' => $s['description'], 'is_active' => true]
    );
}

echo "TOTAL SERVICES: " . \App\Models\Service::count() . "\n";
