<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;
class RepliesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
	public function store(ReplyRequest $request, Reply $reply)
	{
		// $reply->content = clean($request->content, 'user_topic_body');
    $reply->content = $request->content;
    $reply->user_id = Auth::id();
    $reply->topic_id = $request->topic_id;
    $reply->save();
    $reply->user;
    return ['error' => 0, 'message' => '回复成功', 'data' => $reply];
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
    $reply->delete();

    return redirect()->to($reply->topic->link())->with('success', '成功删除回复！');
	}
}