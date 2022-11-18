<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasProfilePhoto;

class Advisor extends Model
{
    use HasFactory;
    // use HasProfilePhoto;

    protected $fillable = [
        'user_id',
        'name',
        'profile',
        'profile_image'

    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = [
    //     'profile_photo_url',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Request()
    {
        return $this->hasMany(Request::class);
    }

    public function message()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
