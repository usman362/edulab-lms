<?php

namespace Modules\ModuleManager\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ModuleManager\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data array - currently empty
        $newModules = [
            // You would populate this with your module data
            [
                'name' => 'LMS',
                'alias' => 'lms',
                'slug' => 'lms',
                'description' => 'Learning Management System (LMS) module for managing courses, students, and instructors.',
                'providers' => ["Modules\\LMS\\Providers\\LMSServiceProvider"],
                'files' => ["app/Helper/functions.php"],
                'requires' => [],
                'type' => 'core',
                'version' => '1.0.0',
                'author' => 'CodexShaper',
                'email' => 'codexshaper@gmail.com',
                "keywords" => [
                    "lms",
                    "learning management",
                    "courses",
                    "students",
                    "instructors"
                ],
                'status' => 'active',
                'category' => 'education',
                'installed_at' => now(),
                'last_updated_at' => now(),
                'is_core' => true,
                'is_enabled' => true,
                'is_active' => true,
                'is_installed' => true,
            ],
            [
                'name' => 'ModuleManager',
                'alias' => 'modulemanager',
                'slug' => 'modulemanager',
                'description' => 'Manages installation, uninstallation, and purchasing of modules from third-party sources like Envato.',
                'providers' => ["Modules\\ModuleManager\\Providers\\ModuleManagerServiceProvider"],
                'files' => ["app/Helper/functions.php"],
                'requires' => [],
                'type' => 'core',
                'version' => '1.0.0',
                'author' => 'CodexShaper',
                'email' => 'codexshaper@gmail.com',
                "keywords" => [
                    "modules", 
                    "module manager", 
                    "envato", 
                    "marketplace"
                ],
                'status' => 'active',
                'category' => 'manager',
                'installed_at' => now(),
                'last_updated_at' => now(),
                'is_core' => true,
                'is_enabled' => true,
                'is_active' => true,
                'is_installed' => true,
            ],
            [
                'name' => 'Roles',
                'alias' => 'roles',
                'slug' => 'roles',
                'description' => 'Roles and permissions management module for user access control.',
                'providers' => ["Modules\\Roles\\Providers\\RolesServiceProvider"],
                'files' => [],
                'requires' => [],
                'type' => 'core',
                'version' => '1.0.0',
                'author' => 'CodexShaper',
                'email' => 'codexshaper@gmail.com',
                "keywords" => [
                    "roles", 
                    "permissions", 
                    "access control", 
                    "user management"
                ],
                'status' => 'active',
                'category' => 'authentication',
                'installed_at' => now(),
                'last_updated_at' => now(),
                'is_core' => true,
                'is_enabled' => true,
                'is_active' => true,
                'is_installed' => true,
            ],
        ];

        foreach ($newModules as $newModule) {
            // Create new module (name, alias, and slug are required)
            $module = Module::create([
                'name' => $newModule['name'],
                'alias' => $newModule['alias'],
                'slug' => $newModule['slug'],
                'description' => $newModule['description'] ?? null,
                'version' => $newModule['version'] ?? '1.0.0',
                'status' => $newModule['status'] ?? 'inactive',
                'providers' => $newModule['providers'] ?? [],
                'files' => $newModule['files'] ?? [],
                'requires' => $newModule['requires'] ?? [],
                'type' => $newModule['type'] ?? 'feature',
                'category' => $newModule['category'] ?? null,
                'installed_at' => $newModule['installed_at'] ?? null,
                'last_updated_at' => $newModule['last_updated_at'] ?? null,
            ]);

            // Metadata (all fields are nullable except module_id)
            $module->metadata()->create([
                'author' => $newModule['author'] ?? null,
                'author_url' => $newModule['author_url'] ?? null,
                'website' => $newModule['website'] ?? null,
                'priority' => $newModule['priority'] ?? 0,
                'license' => $newModule['license'] ?? null,
                'license_type' => $newModule['license_type'] ?? null,
                'icon' => $newModule['icon'] ?? null,
                'changelog' => $newModule['changelog'] ?? null,
                'notes' => $newModule['notes'] ?? null,
                'metadata' => $newModule['metadata'] ?? null,
            ]);

            // Paths (all fields are nullable except module_id)
            $module->paths()->create([
                'namespace' => $newModule['namespace'] ?? null,
                'path' => $newModule['path'] ?? null,
                'composer_json_path' => $newModule['composer_json_path'] ?? null,
                'config_path' => $newModule['config_path'] ?? null,
                'migration_path' => $newModule['migration_path'] ?? null,
                'route_path' => $newModule['route_path'] ?? null,
                'view_path' => $newModule['view_path'] ?? null,
                'translation_path' => $newModule['translation_path'] ?? null,
                'service_provider' => $newModule['service_provider'] ?? null,
            ]);

            // Customization Paths (all fields are nullable except module_id)
            $module->customizationPaths()->create([
                'customization_path' => $newModule['customization_path'] ?? null,
                'customization_namespace' => $newModule['customization_namespace'] ?? null,
                'customization_config_path' => $newModule['customization_config_path'] ?? null,
                'customization_view_path' => $newModule['customization_view_path'] ?? null,
                'customization_route_path' => $newModule['customization_route_path'] ?? null,
                'customization_translation_path' => $newModule['customization_translation_path'] ?? null,
            ]);

            // Requirements (all fields are nullable except module_id)
            $module->requirements()->create([
                'min_php_version' => $newModule['min_php_version'] ?? null,
                'max_php_version' => $newModule['max_php_version'] ?? null,
                'min_laravel_version' => $newModule['min_laravel_version'] ?? null,
                'max_laravel_version' => $newModule['max_laravel_version'] ?? null,
                'min_core_version' => $newModule['min_core_version'] ?? null,
                'max_core_version' => $newModule['max_core_version'] ?? null,
            ]);

            // Dependencies (dependency_name is required)
            $dependencies = is_string($newModule['dependencies'] ?? null) 
                ? json_decode($newModule['dependencies'], true) 
                : ($newModule['dependencies'] ?? []);
            
            if (!empty($dependencies)) {
                foreach ($dependencies as $name => $constraint) {
                    $module->dependencies()->create([
                        'dependency_name' => $name,
                        'version_constraint' => $constraint ?? null,
                        'type' => 'required',
                    ]);
                }
            }

            // Assets (all fields are nullable except module_id)
            $module->assets()->create([
                'screenshot' => $newModule['screenshot'] ?? null,
                'banner_image' => $newModule['banner_image'] ?? null,
            ]);

            // Support (all fields are nullable except module_id)
            $module->support()->create([
                'homepage_url' => $newModule['homepage_url'] ?? null,
                'repository_url' => $newModule['repository_url'] ?? null,
                'issue_tracker_url' => $newModule['issue_tracker_url'] ?? null,
                'documentation_url' => $newModule['documentation_url'] ?? null,
                'support_email' => $newModule['support_email'] ?? null,
                'support_phone' => $newModule['support_phone'] ?? null,
                'support_url' => $newModule['support_url'] ?? null,
                'update_url' => $newModule['update_url'] ?? null,
            ]);

            // Providers (all fields are nullable except module_id)
            $module->providers()->create([
                'provider_class' => $newModule['provider_class'] ?? null,
                'additional_providers' => $newModule['additional_providers'] ?? null,
                'aliases' => $newModule['aliases'] ?? null,
                'middleware' => $newModule['middleware'] ?? null,
                'route_middleware' => $newModule['route_middleware'] ?? null,
                'migration_files' => $newModule['migration_files'] ?? null,
                'menu_items' => $newModule['menu_items'] ?? null,
            ]);

            // Settings (all fields are nullable except module_id)
            $module->settings()->create([
                'settings' => $newModule['settings'] ?? null,
            ]);

            // Features (boolean fields have schema defaults)
            $module->features()->create([
                'requires_activation' => $newModule['requires_activation'] ?? true,
                'supports_tenancy' => $newModule['supports_tenancy'] ?? false,
                'has_migrations' => $newModule['has_migrations'] ?? false,
                'has_seeds' => $newModule['has_seeds'] ?? false,
                'has_assets' => $newModule['has_assets'] ?? false,
                'has_settings' => $newModule['has_settings'] ?? false,
                'has_admin_settings' => $newModule['has_admin_settings'] ?? false,
                'has_tenant_settings' => $newModule['has_tenant_settings'] ?? false,
                'is_multitenant' => $newModule['is_multitenant'] ?? false,
                'is_translatable' => $newModule['is_translatable'] ?? false,
            ]);

            // Status Flags (boolean fields have schema defaults)
            $module->statusFlags()->create([
                'is_core' => $newModule['is_core'] ?? false,
                'is_enabled' => $newModule['is_enabled'] ?? false,
                'is_active' => $newModule['is_active'] ?? false,
                'is_installed' => $newModule['is_installed'] ?? false,
                'is_deprecated' => $newModule['is_deprecated'] ?? false,
                'is_featured' => $newModule['is_featured'] ?? false,
                'is_beta' => $newModule['is_beta'] ?? false,
                'is_stable' => $newModule['is_stable'] ?? true,
                'is_experimental' => $newModule['is_experimental'] ?? false,
            ]);

            // Capabilities (boolean fields have schema defaults)
            $module->capabilities()->create([
                'is_installable' => $newModule['is_installable'] ?? true,
                'is_upgradable' => $newModule['is_upgradable'] ?? true,
                'is_removable' => $newModule['is_removable'] ?? true,
                'is_configurable' => $newModule['is_configurable'] ?? true,
                'is_cacheable' => $newModule['is_cacheable'] ?? true,
                'is_loggable' => $newModule['is_loggable'] ?? true,
                'is_monitorable' => $newModule['is_monitorable'] ?? true,
                'is_auditable' => $newModule['is_auditable'] ?? true,
                'is_customizable' => $newModule['is_customizable'] ?? false,
                'is_legacy' => $newModule['is_legacy'] ?? false,
                'is_protected' => $newModule['is_protected'] ?? false,
            ]);

            // Visibility (boolean fields have schema defaults)
            $module->visibility()->create([
                'is_hidden' => $newModule['is_hidden'] ?? false,
                'is_hidden_from_list' => $newModule['is_hidden_from_list'] ?? false,
                'is_hidden_from_search' => $newModule['is_hidden_from_search'] ?? false,
                'is_hidden_from_admin' => $newModule['is_hidden_from_admin'] ?? false,
                'is_hidden_from_user' => $newModule['is_hidden_from_user'] ?? false,
                'is_hidden_from_api' => $newModule['is_hidden_from_api'] ?? false,
                'is_hidden_from_cli' => $newModule['is_hidden_from_cli'] ?? false,
                'is_hidden_from_web' => $newModule['is_hidden_from_web'] ?? false,
                'is_hidden_from_mobile' => $newModule['is_hidden_from_mobile'] ?? false,
                'is_hidden_from_desktop' => $newModule['is_hidden_from_desktop'] ?? false,
                'is_hidden_from_widget' => $newModule['is_hidden_from_widget'] ?? false,
                'is_hidden_from_dashboard' => $newModule['is_hidden_from_dashboard'] ?? false,
                'is_hidden_from_menu' => $newModule['is_hidden_from_menu'] ?? false,
                'is_hidden_from_toolbar' => $newModule['is_hidden_from_toolbar'] ?? false,
            ]);
        }
    }
}
