<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    const STATUS_ENTRY = 0;
    const STATUS_APPROVAL = 1;
    const STATUS_REJECT = 2;
    const STATUS_LIST = [
        self::STATUS_ENTRY => '依頼中',
        self::STATUS_APPROVAL => '承認',
        self::STATUS_REJECT => '却下',
    ];

    protected $fillable = [
        'advisor_id',
        'user_id'
    ];

    protected $table = 'requests';

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getStatusValueAttribute()
    {
        // self::STATUS_LIST で'エントリー中''承認','却下'の値を持ってくる

        return self::STATUS_LIST[$this->status];
    }
}
