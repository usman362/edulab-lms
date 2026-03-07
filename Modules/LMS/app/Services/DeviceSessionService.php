<?php

namespace Modules\LMS\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DeviceSessionService
{
    /**
     * Get max devices per user from backend settings (1 or 2).
     */
    public static function getMaxDevices(): int
    {
        $settings = get_theme_option(key: 'backend_general') ?? [];
        $max = (int) ($settings['max_devices_per_user'] ?? 2);
        return $max >= 1 && $max <= 10 ? $max : 2;
    }

    /**
     * Register or update current session for the user. If over limit, remove oldest session.
     */
    public static function registerSession(int $userId): void
    {
        $sessionId = Session::getId();
        $max = self::getMaxDevices();

        $exists = DB::table('device_sessions')
            ->where('user_id', $userId)
            ->where('session_id', $sessionId)
            ->exists();

        if ($exists) {
            DB::table('device_sessions')
                ->where('user_id', $userId)
                ->where('session_id', $sessionId)
                ->update([
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'last_activity' => now(),
                ]);
            return;
        }

        $count = DB::table('device_sessions')->where('user_id', $userId)->count();
        while ($count >= $max) {
            $oldest = DB::table('device_sessions')
                ->where('user_id', $userId)
                ->orderBy('last_activity')
                ->first();
            if (!$oldest) {
                break;
            }
            DB::table('device_sessions')->where('id', $oldest->id)->delete();
            $sessionTable = config('session.table', 'sessions');
            DB::table($sessionTable)->where('id', $oldest->session_id)->delete();
            $count--;
        }

        DB::table('device_sessions')->insert([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'last_activity' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Check if current session is allowed for this user. Returns true if allowed.
     */
    public static function isSessionAllowed(int $userId): bool
    {
        $sessionId = Session::getId();
        return DB::table('device_sessions')
            ->where('user_id', $userId)
            ->where('session_id', $sessionId)
            ->exists();
    }

    /**
     * Update last activity for current session.
     */
    public static function touchSession(int $userId): void
    {
        DB::table('device_sessions')
            ->where('user_id', $userId)
            ->where('session_id', Session::getId())
            ->update(['last_activity' => now()]);
    }

    /**
     * Remove current session from device_sessions (e.g. on logout).
     */
    public static function removeCurrentSession(int $userId): void
    {
        DB::table('device_sessions')
            ->where('user_id', $userId)
            ->where('session_id', Session::getId())
            ->delete();
    }
}
