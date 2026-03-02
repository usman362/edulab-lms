<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'requires_activation',
        'supports_tenancy',
        'has_migrations',
        'has_seeds',
        'has_assets',
        'has_settings',
        'has_admin_settings',
        'has_tenant_settings',
        'is_multitenant',
        'is_translatable',
    ];

    protected $casts = [
        'requires_activation' => 'boolean',
        'supports_tenancy' => 'boolean',
        'has_migrations' => 'boolean',
        'has_seeds' => 'boolean',
        'has_assets' => 'boolean',
        'has_settings' => 'boolean',
        'has_admin_settings' => 'boolean',
        'has_tenant_settings' => 'boolean',
        'is_multitenant' => 'boolean',
        'is_translatable' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}