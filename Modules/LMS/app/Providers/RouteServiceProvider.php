<?php

namespace Modules\LMS\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {

        $middlewares = ['web', 'bootstrap'];

        $universalMiddlewares = array_merge(
            $middlewares,
            \Modules\LMS\Providers\TenantAwareMiddlewareProvider::getUniversalMiddleware(),
        );

        Route::middleware($universalMiddlewares)->group(module_path('LMS', 'routes/universal.php'));

        $webMiddlewares = \Modules\LMS\Providers\TenantAwareMiddlewareProvider::getTenantWebMiddleware();
        
        Route::middleware($webMiddlewares)->group(module_path('LMS', 'routes/web.php'));
        Route::middleware($webMiddlewares)->group(module_path('LMS', 'routes/admin.php'));
        Route::middleware($webMiddlewares)->group(module_path('LMS', 'routes/instructor.php'));
        Route::middleware($webMiddlewares)->group(module_path('LMS', 'routes/student.php'));
        Route::middleware($webMiddlewares)->group(module_path('LMS', 'routes/organization.php'));
    }
}
