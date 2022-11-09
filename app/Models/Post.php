<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function advisor()
    {
        return $this->belongsTo(\App\Models\Advisor::class);
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorites::class);
    }

    public function genre()
    {
        return $this->hasMany(\App\Models\Genre::class);
    }

    public function item()
    {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function situations()
    {
        return $this->belongsTo(\App\Models\Situation::class);
    }
}
