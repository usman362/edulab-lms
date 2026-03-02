<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleDependency extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'dependency_name',
        'version_constraint',
        'type',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}