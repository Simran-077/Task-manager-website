<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by'
    ];

    // Team creator (admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Team members
    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}