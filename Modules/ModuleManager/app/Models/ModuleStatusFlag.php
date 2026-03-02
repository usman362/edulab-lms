<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleStatusFlag extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'is_core',
        'is_enabled',
        'is_active',
        'is_installed',
        'is_deprecated',
        'is_featured',
        'is_beta',
        'is_stable',
        'is_experimental',
    ];

    protected $casts = [
        'is_core' => 'boolean',
        'is_enabled' => 'boolean',
        'is_active' => 'boolean',
        'is_installed' => 'boolean',
        'is_deprecated' => 'boolean',
        'is_featured' => 'boolean',
        'is_beta' => 'boolean',
        'is_stable' => 'boolean',
        'is_experimental' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}