<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing services to reset to standard 12 SOP documents
        DB::table('services')->truncate();

        $sops = [
            [
                'title' => 'Standar Pelayanan Publik Kelurahan',
                'slug' => 'standar-pelayanan-publik-kelurahan',
                'description' => 'Pedoman umum mengenai standar mutu, maklumat pelayanan, hak dan kewajiban masyarakat serta petugas kelurahan dalam penyelenggaraan pelayanan publik.',
                'order' => 1,
            ],
            [
                'title' => 'SOP Pelayanan Surat Keterangan Usaha (SKU)',
                'slug' => 'sop-pelayanan-surat-keterangan-usaha-sku',
                'description' => 'Prosedur operasional standar permohonan dan penerbitan Surat Keterangan Usaha bagi warga untuk keperluan perbankan, izin operasional, atau bantuan modal usaha.',
                'order' => 2,
            ],
            [
                'title' => 'SOP Pelayanan Surat Keterangan Tidak Mampu (SKTM)',
                'slug' => 'sop-pelayanan-surat-keterangan-tidak-mampu-sktm',
                'description' => 'Prosedur permohonan SKTM untuk keperluan keringanan biaya kesehatan (BPJS PBI / Jamkesda), bantuan sosial, dan keringanan biaya pendidikan.',
                'order' => 3,
            ],
            [
                'title' => 'SOP Pelayanan Surat Keterangan Domisili',
                'slug' => 'sop-pelayanan-surat-keterangan-domisili',
                'description' => 'Prosedur penerbitan surat keterangan domisili tempat tinggal bagi warga perseorangan maupun surat domisili yayasan, organisasi, dan badan usaha.',
                'order' => 4,
            ],
            [
                'title' => 'SOP Pelayanan Pengantar Nikah (N1–N4)',
                'slug' => 'sop-pelayanan-pengantar-nikah-n1-n4',
                'description' => 'Tata cara dan persyaratan pengurusan dokumen pengantar nikah (Formulir N1 hingga N4) dari kelurahan menuju Kantor Urusan Agama (KUA).',
                'order' => 5,
            ],
            [
                'title' => 'SOP Pelayanan Pengantar KTP-el & Kartu Keluarga',
                'slug' => 'sop-pelayanan-pengantar-ktp-el-kartu-keluarga',
                'description' => 'Prosedur penerbitan surat pengantar pembuatan, pembaruan, atau penggantian KTP Elektronik dan Kartu Keluarga (KK) yang hilang/rusak.',
                'order' => 6,
            ],
            [
                'title' => 'SOP Pelayanan Surat Keterangan Kelahiran & Kematian',
                'slug' => 'sop-pelayanan-surat-keterangan-kelahiran-kematian',
                'description' => 'Standar operasional penerbitan surat pengantar dan keterangan peristiwa kelahiran maupun kematian warga untuk pengurusan akta di Dispendukcapil.',
                'order' => 7,
            ],
            [
                'title' => 'SOP Pelayanan Pengantar SKCK',
                'slug' => 'sop-pelayanan-pengantar-skck',
                'description' => 'Tata kelola permohonan surat pengantar kelurahan sebagai kelengkapan pembuatan Surat Keterangan Catatan Kepolisian (SKCK) di Polsek/Polres.',
                'order' => 8,
            ],
            [
                'title' => 'SOP Pelayanan Surat Keterangan Pindah / Datang',
                'slug' => 'sop-pelayanan-surat-keterangan-pindah-datang',
                'description' => 'Prosedur administrasi pengantar perpindahan penduduk (Surat Keterangan Pindah WNI / SKPWNI) baik antar desa, kecamatan, kabupaten, maupun provinsi.',
                'order' => 9,
            ],
            [
                'title' => 'SOP Pelayanan Surat Keterangan Belum Menikah / Janda / Duda',
                'slug' => 'sop-pelayanan-surat-keterangan-belum-menikah-janda-duda',
                'description' => 'Prosedur penerbitan surat pernyataan status pernikahan untuk keperluan lamaran kerja, pengajuan kredit perumahan (KPR), atau beasiswa.',
                'order' => 10,
            ],
            [
                'title' => 'SOP Penanganan Pengaduan dan Aspirasi Warga',
                'slug' => 'sop-penanganan-pengaduan-dan-aspirasi-warga',
                'description' => 'Mekanisme penerimaan, pencatatan, tindak lanjut, dan evaluasi pengaduan serta saran/aspirasi masyarakat di Kelurahan Sidomukti.',
                'order' => 11,
            ],
            [
                'title' => 'Alur dan Petunjuk Teknis Permohonan Surat Online',
                'slug' => 'alur-dan-petunjuk-teknis-permohonan-surat-online',
                'description' => 'Panduan alur, syarat kelengkapan berkas, dan petunjuk teknis tahapan pelayanan administrasi persuratan bagi warga Kelurahan Sidomukti.',
                'order' => 12,
            ],
        ];

        foreach ($sops as $sop) {
            Service::create([
                'title' => $sop['title'],
                'slug' => $sop['slug'],
                'description' => $sop['description'],
                'order' => $sop['order'],
                'is_active' => true,
            ]);
        }
    }
}
