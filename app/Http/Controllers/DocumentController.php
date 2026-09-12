<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Halaman Dokumen Musrenbang
     */
    public function musrenbang()
    {
        $dbDocs = Document::where('category', 'musrenbang')->latest()->get();

        if ($dbDocs->count() > 0) {
            $documents = $dbDocs->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'description' => $doc->description,
                    'file_name' => $doc->file_name,
                    'file_size' => $doc->file_size,
                    'date' => $doc->published_date ? $doc->published_date->translatedFormat('d M Y') : $doc->created_at->translatedFormat('d M Y'),
                    'year' => $doc->published_date ? $doc->published_date->format('Y') : $doc->created_at->format('Y'),
                    'category' => 'Berita Acara',
                    'status' => $doc->status ?? 'Disahkan',
                    'download_url' => route('documents.download', $doc->id),
                ];
            })->toArray();
        } else {
            $documents = [
                [
                    'id' => 0,
                    'title' => 'Berita Acara Musrenbang Kelurahan Tahun 2026',
                    'description' => 'Berita acara resmi hasil kesepakatan Musyawarah Perencanaan Pembangunan Kelurahan Sidomukti untuk usulan prioritas APBD 2026.',
                    'file_name' => 'BA-Musrenbang-Sidomukti-2026.pdf',
                    'file_size' => '2.4 MB',
                    'date' => '15 Jan 2026',
                    'year' => '2026',
                    'category' => 'Berita Acara',
                    'status' => 'Disahkan',
                    'download_url' => '#',
                ],
                [
                    'id' => 0,
                    'title' => 'Rekapitulasi Prioritas Usulan RW Sidomukti',
                    'description' => 'Daftar rekapitulasi usulan fisik infrastruktur dan pemberdayaan masyarakat dari RW 01 hingga RW 06 Kelurahan Sidomukti.',
                    'file_name' => 'Rekap-Usulan-RW-Sidomukti.pdf',
                    'file_size' => '1.8 MB',
                    'date' => '18 Jan 2026',
                    'year' => '2026',
                    'category' => 'Rekapitulasi Usulan',
                    'status' => 'Terverifikasi',
                    'download_url' => '#',
                ],
            ];
        }

        return view('documents.musrenbang', compact('documents'));
    }

    /**
     * Halaman Renstra & Renja
     */
    public function renstraRenja()
    {
        $dbDocs = Document::where('category', 'renstra_renja')->latest()->get();

        if ($dbDocs->count() > 0) {
            $renstraList = $dbDocs->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'period' => 'Tahun ' . ($doc->published_date ? $doc->published_date->format('Y') : $doc->created_at->format('Y')),
                    'description' => $doc->description,
                    'file_name' => $doc->file_name,
                    'file_size' => $doc->file_size,
                    'date' => $doc->published_date ? $doc->published_date->translatedFormat('d M Y') : $doc->created_at->translatedFormat('d M Y'),
                    'category' => 'Dokumen Perencanaan',
                    'badge' => 'Resmi',
                    'download_url' => route('documents.download', $doc->id),
                ];
            })->toArray();
        } else {
            $renstraList = [
                [
                    'id' => 0,
                    'title' => 'Rencana Strategis (Renstra) Kelurahan Sidomukti',
                    'period' => 'Periode 5 Tahunan (2024 - 2029)',
                    'description' => 'Dokumen perencanaan jangka menengah yang memuat visi, misi, tujuan, sasaran, strategi, dan kebijakan pembangunan kelurahan selama 5 tahun.',
                    'file_name' => 'Renstra-Kelurahan-Sidomukti-2024-2029.pdf',
                    'file_size' => '4.5 MB',
                    'date' => '05 Agu 2024',
                    'category' => 'Renstra',
                    'badge' => '5 Tahunan',
                    'download_url' => '#',
                ],
                [
                    'id' => 0,
                    'title' => 'Rencana Kerja Tahunan (Renja) Kelurahan Sidomukti Tahun 2026',
                    'period' => 'Tahun Anggaran 2026 (Berjalan)',
                    'description' => 'Dokumen perencanaan tahunan kelurahan yang menjabarkan target kinerja, program prioritas, dan alokasi kegiatan untuk tahun 2026.',
                    'file_name' => 'Renja-Kelurahan-Sidomukti-2026.pdf',
                    'file_size' => '3.2 MB',
                    'date' => '10 Des 2025',
                    'category' => 'Renja',
                    'badge' => 'Tahun 2026',
                    'download_url' => '#',
                ],
            ];
        }

        return view('documents.renstra_renja', compact('renstraList'));
    }

    /**
     * Halaman SK Kelembagaan
     */
    public function skKelembagaan()
    {
        $dbDocs = Document::where('category', 'sk_kelembagaan')->latest()->get();

        if ($dbDocs->count() > 0) {
            $skList = $dbDocs->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'sk_number' => 'SK Resmi Kelurahan',
                    'period' => 'Berlaku Berjalan',
                    'description' => $doc->description,
                    'file_name' => $doc->file_name,
                    'file_size' => $doc->file_size,
                    'date' => $doc->published_date ? $doc->published_date->translatedFormat('d M Y') : $doc->created_at->translatedFormat('d M Y'),
                    'organization' => $doc->organization ?? 'Lembaga Kelurahan',
                    'theme' => 'emerald',
                    'download_url' => route('documents.download', $doc->id),
                ];
            })->toArray();
        } else {
            $skList = [
                [
                    'id' => 0,
                    'title' => 'SK Kepengurusan RT / RW Periode Berjalan',
                    'sk_number' => 'SK Lurah No: 188/04/426.115/2025',
                    'period' => 'Masa Bakti: 2025 - 2030',
                    'description' => 'Keputusan Lurah Sidomukti tentang Penetapan dan Pengesahan Pengurus Rukun Tetangga (RT) dan Rukun Warga (RW) se-Kelurahan Sidomukti.',
                    'file_name' => 'SK-Kepengurusan-RTRW-Sidomukti.pdf',
                    'file_size' => '2.6 MB',
                    'date' => '02 Jan 2025',
                    'organization' => 'RT / RW',
                    'theme' => 'blue',
                    'download_url' => '#',
                ],
            ];
        }

        return view('documents.sk_kelembagaan', compact('skList'));
    }

    /**
     * Download Berkas PDF Public
     */
    public function download(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        if (filter_var($document->file_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($document->file_path);
        }

        return redirect()->back()->with('error', 'Dokumen PDF belum diunggah atau tidak ditemukan.');
    }
}
