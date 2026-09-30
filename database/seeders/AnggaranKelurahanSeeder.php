<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnggaranKelurahan;

class AnggaranKelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AnggaranKelurahan::truncate();

        $data2026 = [
            // PENDAPATAN 2026
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'pendapatan',
                'kategori' => 'Pendapatan Transfer',
                'uraian' => 'Alokasi Dana Kelurahan (ADK) Kab. Probolinggo',
                'anggaran' => 750000000,
                'realisasi' => 562500000,
                'keterangan' => 'Pencairan Tahap I dan Tahap II APBD Kabupaten',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'pendapatan',
                'kategori' => 'Pendapatan Transfer',
                'uraian' => 'Bantuan Keuangan Khusus (BKK) Pembangunan Sarpras',
                'anggaran' => 350000000,
                'realisasi' => 350000000,
                'keterangan' => 'Telah terealisasi 100% untuk perbaikan drainase & penerangan',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'pendapatan',
                'kategori' => 'Lain-Lain Pendapatan Sah',
                'uraian' => 'Bagi Hasil Pajak & Retribusi Daerah',
                'anggaran' => 125000000,
                'realisasi' => 95000000,
                'keterangan' => 'Bagi hasil PBB-P2 dan retribusi pasar',
                'is_published' => true,
            ],

            // BELANJA 2026
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'belanja',
                'kategori' => 'Belanja Operasional',
                'uraian' => 'Operasional Kantor Kelurahan & Pelayanan Kependudukan',
                'anggaran' => 220000000,
                'realisasi' => 165000000,
                'keterangan' => 'Belanja ATK, listrik, internet, air, dan honorarium staf teknis',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'belanja',
                'kategori' => 'Belanja Modal / Sarpras',
                'uraian' => 'Pembangunan & Rehabilitasi Drainase RW 02 - RW 04',
                'anggaran' => 450000000,
                'realisasi' => 410000000,
                'keterangan' => 'Pekerjaan fisik beton pracetak saluran air pemukiman',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'belanja',
                'kategori' => 'Pemberdayaan Masyarakat',
                'uraian' => 'Pelatihan UMKM, Pembinaan PKK & Karang Taruna',
                'anggaran' => 180000000,
                'realisasi' => 135000000,
                'keterangan' => 'Pelatihan digital marketing UMKM & insentif kader Posyandu',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'belanja',
                'kategori' => 'Belanja Tak Terduga',
                'uraian' => 'Penanggulangan Bencana & Darurat Kebersihan Lingkungan',
                'anggaran' => 50000000,
                'realisasi' => 22500000,
                'keterangan' => 'Tanggap darurat genangan hujan & fogging DBD',
                'is_published' => true,
            ],

            // PEMBIAYAAN 2026
            [
                'tahun_anggaran' => 2026,
                'jenis' => 'pembiayaan',
                'kategori' => 'Penerimaan Pembiayaan',
                'uraian' => 'Sisa Lebih Perhitungan Anggaran (SILPA) Tahun 2025',
                'anggaran' => 85000000,
                'realisasi' => 85000000,
                'keterangan' => 'SILPA kas kelurahan sisa APBD 2025',
                'is_published' => true,
            ],
        ];

        $data2025 = [
            // PENDAPATAN 2025
            [
                'tahun_anggaran' => 2025,
                'jenis' => 'pendapatan',
                'kategori' => 'Pendapatan Transfer',
                'uraian' => 'Alokasi Dana Kelurahan (ADK) Kab. Probolinggo',
                'anggaran' => 680000000,
                'realisasi' => 680000000,
                'keterangan' => 'Realisasi 100% tuntas',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2025,
                'jenis' => 'pendapatan',
                'kategori' => 'Lain-Lain Pendapatan Sah',
                'uraian' => 'Bagi Hasil Pajak & Retribusi Daerah',
                'anggaran' => 110000000,
                'realisasi' => 108500000,
                'keterangan' => 'Realisasi 98.6%',
                'is_published' => true,
            ],
            // BELANJA 2025
            [
                'tahun_anggaran' => 2025,
                'jenis' => 'belanja',
                'kategori' => 'Belanja Operasional',
                'uraian' => 'Operasional Kantor & Pelayanan Administrasi',
                'anggaran' => 200000000,
                'realisasi' => 198000000,
                'keterangan' => 'Kebutuhan ATK dan rutin pelayanan',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2025,
                'jenis' => 'belanja',
                'kategori' => 'Belanja Modal / Sarpras',
                'uraian' => 'Pengaspalan Jalan Usaha Tani & Pavingisasi Jalan Gang',
                'anggaran' => 420000000,
                'realisasi' => 415500000,
                'keterangan' => 'Pekerjaan selesai 100%',
                'is_published' => true,
            ],
            [
                'tahun_anggaran' => 2025,
                'jenis' => 'belanja',
                'kategori' => 'Pemberdayaan Masyarakat',
                'uraian' => 'Pembinaan Posyandu, Lansia & Penguatan Kelembagaan RT/RW',
                'anggaran' => 150000000,
                'realisasi' => 148500000,
                'keterangan' => 'Realisasi kegiatan pemberdayaan',
                'is_published' => true,
            ],
        ];

        foreach (array_merge($data2026, $data2025) as $item) {
            AnggaranKelurahan::create($item);
        }
    }
}
