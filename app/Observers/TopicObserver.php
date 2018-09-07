<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    public function saving(Topic $topic)
    {
        //dd($topic);
        $topic->excerpt = make_excerpt($topic->body);

        // 给body加上内部链接
        // 获得所有标题信息
        
        $topic->body = make_link($topic->body);
        $topic->body = clean($topic->body, 'user_topic_body');
    }
    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}