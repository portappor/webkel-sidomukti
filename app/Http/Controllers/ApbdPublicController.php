<?php

namespace App\Http\Controllers;

use App\Models\Apbd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApbdPublicController extends Controller
{
    /**
     * Halaman Utama Publik Transparansi Anggaran (Daftar APBD)
     */
    public function index(Request $request)
    {
        $apbds = Apbd::where('is_published', true)
            ->orderBy('year', 'desc')
            ->get();

        return view('public.apbd.index', compact('apbds'));
    }

    /**
     * Halaman Detail Publik Transparansi Anggaran
     */
    public function show($id)
    {
        $apbd = Apbd::with('items')->where('is_published', true)->findOrFail($id);

        $pendapatanItems = $apbd->items->where('jenis', 'pendapatan');
        $belanjaItems = $apbd->items->where('jenis', 'belanja');
        $pembiayaanItems = $apbd->items->where('jenis', 'pembiayaan');

        $pendapatanGrouped = $pendapatanItems->groupBy('kategori');
        $belanjaGrouped = $belanjaItems->groupBy('kategori');
        $pembiayaanGrouped = $pembiayaanItems->groupBy('kategori');

        $totalPendapatanAnggaran = $pendapatanItems->sum('anggaran');
        $totalPendapatanRealisasi = $pendapatanItems->sum('realisasi');

        $totalBelanjaAnggaran = $belanjaItems->sum('anggaran');
        $totalBelanjaRealisasi = $belanjaItems->sum('realisasi');

        $totalPembiayaanAnggaran = $pembiayaanItems->sum('anggaran');
        $totalPembiayaanRealisasi = $pembiayaanItems->sum('realisasi');

        $surplusDefisitAnggaran = $totalPendapatanAnggaran - $totalBelanjaAnggaran;
        $surplusDefisitRealisasi = $totalPendapatanRealisasi - $totalBelanjaRealisasi;

        $silpaRealisasi = $surplusDefisitRealisasi + $totalPembiayaanRealisasi;

        return view('public.apbd.show', compact(
            'apbd',
            'pendapatanItems',
            'belanjaItems',
            'pembiayaanItems',
            'pendapatanGrouped',
            'belanjaGrouped',
            'pembiayaanGrouped',
            'totalPendapatanAnggaran',
            'totalPendapatanRealisasi',
            'totalBelanjaAnggaran',
            'totalBelanjaRealisasi',
            'totalPembiayaanAnggaran',
            'totalPembiayaanRealisasi',
            'surplusDefisitAnggaran',
            'surplusDefisitRealisasi',
            'silpaRealisasi'
        ));
    }

    /**
     * Unduh Berkas PDF Laporan Pertanggungjawaban
     */
    public function downloadPdf($id)
    {
        $apbd = Apbd::where('is_published', true)->findOrFail($id);

        if (!$apbd->document) {
            return redirect()->back()->with('error', 'Berkas PDF laporan pertanggungjawaban belum diunggah.');
        }

        if (\Illuminate\Support\Str::startsWith($apbd->document, ['http://', 'https://'])) {
            return redirect()->away($apbd->document);
        }

        if (Storage::disk('public')->exists($apbd->document)) {
            $filename = 'Laporan-APBD-' . $apbd->year . '.pdf';
            return Storage::disk('public')->download($apbd->document, $filename);
        }

        return redirect()->back()->with('error', 'Berkas PDF laporan tidak ditemukan di server.');
    }
}
