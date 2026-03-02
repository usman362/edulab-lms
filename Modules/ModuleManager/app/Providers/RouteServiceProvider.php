<?php

namespace Modules\ModuleManager\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ModuleManager';

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
        // $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        $webMiddleware = \Modules\LMS\Providers\TenantAwareMiddlewareProvider::getTenantWebMiddleware();
        Route::middleware($webMiddleware)->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        $apiMiddleware = \Modules\LMS\Providers\TenantAwareMiddlewareProvider::getTenantApiMiddleware();
        Route::middleware($apiMiddleware)->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
