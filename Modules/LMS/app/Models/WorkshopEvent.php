<?php

namespace Modules\LMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkshopEvent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'page',
        'title',
        'image',
        'video_url',
        'description',
        'event_date',
        'location',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'status'     => 'boolean',
    ];
}
