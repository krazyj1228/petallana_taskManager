<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'status'])]
class Task extends Model
{
    protected $casts = [
        'completed_at' => 'datetime',
    ];
}