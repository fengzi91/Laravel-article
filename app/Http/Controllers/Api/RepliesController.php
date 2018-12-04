<?php

namespace App\Http\Controllers\Api;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Transformers\RepliesTransformer;
use App\Models\Topic;

class RepliesController extends Controller
{
    public function index(Topic $topic)
    {
        $replies = $topic->replies()->paginate(2);
        return $this->response->paginator($replies, new RepliesTransformer());
    }
}
