<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function creating(Reply $reply)
    {
      $reply->topic->increment('reply_count', 1);
      // $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);

        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
    }
}