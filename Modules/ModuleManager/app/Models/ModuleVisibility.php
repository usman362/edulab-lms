<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleVisibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'is_hidden',
        'is_hidden_from_list',
        'is_hidden_from_search',
        'is_hidden_from_admin',
        'is_hidden_from_user',
        'is_hidden_from_api',
        'is_hidden_from_cli',
        'is_hidden_from_web',
        'is_hidden_from_mobile',
        'is_hidden_from_desktop',
        'is_hidden_from_widget',
        'is_hidden_from_dashboard',
        'is_hidden_from_menu',
        'is_hidden_from_toolbar',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
        'is_hidden_from_list' => 'boolean',
        'is_hidden_from_search' => 'boolean',
        'is_hidden_from_admin' => 'boolean',
        'is_hidden_from_user' => 'boolean',
        'is_hidden_from_api' => 'boolean',
        'is_hidden_from_cli' => 'boolean',
        'is_hidden_from_web' => 'boolean',
        'is_hidden_from_mobile' => 'boolean',
        'is_hidden_from_desktop' => 'boolean',
        'is_hidden_from_widget' => 'boolean',
        'is_hidden_from_dashboard' => 'boolean',
        'is_hidden_from_menu' => 'boolean',
        'is_hidden_from_toolbar' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}