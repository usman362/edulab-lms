<?php

use Illuminate\Support\Facades\Route;
use Modules\LMS\Http\Controllers\Frontend\HomeController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

/*
|--------------------------------------------------------------------------
| Universal Routes - Work on both Central and Tenant domains
|--------------------------------------------------------------------------
|
| These routes work on BOTH central and tenant domains.
| - On tenant domain: Tenancy is initialized, shows tenant content
| - On central domain: No tenancy, shows central content
|
| Use tenancy()->initialized in controller to check context.
|
*/

Route::middleware(['checkInstaller'])
    ->controller(HomeController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home.index');
    });