<?php

namespace Modules\LMS\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StorageTenancyService
{
    /**
     * Initialize tenant storage structure.
     * This creates necessary directories for a new tenant.
     * Call this AFTER tenancy is initialized so paths are properly suffixed.
     */
    public static function initializeTenantStorage(): void
    {
        try {
            // When tenancy is initialized, storage_path() is automatically suffixed
            // So these paths will be tenant-specific
            $directories = [
                'app/public',
                'app/public/uploads',
                'app/public/uploads/courses',
                'app/public/uploads/users',
                'app/public/uploads/certificates',
                'app/public/uploads/blogs',
                'app/public/uploads/assignments',
                'app/public/uploads/lectures',
                'framework/cache/data',
                'framework/sessions',
                'framework/views',
                'logs',
            ];

            foreach ($directories as $directory) {
                $path = storage_path($directory);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }
            }
            
            // Create a .gitignore in the tenant storage root
            $gitignorePath = storage_path('.gitignore');
            if (!file_exists($gitignorePath)) {
                File::put($gitignorePath, "*\n!.gitignore\n");
            }

            Log::info('Tenant storage initialized successfully', [
                'storage_path' => storage_path(),
                'directories_created' => count($directories)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to initialize tenant storage', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Copy demo assets from central public storage to tenant storage.
     * This should be called AFTER tenancy is initialized and storage structure is created.
     * 
     * Copies assets from:
     * 1. Modules/LMS/storage/app/public/lms -> tenant storage/app/public (flattened)
     * 2. public/lms (fallback assets) -> tenant storage/app/public (if exists)
     * 
     * The key is to copy the CONTENTS of the lms folder, not the lms folder itself,
     * so the structure matches storage:link pattern properly.
     */
    public static function copyDemoAssets(): void
    {
        try {
            // storage_path() is automatically suffixed by tenancy when initialized
            $tenantStoragePath = storage_path('app/public');
            
            // Ensure tenant storage exists
            if (!file_exists($tenantStoragePath)) {
                File::makeDirectory($tenantStoragePath, 0755, true);
            }

            // 1. Copy from Modules/LMS/storage/app/public/lms (main LMS storage)
            // Copy CONTENTS of lms folder directly to tenant public storage root
            $lmsStoragePath = module_path('LMS', '/storage/app/public/lms');
            if (file_exists($lmsStoragePath)) {
                static::copyDirectoryContents($lmsStoragePath, $tenantStoragePath);
                Log::info('Copied LMS module storage assets', [
                    'from' => $lmsStoragePath,
                    'to' => $tenantStoragePath,
                    'note' => 'Contents copied directly (lms folder flattened)'
                ]);
            }

            // 2. Copy from public/lms (fallback assets)
            // Copy CONTENTS of lms folder directly to tenant public storage root
            $publicLmsPath = public_path('lms');
            if (file_exists($publicLmsPath)) {
                static::copyDirectoryContents($publicLmsPath, $tenantStoragePath);
                Log::info('Copied public fallback assets', [
                    'from' => $publicLmsPath,
                    'to' => $tenantStoragePath,
                    'note' => 'Contents copied directly (lms folder flattened)'
                ]);
            }
            
            Log::info('All demo assets copied successfully', [
                'tenant_storage_root' => storage_path(),
                'final_path' => $tenantStoragePath,
                'structure' => 'Flattened: storage/app/public/{assets} instead of storage/app/public/lms/{assets}'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to copy demo assets', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Recursively copy directory contents from source to destination
     */
    protected static function copyDirectoryContents(string $source, string $destination): void
    {
        if (!file_exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $items = scandir($source);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            
            $sourcePath = $source . DIRECTORY_SEPARATOR . $item;
            $destPath = $destination . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($sourcePath)) {
                // Recursively copy subdirectories
                static::copyDirectoryContents($sourcePath, $destPath);
            } else {
                // Copy file
                File::copy($sourcePath, $destPath);
            }
        }
    }

    /**
     * Create symbolic link for tenant public storage
     * This allows tenant assets to be accessible via web
     */
    public static function createStorageLink(): void
    {
        try {
            $tenantPublicPath = public_path('storage');
            $tenantStoragePath = storage_path('app/public');
            
            // Remove existing symlink if it exists
            if (is_link($tenantPublicPath)) {
                unlink($tenantPublicPath);
            }
            
            // Create new symlink
            if (!file_exists($tenantPublicPath)) {
                symlink($tenantStoragePath, $tenantPublicPath);
                Log::info('Storage symlink created for tenant', [
                    'link' => $tenantPublicPath,
                    'target' => $tenantStoragePath
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create storage symlink', [
                'error' => $e->getMessage()
            ]);
            // Don't throw - symlink creation might fail on some systems
        }
    }

    /**
     * Clean tenant storage (useful for testing or tenant deletion)
     */
    public static function cleanTenantStorage(): void
    {
        $storagePath = storage_path();
        
        if (file_exists($storagePath)) {
            // Only delete if this is actually a tenant storage path (contains 'tenant' in path)
            if (strpos($storagePath, 'tenant') !== false) {
                File::deleteDirectory($storagePath);
                Log::info('Tenant storage cleaned', ['path' => $storagePath]);
            } else {
                Log::warning('Attempted to clean non-tenant storage path', ['path' => $storagePath]);
            }
        }
    }
}
