<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'action'
    ];

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
