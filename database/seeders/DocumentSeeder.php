<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            [
                'title' => 'Berita Acara Musrenbang Kelurahan Tahun 2026',
                'category' => 'musrenbang',
                'description' => 'Berita acara resmi hasil kesepakatan Musyawarah Perencanaan Pembangunan Kelurahan Sidomukti.',
                'file_name' => 'BA-Musrenbang-Sidomukti-2026.pdf',
                'file_path' => 'documents/BA-Musrenbang-Sidomukti-2026.pdf',
                'file_size' => '2.4 MB',
                'published_date' => '2026-01-15',
                'status' => 'Disahkan',
            ],
            [
                'title' => 'Rekapitulasi Prioritas Usulan RW Sidomukti',
                'category' => 'musrenbang',
                'description' => 'Daftar rekapitulasi usulan fisik infrastruktur dan pemberdayaan masyarakat dari RW 01 - RW 06.',
                'file_name' => 'Rekap-Usulan-RW-Sidomukti.pdf',
                'file_path' => 'documents/Rekap-Usulan-RW-Sidomukti.pdf',
                'file_size' => '1.8 MB',
                'published_date' => '2026-01-18',
                'status' => 'Terverifikasi',
            ],
            [
                'title' => 'Rencana Strategis (Renstra) Kelurahan Sidomukti 2024-2029',
                'category' => 'renstra_renja',
                'description' => 'Dokumen perencanaan jangka menengah memuat visi, misi, tujuan, dan program 5 tahun.',
                'file_name' => 'Renstra-Kelurahan-Sidomukti-2024-2029.pdf',
                'file_path' => 'documents/Renstra-Kelurahan-Sidomukti-2024-2029.pdf',
                'file_size' => '4.5 MB',
                'published_date' => '2024-08-05',
                'status' => 'Disahkan',
            ],
            [
                'title' => 'Rencana Kerja Tahunan (Renja) Kelurahan Sidomukti Tahun 2026',
                'category' => 'renstra_renja',
                'description' => 'Dokumen perencanaan tahunan kelurahan yang menjabarkan target kinerja tahun 2026.',
                'file_name' => 'Renja-Kelurahan-Sidomukti-2026.pdf',
                'file_path' => 'documents/Renja-Kelurahan-Sidomukti-2026.pdf',
                'file_size' => '3.2 MB',
                'published_date' => '2025-12-10',
                'status' => 'Disahkan',
            ],
            [
                'title' => 'SK Kepengurusan RT / RW Periode 2025-2030',
                'category' => 'sk_kelembagaan',
                'description' => 'SK Lurah No: 188/04/426.115/2025 tentang Penetapan Pengurus RT dan RW se-Kelurahan Sidomukti.',
                'file_name' => 'SK-Kepengurusan-RTRW-Sidomukti.pdf',
                'file_path' => 'documents/SK-Kepengurusan-RTRW-Sidomukti.pdf',
                'file_size' => '2.6 MB',
                'published_date' => '2025-01-02',
                'status' => 'Disahkan',
                'organization' => 'RT / RW',
            ],
            [
                'title' => 'SK Tim Penggerak PKK Kelurahan Sidomukti',
                'category' => 'sk_kelembagaan',
                'description' => 'SK Lurah No: 188/08/426.115/2025 tentang Pengangkatan TP-PKK Kelurahan Sidomukti.',
                'file_name' => 'SK-TP-PKK-Sidomukti-2025.pdf',
                'file_path' => 'documents/SK-TP-PKK-Sidomukti-2025.pdf',
                'file_size' => '1.9 MB',
                'published_date' => '2025-01-10',
                'status' => 'Disahkan',
                'organization' => 'TP-PKK',
            ],
        ];

        foreach ($documents as $doc) {
            Document::firstOrCreate(['title' => $doc['title']], $doc);
        }
    }
}
