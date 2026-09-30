<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partnership;

class PartnershipSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'PT Pegadaian (Persero) Area Probolinggo',
                'category' => 'BUMN / BUMD',
                'logo' => 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?auto=format&fit=crop&w=300&q=80',
                'description' => 'Kerjasama Program Pemberdayaan Ekonomi & Literasi Keuangan Warga Sidomukti.',
                'website' => 'https://www.pegadaian.co.id',
                'contact_person' => 'Bpk. Hendra Wijaya',
                'phone' => '081234567890',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Puskesmas Kraksaan',
                'category' => 'Instansi Pemerintah',
                'logo' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=300&q=80',
                'description' => 'Kemitraan Layanan Kesehatan Masyarakat, Posyandu Lansia & Balita, dan Cegah Stunting.',
                'website' => 'https://dinkes.probolinggokab.go.id',
                'contact_person' => 'dr. Siti Aminah',
                'phone' => '082198765432',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Universitas Panca Marga Probolinggo',
                'category' => 'Pendidikan',
                'logo' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=300&q=80',
                'description' => 'Program Kuliah Kerja Nyata (KKN) Tematik Pengabdian Masyarakat & Digitalisasi UMKM.',
                'website' => 'https://www.upm.ac.id',
                'contact_person' => 'Prof. Dr. Rahmat Hidayat',
                'phone' => '085712349876',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Bank Jatim Cabang Kraksaan',
                'category' => 'BUMN / BUMD',
                'logo' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=300&q=80',
                'description' => 'Dukungan Program QRIS UMKM Kelurahan & Pembayaran PBB-P2 Nontunai.',
                'website' => 'https://www.bankjatim.co.id',
                'contact_person' => 'Ibu Nurtjahjani',
                'phone' => '081333444555',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($partners as $partner) {
            Partnership::updateOrCreate(['name' => $partner['name']], $partner);
        }
    }
}
