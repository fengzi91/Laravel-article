<?php

namespace App\Models;

class Tag extends Model
{
    protected $fillable = ['name', 'description', 'view_count', 'order', 'slug'];

    /**
     * 获得标签下的话题
     * @return [type] [description]
     */
    public function topics()
    {
      return $this->belongsToMany(Topic::class);
    }
}
