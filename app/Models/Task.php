<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   protected $fillable = [
    'title',
    'description',
    'assigned_to',
    'created_by',
    'deadline',
    'status',
    'team_id',
    'priority'
];

public function assignedUser()
{
    return $this->belongsTo(\App\Models\User::class, 'assigned_to');
}

public function team()
{
    return $this->belongsTo(\App\Models\Team::class);
}

public function comments()
{
    return $this->hasMany(\App\Models\Comment::class);
}
}


