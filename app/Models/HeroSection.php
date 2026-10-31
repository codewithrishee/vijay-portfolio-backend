<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'name',
        'eyebrow',
        'role_prefix',
        'role_suffix',
        'technologies',
        'heading_line_1',
        'heading_line_2',
        'roles',
        'description',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'github_url',
        'linkedin_url',
        'experience_value',
        'experience_label',
        'technology_count',
        'technology_label',
        'project_count',
        'project_label',
        'availability_text',
        'availability_label',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'roles' => 'array',
            'is_active' => 'boolean',
        ];
    }
}