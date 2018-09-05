<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'excerpt', 'slug'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 定义话题与标签的关联
    public function tags()
    {
      return $this->belongsToMany(Tag::class);
    }

    // 话题与回复的关联
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
