<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Topic;
use App\Models\TopicEdit;
use App\Models\User;
use Auth;
use App\Http\Requests\TopicEditRequest;

class TopicEditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [ 'show' ]]);
    }
    public function show(TopicEdit $topicedit, Topic $topic)
    {
        return view('topic_edit.create', compact('topic'));
    }
    public function store(TopicEditRequest $request, Topic $topic, TopicEdit $topicedit) 
    {
    	$topic_id = $request->topic_id;
        if($topic_info = $topic->find($topic_id)) {
            $topicedit->fill($request->all());
            $topicedit->topic_id = $request->topic_id;
            $topicedit->user_id = Auth::id();
            $topicedit->save();
        }

    }
    public function update(TopicEditRequest $request)
    {
    	dd($request->all());
    }
    public function edit(TopicEditRequest $request, TopicEdit $topicedit)
    {
        // 编辑一份存档
        $topic = $topicedit;
        return view('topic_edit.create', compact('topic'));
    }
}
