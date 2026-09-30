<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use Illuminate\Support\Str;

$defaultCategories = [
    // BERITA
    ['module' => 'berita', 'name' => 'Pemerintahan', 'slug' => 'pemerintahan', 'description' => 'Kategori berita kebijakan dan pemerintahan kelurahan.', 'color' => 'emerald', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'berita', 'name' => 'Masyarakat', 'slug' => 'masyarakat', 'description' => 'Kategori berita seputar kegiatan warga.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'berita', 'name' => 'Kesehatan', 'slug' => 'kesehatan', 'description' => 'Kategori berita posyandu dan kesehatan.', 'color' => 'rose', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'berita', 'name' => 'Pembangunan', 'slug' => 'pembangunan', 'description' => 'Informasi proyek infrastruktur dan pembangunan.', 'color' => 'amber', 'order' => 4, 'status' => 'aktif'],
    ['module' => 'berita', 'name' => 'Pemberdayaan', 'slug' => 'pemberdayaan', 'description' => 'Program pelatihan, UMKM, dan pemberdayaan warga.', 'color' => 'purple', 'order' => 5, 'status' => 'aktif'],
    ['module' => 'berita', 'name' => 'Informasi Umum', 'slug' => 'informasi-umum', 'description' => 'Kabar umum dan edukasi publik untuk seluruh warga.', 'color' => 'cyan', 'order' => 6, 'status' => 'aktif'],

    // PENGUMUMAN
    ['module' => 'pengumuman', 'name' => 'Penting & Mendesak', 'slug' => 'penting-mendesak', 'description' => 'Pengumuman darurat, siaga bencana, atau kabar penting kelurahan.', 'color' => 'rose', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'pengumuman', 'name' => 'Layanan Publik', 'slug' => 'layanan-publik', 'description' => 'Pengumuman jadwal jam operasional dan perubahan pelayanan publik.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'pengumuman', 'name' => 'Kegiatan Warga', 'slug' => 'kegiatan-warga', 'description' => 'Pengumuman kerja bakti, musyawarah, dan festival warga.', 'color' => 'emerald', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'pengumuman', 'name' => 'Penyaluran Bantuan', 'slug' => 'penyaluran-bantuan', 'description' => 'Pengumuman alokasi & jadwal penyaluran bansos, BLT, PKH.', 'color' => 'amber', 'order' => 4, 'status' => 'aktif'],

    // LAYANAN (SOP)
    ['module' => 'layanan', 'name' => 'Kependudukan', 'slug' => 'kependudukan', 'description' => 'Layanan administrasi kartu keluarga, KTP, dan domisili.', 'color' => 'emerald', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'layanan', 'name' => 'Keterangan', 'slug' => 'keterangan', 'description' => 'Surat keterangan kelakuan baik, belum menikah, domisili usaha.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'layanan', 'name' => 'Perizinan & Usaha', 'slug' => 'perizinan-usaha', 'description' => 'Surat pengantar izin usaha mikro, IMB, dan perizinan.', 'color' => 'amber', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'layanan', 'name' => 'Pertanahan', 'slug' => 'pertanahan', 'description' => 'Layanan rekomendasi pertanahan & riwayat kepemilikan tanah.', 'color' => 'purple', 'order' => 4, 'status' => 'aktif'],
    ['module' => 'layanan', 'name' => 'Kesejahteraan Sosial', 'slug' => 'kesejahteraan-sosial', 'description' => 'Pengurusan SKTM dan rekomendasi bantuan sosial.', 'color' => 'rose', 'order' => 5, 'status' => 'aktif'],

    // GALERI FOTO
    ['module' => 'galeri', 'name' => 'Pemerintahan', 'slug' => 'galeri-pemerintahan', 'description' => 'Dokumentasi kegiatan dinas dan aparatur kelurahan.', 'color' => 'emerald', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Pelayanan', 'slug' => 'galeri-pelayanan', 'description' => 'Dokumentasi pelayanan tatap muka & masyarakat.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Kesehatan', 'slug' => 'galeri-kesehatan', 'description' => 'Dokumentasi posyandu dan bakti kesehatan.', 'color' => 'rose', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Kemasyarakatan', 'slug' => 'galeri-kemasyarakatan', 'description' => 'Dokumentasi gotong royong dan kemasyarakatan.', 'color' => 'amber', 'order' => 4, 'status' => 'aktif'],
    ['module' => 'galeri', 'name' => 'Sosial', 'slug' => 'galeri-sosial', 'description' => 'Dokumentasi kegiatan penyaluran bantuan sosial.', 'color' => 'purple', 'order' => 5, 'status' => 'aktif'],

    // LEMBAGA
    ['module' => 'lembaga', 'name' => 'Kemasyarakatan', 'slug' => 'lembaga-kemasyarakatan', 'description' => 'Lembaga kemasyarakatan kelurahan (LPMK, PKK, Karang Taruna).', 'color' => 'indigo', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'lembaga', 'name' => 'Kepemudaan', 'slug' => 'lembaga-kepemudaan', 'description' => 'Organisasi pemuda dan keolahragaan kelurahan.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'lembaga', 'name' => 'Keagamaan', 'slug' => 'lembaga-keagamaan', 'description' => 'Takmir masjid, majelis taklim, dan keagamaan.', 'color' => 'emerald', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'lembaga', 'name' => 'Keamanan', 'slug' => 'lembaga-keamanan', 'description' => 'Linmas dan Satkamling warga kelurahan.', 'color' => 'rose', 'order' => 4, 'status' => 'aktif'],
    ['module' => 'lembaga', 'name' => 'Posyandu & Kesehatan', 'slug' => 'lembaga-kesehatan', 'description' => 'Kader posyandu & lansia kelurahan.', 'color' => 'amber', 'order' => 5, 'status' => 'aktif'],

    // TRANSPARANSI
    ['module' => 'transparansi', 'name' => 'APBD / Realisasi', 'slug' => 'transparansi-apbd', 'description' => 'Laporan realisasi anggaran pendapatan dan belanja kelurahan.', 'color' => 'cyan', 'order' => 1, 'status' => 'aktif'],
    ['module' => 'transparansi', 'name' => 'Musrenbang', 'slug' => 'transparansi-musrenbang', 'description' => 'Dokumen usulan dan hasil kesepakatan musrenbang.', 'color' => 'blue', 'order' => 2, 'status' => 'aktif'],
    ['module' => 'transparansi', 'name' => 'Renstra & Renja', 'slug' => 'transparansi-renstra', 'description' => 'Rencana strategis & rencana kerja kelurahan.', 'color' => 'emerald', 'order' => 3, 'status' => 'aktif'],
    ['module' => 'transparansi', 'name' => 'Laporan Kinerja', 'slug' => 'transparansi-kinerja', 'description' => 'Laporan akuntabilitas kinerja instansi kelurahan.', 'color' => 'purple', 'order' => 4, 'status' => 'aktif'],
];

foreach ($defaultCategories as $data) {
    Category::updateOrCreate(
        ['slug' => $data['slug']],
        $data
    );
}

echo "Successfully seeded module categories. Total: " . Category::count() . "\n";
