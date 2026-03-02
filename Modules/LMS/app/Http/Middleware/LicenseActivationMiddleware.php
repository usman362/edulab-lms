<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Modules\LMS\Models\General\ThemeSetting;

class LicenseActivationMiddleware
{
    /**
     * Handle an incoming request.
     * Check license activation before allowing access
     * 
     * License is ALWAYS checked from central/master database,
     * never from tenant database
     */
    public function handle($request, Closure $next)
    {
        try {
            // Always check license from central DB, even in tenant context
            $centralConnection = config('tenancy.database.central_connection', config('database.default'));
            
            $license = ThemeSetting::on($centralConnection)
                ->where('key', 'license')
                ->first();
            
            if (!$license) {
                return Redirect::route('license.verify.form')
                    ->with('error', 'License not found');
            }
            
            // ThemeSetting casts content to array
            $licenseData = $license->content;
            
            // Handle case where content might still be JSON string
            if (is_string($licenseData)) {
                $licenseData = json_decode($licenseData, true) ?? [];
            }
            
            $status = $licenseData['status'] ?? false;
            
            if ($status !== true) {
                return Redirect::route('license.verify.form')
                    ->with('error', 'License not active');
            }
            
            return $next($request);
        } catch (\Exception $e) {
            // If there's any error fetching license (e.g., table doesn't exist yet)
            // Log it and redirect to license form
            \Illuminate\Support\Facades\Log::warning('License check failed', [
                'error' => $e->getMessage(),
                'tenant' => function_exists('tenant') ? tenant('id') : null
            ]);
            
            return Redirect::route('license.verify.form')
                ->with('error', 'License verification required');
        }
    }
}
