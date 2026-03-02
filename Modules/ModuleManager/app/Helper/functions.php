<?php

if (!function_exists('module_is_active')) {
    /**
     * Check if a module is active/enabled
     * 
     * @param string $moduleName Module name to check
     * @return bool
     */
    function module_is_active(string $moduleName): bool
    {
        try {
            // Check modules_statuses.json
            $statusPath = base_path('modules_statuses.json');
            
            if (!file_exists($statusPath)) {
                return false;
            }
            
            $modulesStatus = json_decode(file_get_contents($statusPath), true);
            
            return isset($modulesStatus[$moduleName]) && $modulesStatus[$moduleName] === true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to check module status', [
                'module' => $moduleName,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
