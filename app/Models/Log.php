<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'task_id',
        'action'
    ];

    public function task()
{
    return $this->belongsTo(\App\Models\Task::class);
}
}
