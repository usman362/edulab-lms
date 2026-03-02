<?php

namespace Modules\ModuleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'alias',
        'slug',
        'description',
        'version',
        'status',
        'type',
        'providers',
        'files',
        'requires',
        'keywords',
        'category',
        'installed_at',
        'last_updated_at',
    ];

    protected $casts = [
        'installed_at' => 'datetime',
        'last_updated_at' => 'datetime',
        'providers' => 'array',
        'files' => 'array',
        'requires' => 'array',
        'keywords' => 'array',
    ];

    // Relationships
    public function metadata()
    {
        return $this->hasOne(ModuleMetadata::class);
    }

    public function paths()
    {
        return $this->hasOne(ModulePath::class);
    }

    public function customizationPaths()
    {
        return $this->hasOne(ModuleCustomizationPath::class);
    }

    public function requirements()
    {
        return $this->hasOne(ModuleRequirement::class);
    }

    public function dependencies()
    {
        return $this->hasMany(ModuleDependency::class);
    }

    public function assets()
    {
        return $this->hasOne(ModuleAsset::class);
    }

    public function support()
    {
        return $this->hasOne(ModuleSupport::class);
    }

    public function providers()
    {
        return $this->hasOne(ModuleProvider::class);
    }

    public function settings()
    {
        return $this->hasOne(ModuleSetting::class);
    }

    public function features()
    {
        return $this->hasOne(ModuleFeature::class);
    }

    public function statusFlags()
    {
        return $this->hasOne(ModuleStatusFlag::class);
    }

    public function capabilities()
    {
        return $this->hasOne(ModuleCapability::class);
    }

    public function visibility()
    {
        return $this->hasOne(ModuleVisibility::class);
    }

    // Accessor to get complete module data (for backward compatibility)
    public function getCompleteAttribute()
    {
        return array_merge(
            $this->toArray(),
            $this->metadata ? $this->metadata->toArray() : [],
            $this->paths ? $this->paths->toArray() : [],
            $this->customizationPaths ? $this->customizationPaths->toArray() : [],
            $this->requirements ? $this->requirements->toArray() : [],
            $this->assets ? $this->assets->toArray() : [],
            $this->support ? $this->support->toArray() : [],
            $this->providers ? $this->providers->toArray() : [],
            $this->settings ? $this->settings->toArray() : [],
            $this->features ? $this->features->toArray() : [],
            $this->statusFlags ? $this->statusFlags->toArray() : [],
            $this->capabilities ? $this->capabilities->toArray() : [],
            $this->visibility ? $this->visibility->toArray() : []
        );
    }
}