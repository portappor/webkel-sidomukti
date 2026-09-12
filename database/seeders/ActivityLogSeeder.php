<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivityLogSeeder extends Seeder
{
    /**
     * Seed database dengan log aktivitas historis lengkap
     */
    public function run(): void
    {
        // Ambil admin & staf utama jika ada, atau buat data dummy pelaksana
        $adminUser = User::where('role', 'admin')->first();
        $staffUser = User::where('role', 'staf')->first();

        $adminId = $adminUser ? $adminUser->id : 1;
        $adminName = $adminUser ? $adminUser->name : 'Super Admin Kelurahan';

        $staffId = $staffUser ? $staffUser->id : 2;
        $staffName = $staffUser ? $staffUser->name : 'Budi Santoso (Staf Operator)';

        $logsData = [
            // --- HARI INI ---
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'LOGIN',
                'module' => 'Autentikasi',
                'description' => 'User berhasil melakukan login ke dashboard admin.',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
                'properties' => ['browser' => 'Chrome 128', 'os' => 'Windows 10'],
                'created_at' => Carbon::now()->subMinutes(15),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'UPDATE_STATUS',
                'module' => 'Pengaduan',
                'description' => "Mengubah status pengaduan warga #12 dari 'pending' menjadi 'processing'",
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0',
                'properties' => ['complaint_id' => 12, 'old_status' => 'pending', 'new_status' => 'processing'],
                'created_at' => Carbon::now()->subMinutes(45),
            ],
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'CREATE',
                'module' => 'Berita',
                'description' => 'Menambahkan berita baru: "Penyaluran Bantuan Pangan Beras Tahap III Kelurahan Sidomukti"',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0',
                'properties' => ['post_id' => 105, 'category' => 'Kegiatan Desa', 'status' => 'published'],
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'CREATE',
                'module' => 'Agenda',
                'description' => 'Menambahkan agenda kegiatan: "Gotong Royong Kebersihan Lingkungan RW 03"',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0',
                'properties' => ['agenda_id' => 44, 'date' => Carbon::now()->addDays(2)->format('Y-m-d')],
                'created_at' => Carbon::now()->subHours(3),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'LOGIN',
                'module' => 'Autentikasi',
                'description' => 'User staf berhasil melakukan login ke sistem.',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0',
                'properties' => ['login_type' => 'manual'],
                'created_at' => Carbon::now()->subHours(4),
            ],

            // --- KEMARIN (H-1) ---
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'CREATE',
                'module' => 'Pengguna',
                'description' => 'Menambahkan akun staf operator baru: "Siti Rahma (siti@sidomukti.desa.id)"',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/127.0.0.0',
                'properties' => ['new_user_id' => 3, 'role' => 'staf'],
                'created_at' => Carbon::now()->subDay()->setTime(16, 20),
            ],
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'UPDATE',
                'module' => 'Pengaturan',
                'description' => 'Mengubah pengaturan Profil Kelurahan (Foto Lurah & Struktur Aparatur)',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/127.0.0.0',
                'properties' => ['fields' => ['foto_lurah', 'kadin_photo']],
                'created_at' => Carbon::now()->subDay()->setTime(14, 10),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'CREATE',
                'module' => 'Dokumen',
                'description' => 'Mengunggah dokumen PDF baru: "Laporan-Realisasi-Anggaran-Triwulan-II.pdf"',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['category' => 'renstra_renja', 'file_size' => '3.4 MB'],
                'created_at' => Carbon::now()->subDay()->setTime(11, 30),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'UPDATE_STATUS',
                'module' => 'Pengaduan',
                'description' => "Mengubah status pengaduan warga #10 dari 'processing' menjadi 'resolved'",
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['complaint_id' => 10, 'resolution' => 'Lampu jalan telah diperbaiki tim teknis'],
                'created_at' => Carbon::now()->subDay()->setTime(9, 45),
            ],

            // --- 2 HARI LALU (H-2) ---
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'CREATE',
                'module' => 'Layanan',
                'description' => 'Menambahkan Standar Layanan / SOP baru: "SOP Surat Keterangan Usaha (SKU)"',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['service_id' => 8, 'title' => 'SOP Surat Keterangan Usaha'],
                'created_at' => Carbon::now()->subDays(2)->setTime(15, 05),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'CREATE',
                'module' => 'Galeri',
                'description' => 'Mengunggah foto kegiatan: "Dokumentasi Pembagian Sembako Murah"',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['gallery_id' => 18, 'items_count' => 1],
                'created_at' => Carbon::now()->subDays(2)->setTime(13, 20),
            ],
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'UPDATE',
                'module' => 'Data RT/RW',
                'description' => 'Mengubah data statistik wilayah RW 04 Kelurahan Sidomukti',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['rw_id' => 4, 'nama_rw' => 'RW 04', 'jumlah_rt' => 6],
                'created_at' => Carbon::now()->subDays(2)->setTime(10, 15),
            ],

            // --- 3 HARI LALU (H-3) ---
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'CREATE',
                'module' => 'Pengumuman',
                'description' => 'Menambahkan pengumuman publik: "Himbauan Pelunasan PBB-P2 Tahun 2026"',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['announcement_id' => 12, 'is_active' => true],
                'created_at' => Carbon::now()->subDays(3)->setTime(14, 40),
            ],
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'UPDATE',
                'module' => 'Lembaga',
                'description' => 'Mengubah susunan pengurus Lembaga Pemberdayaan Masyarakat Kelurahan (LPMK)',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['lembaga_id' => 3, 'name' => 'LPMK Sidomukti'],
                'created_at' => Carbon::now()->subDays(3)->setTime(11, 00),
            ],

            // --- 5 HARI LALU (H-5) ---
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'CREATE',
                'module' => 'Transparansi',
                'description' => 'Menambahkan transparansi anggaran APBD/APBDes Tahun 2026',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['year' => 2026, 'pendapatan' => 1250000000, 'belanja' => 1200000000],
                'created_at' => Carbon::now()->subDays(5)->setTime(16, 00),
            ],
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'CREATE',
                'module' => 'Kategori',
                'description' => 'Menambahkan kategori berita baru: "Kesehatan & Posyandu"',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['category_id' => 7, 'name' => 'Kesehatan & Posyandu'],
                'created_at' => Carbon::now()->subDays(5)->setTime(9, 30),
            ],

            // --- 1 MINGGU LALU (H-7) ---
            [
                'user_id' => $staffId,
                'user_name' => $staffName,
                'user_role' => 'staf',
                'action' => 'DELETE',
                'module' => 'Berita',
                'description' => 'Menghapus berita draft lama: "Uji Coba Pengumuman Kelurahan"',
                'ip_address' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['deleted_post_title' => 'Uji Coba Pengumuman Kelurahan'],
                'created_at' => Carbon::now()->subDays(7)->setTime(13, 15),
            ],
            [
                'user_id' => $adminId,
                'user_name' => $adminName,
                'user_role' => 'admin',
                'action' => 'LOGOUT',
                'module' => 'Autentikasi',
                'description' => 'User admin melakukan logout dari sistem.',
                'ip_address' => '192.168.1.10',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'properties' => ['session_duration' => '4 hours 20 mins'],
                'created_at' => Carbon::now()->subDays(7)->setTime(17, 00),
            ],
        ];

        foreach ($logsData as $log) {
            ActivityLog::create($log);
        }
    }
}
