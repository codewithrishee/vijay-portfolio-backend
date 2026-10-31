<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'name',
        'location',
        'image',
        'education',
        'education_description',
        'profile_technologies',
        'section_number',
        'heading',
        'paragraph_1',
        'paragraph_2',
        'paragraph_3',
        'looking_for',
        'availability',
        'technologies',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}