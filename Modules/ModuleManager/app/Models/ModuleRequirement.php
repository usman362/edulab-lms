<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'min_php_version',
        'max_php_version',
        'min_laravel_version',
        'max_laravel_version',
        'min_core_version',
        'max_core_version',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}