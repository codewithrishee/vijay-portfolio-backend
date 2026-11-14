<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreloaderSetting extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'location',
        'is_enabled',
        'duration',
        'background_color',
        'text_color',
        'progress_color',
        'percentage_color',
        'logo',
        'show_logo',
        'logo_size',
        'animation_style',
        'animation_speed',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'show_logo' => 'boolean',
    ];
}