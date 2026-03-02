<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleCapability extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'is_installable',
        'is_upgradable',
        'is_removable',
        'is_configurable',
        'is_cacheable',
        'is_loggable',
        'is_monitorable',
        'is_auditable',
        'is_customizable',
        'is_legacy',
        'is_protected',
    ];

    protected $casts = [
        'is_installable' => 'boolean',
        'is_upgradable' => 'boolean',
        'is_removable' => 'boolean',
        'is_configurable' => 'boolean',
        'is_cacheable' => 'boolean',
        'is_loggable' => 'boolean',
        'is_monitorable' => 'boolean',
        'is_auditable' => 'boolean',
        'is_customizable' => 'boolean',
        'is_legacy' => 'boolean',
        'is_protected' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}