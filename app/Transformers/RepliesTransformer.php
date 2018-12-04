<?php

namespace App\Transformers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;
use Carbon;

class RepliesTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];
    public function transform(Reply $reply)
    {
        return [
            'id' => $reply->id,
            'content' => $reply->content,
            'updated_at' => $reply->updated_at->diffForHumans(),
            'created_at' => $reply->created_at->diffForHumans(),
        ];
    }
    public function includeUser(Reply $reply)
    {
        return $this->item($reply->user, new UserTransformer());
    }
}