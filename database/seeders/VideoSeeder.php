<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Video Profil & Potensi Kelurahan Sidomukti 2026',
                'category' => 'pemerintahan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '05:30',
                'description' => 'Gambaran umum pelayanan publik, tata kelola pemerintahan, dan potensi wilayah Kelurahan Sidomukti.',
            ],
            [
                'title' => 'Dokumentasi Peresmian Drainase Lingkungan & Gotong Royong RW 03',
                'category' => 'pembangunan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '04:15',
                'description' => 'Kerja bakti gotong royong warga RW 03 bersama peresmian sistem drainase lingkungan.',
            ],
            [
                'title' => 'Semarak Lomba & Malam Puncak Peringatan HUT RI ke-81',
                'category' => 'hut-ri',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '08:45',
                'description' => 'Kemeriahan pesta rakyat, lomba jalan sehat, dan pentas seni warga Kelurahan Sidomukti.',
            ],
            [
                'title' => 'Pelatihan Digital Marketing & Sertifikasi Halal UMKM Sidomukti',
                'category' => 'pemberdayaan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration' => '06:20',
                'description' => 'Kegiatan pelatihan pemberdayaan ekonomi masyarakat bagi para pelaku usaha mikro di Sidomukti.',
            ],
        ];

        foreach ($videos as $v) {
            Video::firstOrCreate(['title' => $v['title']], $v);
        }
    }
}
