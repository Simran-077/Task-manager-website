<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'show_email',
        'show_phone',
        'notify_email',
        'notify_sms',
        'notify_call',
        'role',
        'theme'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function teams()
    {
        return $this->belongsToMany(\App\Models\Team::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function canSeeInfoOf(User $user)
    {
        // Admin can always see
        if ($this->isAdmin()) return true;
        
        // Users can see their own info
        if ($this->id === $user->id) return true;

        return false;
    }

    public function getVisibleEmail(User $viewer)
    {
        if ($viewer->isAdmin() || $this->show_email || $viewer->id === $this->id) {
            return $this->email;
        }
        return 'Private';
    }

    public function getVisiblePhone(User $viewer)
    {
        if ($viewer->isAdmin() || $this->show_phone || $viewer->id === $this->id) {
            return $this->phone ?? 'Not set';
        }
        return 'Private';
    }
}

