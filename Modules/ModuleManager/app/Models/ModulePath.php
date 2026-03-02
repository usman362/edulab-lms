<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePath extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'namespace',
        'path',
        'composer_json_path',
        'config_path',
        'migration_path',
        'route_path',
        'view_path',
        'translation_path',
        'service_provider',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}