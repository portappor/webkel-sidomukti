<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Tampilkan halaman Log Aktivitas dengan filter & statistik
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // 1. Filter Pencarian Teks
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%");
            });
        }

        // 2. Filter Peran (Role)
        if ($request->filled('role')) {
            $query->where('user_role', $request->role);
        }

        // 3. Filter Pengguna Spesifik
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // 4. Filter Modul
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // 5. Filter Jenis Aksi
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // 6. Filter Rentang Tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Ringkasan Statistik Log
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', Carbon::today())->count();
        $adminLogs = ActivityLog::where('user_role', 'admin')->count();
        $staffLogs = ActivityLog::where('user_role', 'staf')->count();

        // Data opsi untuk dropdown filter
        $usersList = User::orderBy('name')->get(['id', 'name', 'role']);
        $modulesList = [
            'Autentikasi', 'Pengguna', 'Berita', 'Pengumuman', 'Dokumen',
            'Agenda', 'Layanan', 'Galeri', 'Pengaduan', 'Pengaturan',
            'Data RT/RW', 'Lembaga', 'Kategori', 'Transparansi'
        ];
        $actionsList = ['LOGIN', 'LOGOUT', 'CREATE', 'UPDATE', 'DELETE', 'UPDATE_STATUS'];

        $logs = $query->paginate(20)->withQueryString();

        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            $tableHtml = view('dashboard.activity-logs.partials.table_body', compact('logs'))->render();
            $paginationHtml = $logs->hasPages() ? $logs->links()->render() : '';

            return response()->json([
                'table_html' => $tableHtml,
                'pagination_html' => $paginationHtml,
                'stats' => [
                    'totalLogs' => number_format($totalLogs),
                    'todayLogs' => number_format($todayLogs),
                    'adminLogs' => number_format($adminLogs),
                    'staffLogs' => number_format($staffLogs),
                ]
            ]);
        }

        return view('dashboard.activity-logs.index', compact(
            'logs',
            'totalLogs',
            'todayLogs',
            'adminLogs',
            'staffLogs',
            'usersList',
            'modulesList',
            'actionsList'
        ));
    }

    /**
     * Bersihkan / hapus log lama (Khusus Admin)
     */
    public function clear(Request $request)
    {
        $days = (int) $request->input('days', 30);

        if ($days === 0) {
            $deletedCount = ActivityLog::count();
            ActivityLog::truncate();
            $msg = "Seluruh log aktivitas ({$deletedCount} data) berhasil dibersihkan.";
        } else {
            $cutoffDate = Carbon::now()->subDays($days);
            $deletedCount = ActivityLog::where('created_at', '<', $cutoffDate)->delete();
            $msg = "Log aktivitas yang lebih lama dari {$days} hari ({$deletedCount} data) berhasil dibersihkan.";
        }

        ActivityLogger::log('DELETE', 'Log Aktivitas', $msg);

        return redirect()->route('dashboard.activity-logs.index')->with('success', $msg);
    }
}
