<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    /**
     * Catat log aktivitas ke dalam database.
     *
     * @param string $action LOGIN, LOGOUT, CREATE, UPDATE, DELETE, UPDATE_STATUS, etc.
     * @param string $module Nama modul / fitur
     * @param string $description Deskripsi aktivitas secara ramah manusia
     * @param array|null $properties Data tambahan/meta
     * @param mixed $user Optional user override
     */
    public static function log(string $action, string $module, string $description, ?array $properties = null, $user = null): void
    {
        try {
            $currentUser = $user ?? Auth::user();

            $userName = $currentUser ? $currentUser->name : 'Sistem / Guest';
            $userRole = $currentUser ? ($currentUser->role ?? 'user') : 'guest';
            $userId = $currentUser ? $currentUser->id : null;

            ActivityLog::create([
                'user_id' => $userId,
                'user_name' => $userName,
                'user_role' => $userRole,
                'action' => strtoupper($action),
                'module' => $module,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'properties' => $properties,
            ]);
        } catch (\Throwable $e) {
            // Jangan menghentikan proses utama jika gagal mencatat log
            Log::error('ActivityLogger Error: ' . $e->getMessage());
        }
    }
}
