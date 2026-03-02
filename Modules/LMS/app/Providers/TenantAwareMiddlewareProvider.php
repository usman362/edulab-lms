<?php

namespace Modules\LMS\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Foundation\Configuration\Middleware as MiddlewareConfig;

class TenantAwareMiddlewareProvider extends ServiceProvider
{
    /**
     * Get tenant middleware array for routes
     * Returns ['universal'] if SaaS enabled
     * Returns [] if SaaS disabled
     * 
     * @return array
     */
    public static function getUniversalMiddleware(): array
    {
        $middleware = [];
        
        // Check if SaaS module is enabled
        if (self::isSaaSEnabled()) {
            // Universal routes work on both central and tenant domains
            $middleware[] = 'universal';
            $centralDomain = env('CENTRAL_DOMAIN', 'localhost');
            $is_central_domain = request()->getHost() === $centralDomain;

            if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class) && !$is_central_domain) {
                $middleware[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
            }
        }

        return $middleware;
    }

    /**
     * Get tenant middleware array for routes
     * Returns [InitializeTenancyByDomain, PreventAccessFromCentralDomains] if SaaS enabled
     * Returns [] if SaaS disabled
     * 
     * @return array
     */
    public static function getTenantAwareMiddleware($preventCentralDomains = true): array
    {
        $middleware = [];

        // Check if SaaS module is enabled
        if (self::isSaaSEnabled()) {
            // Per stancl/tenancy docs: 'web', InitializeTenancyByDomain, PreventAccessFromCentralDomains
            // Since 'web' is added first, we return the tenant middleware in correct order
            if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class)) {
                $middleware[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
            }
            
            if (class_exists(\Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class) && $preventCentralDomains) {
                $middleware[] = \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class;
            }
        }

         // Add web and bootstrap
        $middleware[] = 'web';
        $middleware[] = 'bootstrap';

        return $middleware;
    }

    /**
     * Get tenant middleware array for routes
     * Returns [web, bootstrap, InitializeTenancyByDomain, PreventAccessFromCentralDomains] if SaaS enabled
     * Returns ['web', 'bootstrap'] if SaaS disabled
     * 
     * @return array
     */
    public static function getTenantWebMiddleware(): array
    {
        $middleware = ['web', 'bootstrap'];

        // Check if SaaS module is enabled
        if (self::isSaaSEnabled()) {
            // Per stancl/tenancy docs: 'web', InitializeTenancyByDomain, PreventAccessFromCentralDomains
            // Since 'web' is added first, we return the tenant middleware in correct order
            if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class)) {
                $middleware[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
            }
            
            if (class_exists(\Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class)) {
                $middleware[] = \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class;
            }
        }

        return $middleware;
    }

    /**
     * Get tenant middleware array for routes
     * Returns [api, bootstrap, InitializeTenancyByDomain, PreventAccessFromCentralDomains] if SaaS enabled
     * Returns ['api', 'bootstrap'] if SaaS disabled
     * 
     * @return array
     */
    public static function getTenantApiMiddleware(): array
    {
        $middleware = ['api', 'bootstrap'];

        // Check if SaaS module is enabled
        if (self::isSaaSEnabled()) {
            // CRITICAL ORDER: InitializeTenancyByDomain MUST come before PreventAccessFromCentralDomains
            if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class)) {
                $middleware[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
            }
            
            if (class_exists(\Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class)) {
                $middleware[] = \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class;
            }
        }

        return $middleware;
    }

    /**
     * Check if SaaS module is enabled
     * 
     * @return bool
     */
    protected static function isSaaSEnabled(): bool
    {
        if (!class_exists(\Modules\SaaS\Services\SaaSManager::class)) {
            return false;
        }

        try {
            $saasManager = app(\Modules\SaaS\Services\SaaSManager::class);
            return $saasManager->isEnabled();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Register tenant-aware middleware group centrally
     * 
     * This group contains ONLY the tenant initialization middleware.
     * Use it in routes by combining with other groups: ['tenant-aware', 'web', 'bootstrap']
     * 
     * CRITICAL: tenant-aware MUST be listed BEFORE 'web' group in routes
     * to ensure tenancy initializes before sessions/CSRF tokens
     */
    public static function registerTenantAwareMiddlewareGroup(MiddlewareConfig $middleware): void
    {
        $tenantMiddleware = [];

        // Check if SaaS module is installed, enabled, and licensed
        if (class_exists(\Modules\SaaS\Services\SaaSManager::class)) {
            try {
                $saasManager = app(\Modules\SaaS\Services\SaaSManager::class);
                
                // Only add tenant middleware if SaaS is properly enabled with valid license
                if ($saasManager->isEnabled()) {
                    // Use stancl/tenancy middleware directly - proper order is critical:
                    // 1. InitializeTenancyByDomain MUST come first to set tenant context
                    // 2. PreventAccessFromCentralDomains comes second
                    if (class_exists(\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class)) {
                        $tenantMiddleware[] = \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class;
                    }
                    
                    if (class_exists(\Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class)) {
                        $tenantMiddleware[] = \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class;
                    }
                }
            } catch (\Exception $e) {
                // If error checking SaaS status, don't register tenant middleware
            }
        }

        // Register tenant-aware group - contains ONLY tenant initialization middleware
        // Use in routes: Route::middleware(['tenant-aware', 'web'])->group(...)
        $middleware->group('tenant-aware', $tenantMiddleware);
    }
}