<?php

namespace App\Models;

use Markdown;

class Topic extends Model
{
    use Traits\TopicAutoAddLinkHelper;

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

    // 话题的排序
    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'tags');
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    // 话题的链接
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id], $params));
    }

    // 话题自动添加标签
    public function autoTag($tags)
    {
        $ids = [];
        if(count($tags)) {
            
            foreach($tags as $tag) {
                $t = Tag::where('name', $tag)->first();
                if(!$t) {
                   $ids[] = Tag::insertGetId(['name' => $tag, 'description' => $tag]);
                } else {
                    $ids[] = $t->id;
                }
            }
        }
        return $ids;
    }

    public function getBodyAttribute($value)
    {
        return $value;
    }
}
