<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pemerintahan',
                'slug' => 'pemerintahan',
                'description' => 'Berita dan informasi seputar kebijakan, administrasi, dan tata kelola kelurahan.',
            ],
            [
                'name' => 'Pembangunan',
                'slug' => 'pembangunan',
                'description' => 'Informasi proyek infrastruktur, renovasi fasilitas, dan kemajuan pembangunan wilayah.',
            ],
            [
                'name' => 'Kemasyarakatan',
                'slug' => 'kemasyarakatan',
                'description' => 'Kegiatan sosial, gotong royong, keagamaan, dan kerukunan warga.',
            ],
            [
                'name' => 'Pemberdayaan',
                'slug' => 'pemberdayaan',
                'description' => 'Program pelatihan, UMKM, pembinaan pemuda, dan peningkatan kesejahteraan.',
            ],
            [
                'name' => 'Informasi Umum',
                'slug' => 'informasi-umum',
                'description' => 'Kabar umum, edukasi publik, dan pengumuman umum untuk seluruh warga.',
            ],
            [
                'name' => 'Kesehatan & Lingkungan',
                'slug' => 'kesehatan-lingkungan',
                'description' => 'Program posyandu, kebersihan lingkungan, penanganan sampah, dan kesehatan masyarakat.',
            ],
        ];

        foreach ($categories as $cat) {
            $createdCat = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description']
                ]
            );

            // Sync existing posts that have string category matching this name
            Post::whereNull('category_id')
                ->where('category', $cat['name'])
                ->update(['category_id' => $createdCat->id]);
        }
    }
}
