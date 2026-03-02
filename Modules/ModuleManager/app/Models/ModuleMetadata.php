<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'author',
        'author_url',
        'website',
        'priority',
        'license',
        'license_type',
        'icon',
        'changelog',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'priority' => 'integer',
        'metadata' => 'array',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}