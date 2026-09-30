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

        $apbdCategories = [
            ['name' => 'Pendapatan Transfer', 'slug' => 'pendapatan-transfer', 'module' => 'apbd', 'description' => 'Alokasi Dana Kelurahan (ADK) & Bantuan Keuangan Khusus'],
            ['name' => 'Lain-Lain Pendapatan Sah', 'slug' => 'lain-lain-pendapatan-sah', 'module' => 'apbd', 'description' => 'Bagi hasil pajak dan retribusi daerah'],
            ['name' => 'Belanja Operasional', 'slug' => 'belanja-operasional', 'module' => 'apbd', 'description' => 'Operasional pelayanan, ATK, listrik, dan honorarium'],
            ['name' => 'Belanja Modal / Sarpras', 'slug' => 'belanja-modal-sarpras', 'module' => 'apbd', 'description' => 'Pembangunan drainase, pengaspalan, & infrastruktur'],
            ['name' => 'Pemberdayaan Masyarakat', 'slug' => 'pemberdayaan-masyarakat', 'module' => 'apbd', 'description' => 'Pelatihan UMKM, pembinaan PKK, & Karang Taruna'],
            ['name' => 'Belanja Tak Terduga', 'slug' => 'belanja-tak-terduga', 'module' => 'apbd', 'description' => 'Tanggap darurat bencana & kebersihan'],
            ['name' => 'Penerimaan Pembiayaan', 'slug' => 'penerimaan-pembiayaan', 'module' => 'apbd', 'description' => 'SILPA kas kelurahan tahun sebelumnya'],
        ];

        foreach ($apbdCategories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'module' => $cat['module'],
                    'description' => $cat['description'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}
