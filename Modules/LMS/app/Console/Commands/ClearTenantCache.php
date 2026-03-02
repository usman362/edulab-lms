<?php

namespace Modules\LMS\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\SaaS\Models\Tenant;

class ClearTenantCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:cache-clear 
                            {tenant? : The tenant ID to clear cache for (optional, clears all if not provided)}
                            {--all : Clear cache for all tenants}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache for specific tenant or all tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant');
        $clearAll = $this->option('all');

        if ($clearAll || !$tenantId) {
            $this->clearAllTenants();
        } else {
            $this->clearSingleTenant($tenantId);
        }

        return Command::SUCCESS;
    }

    /**
     * Clear cache for all tenants
     */
    protected function clearAllTenants(): void
    {
        $this->info('Clearing cache for all tenants...');
        
        $tenants = Tenant::all();
        
        if ($tenants->isEmpty()) {
            $this->warn('No tenants found.');
            return;
        }

        $bar = $this->output->createProgressBar($tenants->count());
        $bar->start();

        $cleared = 0;
        $tenancy = app(\Stancl\Tenancy\Tenancy::class);
        $centralConnection = config('database.default');
        
        foreach ($tenants as $tenant) {
            $tenancy->initialize($tenant);
            
            // Clear Laravel cache
            Cache::flush();
            
            // Clear specific options cache
            Cache::forget('options');
            
            // Clear translations cache
            $languages = \Modules\LMS\Models\Language::all();
            foreach ($languages as $language) {
                Cache::forget("translations-{$language->code}");
            }
            
            $tenancy->end();
            $cleared++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Cache cleared for {$cleared} tenant(s)");
        
        // Also clear central cache
        $this->info('Clearing central cache...');
        
        // Restore cache config to central context
        config([
            'cache.stores.database.connection' => $centralConnection,
        ]);
        
        // Clear cache driver and connections
        Cache::forgetDriver('database');
        Cache::clearResolvedInstances();
        DB::purge('tenant');
        
        // Now clear central cache
        Cache::flush();
        $this->info('✅ Central cache cleared');
    }

    /**
     * Clear cache for a single tenant
     */
    protected function clearSingleTenant(string $tenantId): void
    {
        $tenant = Tenant::find($tenantId);
        
        if (!$tenant) {
            $this->error("Tenant '{$tenantId}' not found.");
            return;
        }

        $this->info("Clearing cache for tenant: {$tenant->id}");
        
        $tenancy = app(\Stancl\Tenancy\Tenancy::class);
        $centralConnection = config('database.default');
        
        $tenancy->initialize($tenant);
        
        // Clear Laravel cache
        Cache::flush();
        
        // Clear specific options cache
        Cache::forget('options');
        
        // Clear translations cache
        $languages = \Modules\LMS\Models\Language::all();
        foreach ($languages as $language) {
            Cache::forget("translations-{$language->code}");
        }
        
        $tenancy->end();
        
        // Restore cache config to central context
        config([
            'cache.stores.database.connection' => $centralConnection,
        ]);
        
        // Clear cache driver and connections
        Cache::forgetDriver('database');
        Cache::clearResolvedInstances();
        DB::purge('tenant');
        
        $this->info("✅ Cache cleared for tenant: {$tenant->id}");
    }
}
