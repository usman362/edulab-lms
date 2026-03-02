<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleCustomizationPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'customization_path',
        'customization_namespace',
        'customization_config_path',
        'customization_view_path',
        'customization_route_path',
        'customization_translation_path',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}