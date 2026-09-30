<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$agendas = [
    [
        'title' => 'Kerja Bakti Gotong Royong Kebersihan Lingkungan RT 01-04',
        'description' => 'Pembersihan selokan, pemangkasan pohon rawan tumbang, serta sterilisasi jentik nyamuk DBD di seluruh lingkungan RW 01.',
        'date' => '2026-09-20',
        'time' => '06:00 WIB',
        'location' => 'Lingkungan RW 01 Kelurahan Kandang Jati Kulon',
        'organizer' => 'Pengurus RT/RW & Satgas Linmas',
        'is_active' => true,
    ],
    [
        'title' => 'Pelayanan Posyandu Balita & Lansia Terpadu RW 02',
        'description' => 'Pemeriksaan kesehatan, penimbangan balita, cek tensi lansia, serta pemberian makanan tambahan (PMT) gizi anak.',
        'date' => '2026-09-15',
        'time' => '08:00 - 11:30 WIB',
        'location' => 'Posyandu Melati RW 02 Kelurahan Kandang Jati Kulon',
        'organizer' => 'Tim TP-PKK & Puskesmas Kraksaan',
        'is_active' => true,
    ],
    [
        'title' => 'Musrenbangkel Kelurahan Kandang Jati Kulon Tahun 2026',
        'description' => 'Musyawarah Perencanaan Pembangunan Kelurahan untuk penyusunan prioritas usulan pembangunan infrastruktur dan pemberdayaan warga.',
        'date' => '2026-09-10',
        'time' => '08:30 WIB',
        'location' => 'Pendopo Balai Kelurahan Kandang Jati Kulon',
        'organizer' => 'Pemerintah Kelurahan Kandang Jati Kulon & LPMK',
        'is_active' => true,
    ],
];

foreach ($agendas as $a) {
    \App\Models\Agenda::firstOrCreate(
        ['title' => $a['title']],
        $a
    );
}

echo "TOTAL AGENDAS: " . \App\Models\Agenda::count() . "\n";
