<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'screenshot',
        'banner_image',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}