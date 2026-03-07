<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\LMS\Services\DeviceSessionService;
use Symfony\Component\HttpFoundation\Response;

class EnforceDeviceLimit
{
    /**
     * Handle an incoming request. Apply device limit only to students (web guard).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();
        if (!$user || $user->guard !== 'student') {
            return $next($request);
        }

        $userId = $user->id;

        if (DeviceSessionService::isSessionAllowed($userId)) {
            DeviceSessionService::touchSession($userId);
            return $next($request);
        }

        $max = DeviceSessionService::getMaxDevices();
        $count = \DB::table('device_sessions')->where('user_id', $userId)->count();
        if ($count < $max) {
            DeviceSessionService::registerSession($userId);
            return $next($request);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => translate('Maximum number of devices reached. Please log out from another device.'),
            ], 403);
        }

        return redirect()->route('login')
            ->with('error', translate('Maximum number of devices reached. Please log out from another device.'));
    }
}
