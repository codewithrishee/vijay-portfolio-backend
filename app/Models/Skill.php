<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
    'name',
    'category',
    'description',
    'icon',
    'icon_type',
    'image',
    'color',
    'is_active',
    'sort_order',
];
}
