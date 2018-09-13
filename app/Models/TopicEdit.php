<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicEdit extends Model
{

    protected $fillable = ['reason', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 每一份编辑存档，对应一个话题（梗）
    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }
}
