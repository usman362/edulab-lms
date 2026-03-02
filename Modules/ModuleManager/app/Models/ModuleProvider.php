<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'provider_class',
        'additional_providers',
        'aliases',
        'middleware',
        'route_middleware',
        'migration_files',
        'menu_items',
    ];

    protected $casts = [
        'additional_providers' => 'json',
        'aliases' => 'json',
        'middleware' => 'json',
        'route_middleware' => 'json',
        'migration_files' => 'json',
        'menu_items' => 'json',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}