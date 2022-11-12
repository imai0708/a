<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // ステータス
    const STATUS_CLOSE = 0;
    const STATUS_OPEN = 1;
    const STATUS_LIST = [
        self::STATUS_CLOSE => '未公開',
        self::STATUS_OPEN => '公開',
    ];

    protected $fillable = [
        'title',
        'occupation_id',
        'due_date',
        'description',
        'is_published',
    ];

    public function advisor()
    {
        return $this->belongsTo(\App\Models\Advisor::class);
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorites::class);
    }

    public function genres()
    {
        return $this->belongsToMany(\App\Models\Genre::class);
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\Item::class);
    }

    public function situations()
    {
        return $this->belongsTo(\App\Models\Situation::class);
    }
}
