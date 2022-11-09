<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LDAP\Result;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function advisor()
    {
        return $this->hasOne(\App\Models\Adovisor::class);
    }


    public function request()
    {
        return $this->hasMany(Result::class);
    }

    public function message()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
