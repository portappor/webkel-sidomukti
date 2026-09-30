<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Lembaga;
use App\Models\Post;
use App\Models\RukunWarga;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard overview
     */
    public function index()
    {
        if (class_exists(\App\Models\Agenda::class)) { \App\Models\Agenda::cleanupExpired(); }

        // 1. Real KPI Metrics Data
        $sopCount = Schema::hasTable('services') ? Service::count() : 0;
        $sopActiveCount = Schema::hasTable('services') ? Service::where('is_active', true)->count() : 0;

        $docPublikCount = Schema::hasTable('documents') ? Document::count() : 0;
        $lembagaCount = Schema::hasTable('lembagas') ? Lembaga::count() : 0;

        $totalBerita = Schema::hasTable('posts') ? Post::count() : 0;
        $totalAgenda = Schema::hasTable('agendas') ? Agenda::count() : 0;
        $totalBeritaAgenda = $totalBerita + $totalAgenda;

        $stats = [
            'total_sop' => $sopCount,
            'active_sop' => $sopActiveCount,
            'total_dokumen' => $docPublikCount,
            'total_lembaga' => $lembagaCount,
            'total_berita' => $totalBerita,
            'total_agenda' => $totalAgenda,
            'total_berita_agenda' => $totalBeritaAgenda,
        ];

        // 2. Upcoming / Recent Agendas
        $upcomingAgendas = collect();
        if (Schema::hasTable('agendas')) {
            $upcomingAgendas = Agenda::orderBy('date', 'desc')->take(5)->get();
        }

        // 3. Real SOP Services List
        $servicesList = collect();
        if (Schema::hasTable('services')) {
            $servicesList = Service::where('is_active', true)->orderBy('order', 'asc')->get();
        }

        // 4. Real Demographics Data from Settings & RukunWarga
        $settings = Setting::pluck('value', 'key')->toArray();

        $totalPenduduk = (int) ($settings['demografi_total'] ?? $settings['jumlah_penduduk'] ?? 2776);
        $totalKk = (int) ($settings['demografi_kk'] ?? 850);
        $totalLaki = (int) ($settings['demografi_laki'] ?? 1402);
        $totalPerempuan = (int) ($settings['demografi_perempuan'] ?? 1374);
        $totalRt = (int) ($settings['demografi_jumlah_rt'] ?? 17);

        $totalRwInDb = Schema::hasTable('rukun_wargas') ? RukunWarga::count() : 0;
        $totalRw = $totalRwInDb > 0 ? $totalRwInDb : (int) ($settings['demografi_jumlah_rw'] ?? 6);

        $pctLaki = $totalPenduduk > 0 ? round(($totalLaki / $totalPenduduk) * 100, 1) : 50.5;
        $pctPerempuan = $totalPenduduk > 0 ? round(($totalPerempuan / $totalPenduduk) * 100, 1) : 49.5;

        $demographics = [
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKk,
            'laki_laki' => $totalLaki,
            'perempuan' => $totalPerempuan,
            'pct_laki' => $pctLaki,
            'pct_perempuan' => $pctPerempuan,
            'total_rt' => $totalRt,
            'total_rw' => $totalRw,
        ];

        return view('dashboard.index', compact('stats', 'upcomingAgendas', 'servicesList', 'demographics'));
    }
}
