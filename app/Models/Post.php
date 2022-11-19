<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    // 並び替え
    const SORT_NEW_ARRIVALS = 1;
    const SORT_VIEW_RANK = 2;
    const SORT_LIST = [
        self::SORT_NEW_ARRIVALS => '新着',
        self::SORT_VIEW_RANK => '人気',
    ];

    protected $fillable = [
        // 'title',
        // 'occupation_id',
        // 'due_date',
        // 'is_published',
        'item_id',
        'situation_id',
        'genre_id'
        // 'advisor_id',

    ];

    public function scopeMyJobOffer(Builder $query, $params)
    {
        if (Auth::user()->can('advisor')) {
            $query->latest()
                ->with(['entries', 'occupation'])
                ->where('advisor_id', Auth::user()->advisor->id)
                ->where('is_published', $params['is_published'] ?? self::STATUS_OPEN);
        } else {
            $query->latest()
                ->with(['entries', 'occupation'])
                ->whereHas('entries', function ($query) use ($params) {
                    $query->where('user_id', Auth::user()->id);
                });
        }

        return $query;
    }



    public function scopePublished(Builder $query)
    {
        $query->where('is_published', true)
            ->where('due_date', '>=', now());
        return $query;
    }

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

    public function situation()
    {
        return $this->belongsTo(\App\Models\Situation::class);
    }

    public function scopeSearch(Builder $query, $params)
    {
        if (!empty($params['genre_post_id'])) {
            $query->where('genre_post_id', $params['_id']);
        }

        return $query;
    }
}
