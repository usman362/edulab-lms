<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleSupport extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'homepage_url',
        'repository_url',
        'issue_tracker_url',
        'documentation_url',
        'support_email',
        'support_phone',
        'support_url',
        'update_url',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}