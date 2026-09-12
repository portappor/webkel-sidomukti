<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albumsData = [
            [
                'title' => 'Pelatihan & Pemberdayaan UMKM Kripik Warga Sidomukti',
                'category' => 'pemberdayaan',
                'description' => 'Dokumentasi kegiatan pelatihan pengemasan, pendaftaran Sertifikasi Halal, dan pemasaran digital untuk pelaku UMKM olahan pangan di Kelurahan Sidomukti.',
                'cover_image' => 'https://images.unsplash.com/photo-1544396821-4dd40b938ad3?q=80&w=800&auto=format&fit=crop',
                'event_date' => '2026-08-12',
                'photos' => [
                    'https://images.unsplash.com/photo-1544396821-4dd40b938ad3?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=1200&auto=format&fit=crop',
                ]
            ],
            [
                'title' => 'Peresmian Drainase Lingkungan & Gotong Royong RW 03',
                'category' => 'pembangunan',
                'description' => 'Kerja bakti gotong royong warga RW 03 bersama perangkat kelurahan dalam pembersihan saluran air drainase dan peresmian infrastruktur jalan pemukiman.',
                'cover_image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop',
                'event_date' => '2026-07-28',
                'photos' => [
                    'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1541888946425-d0fbb186a5b7?q=80&w=1200&auto=format&fit=crop',
                ]
            ],
            [
                'title' => 'Pengajian Rutin & Santunan Anak Yatim Kelurahan Sidomukti',
                'category' => 'keagamaan',
                'description' => 'Momen kebersamaan dalam acara pengajian bulanan warga dan penyerahan bantuan santunan bagi anak yatim dan kaum dhuafa.',
                'cover_image' => 'https://images.unsplash.com/photo-1574626003295-d868953930b8?q=80&w=800&auto=format&fit=crop',
                'event_date' => '2026-06-15',
                'photos' => [
                    'https://images.unsplash.com/photo-1574626003295-d868953930b8?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop',
                ]
            ],
            [
                'title' => 'Semarak Lomba & Pentas Seni Peringatan HUT RI ke-81',
                'category' => 'hut-ri',
                'description' => 'Kemeriahan berbagai lomba tradisional anak-anak dan dewasa serta malam puncak pentas seni warga Kelurahan Sidomukti.',
                'cover_image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800&auto=format&fit=crop',
                'event_date' => '2026-08-17',
                'photos' => [
                    'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1531058020387-3be344556be6?q=80&w=1200&auto=format&fit=crop',
                ]
            ],
        ];

        foreach ($albumsData as $data) {
            $baseSlug = Str::slug($data['title']);
            $album = Album::updateOrCreate(
                ['slug' => $baseSlug],
                [
                    'title' => $data['title'],
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'cover_image' => $data['cover_image'],
                    'event_date' => $data['event_date'],
                ]
            );

            foreach ($data['photos'] as $index => $photoUrl) {
                AlbumPhoto::updateOrCreate(
                    [
                        'album_id' => $album->id,
                        'image_path' => $photoUrl,
                    ],
                    [
                        'caption' => "Dokumentasi foto ke-" . ($index + 1) . " {$album->title}"
                    ]
                );
            }
        }
    }
}
