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
    'color',
    'is_active',
    'sort_order',
];
}
