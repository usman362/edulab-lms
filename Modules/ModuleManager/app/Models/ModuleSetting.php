<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'settings',
    ];

    protected $casts = [
        'settings' => 'json',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}