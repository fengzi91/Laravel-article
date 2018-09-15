<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Topic;
use App\Models\TopicEdit;
use App\Models\User;
use Auth;
use App\Http\Requests\TopicEditRequest;
use Markdown;

class TopicEditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(Topic $topic) 
    {
        $topic_edit = '';
        return view('topic_edit.create', compact('topic', 'topic_edit'));
    }
    public function show(TopicEdit $topic_edit, Topic $topic)
    {
        // 只有自己和管理才可以浏览
        $this->authorize('view', $topic_edit);
        //dd($topic_edit->stext);
        $topic = $topic->find($topic_edit->topic_id);
        $topic_edit->userinfo = $topic_edit->user()->first();
        $topic_edit->body = Markdown::html($topic_edit->body);
        $topic_edit->time = $topic_edit->updated_at->diffForHumans();
        // 状态
        $topic_edit->status_text = $topic_edit->stext;
        return view('topic_edit.show', compact('topic_edit', 'topic'));
    }
    public function store(TopicEditRequest $request, TopicEdit $topic_edit, Topic $topic) 
    {
    	$topic_id = $request->topic_id;
        $result = ['message' => '系统错误， 请重试！', 'error' => 1];
        if ($topic_info = $topic->find($topic_id)) {
            $topic_edit->fill($request->all());
            $topic_edit->topic_id = $topic_id;
            $topic_edit->user_id = Auth::id();
            if ($topic_edit->save()) {
                $message = '您提交的信息已保存，请等待管理员审核';
                $result = ['message' => $message, 'error' => 0];
                if ($request->ajax()) return $result;
                return redirect()->route('topic_edit.show', $topic_edit->id)->with('message', $message);
            }
        }
        if ($request->ajax()) return $result;
        return redirect()->route('topic_edit.show', $topic_edit->id)->with('message', $message);
    }
    public function update(TopicEditRequest $request, TopicEdit $topic_edit)
    {
    	$this->authorize('update', $topic_edit);
        $topic_edit->fill($request->all());
        if( $topic_edit->save() ) {
            $message = '您提交的信息已保存，请等待管理员审核';
        }
        if($request->ajax()) {
            return ['error' => 0, 'message' => $message];
        }
        return redirect()->route('topic_edit.show', $topic_edit->id)->with('message', $message);
    }
    public function edit(TopicEditRequest $request, TopicEdit $topic_edit)
    {
        $this->authorize('update', $topic_edit);
        // 编辑一份存档
        $topic = $topic_edit->topic()->first();
        return view('topic_edit.create', compact('topic', 'topic_edit'));
    }

    public function check(Request $request, Topic $topic, TopicEdit $topic_edit, $type = 'on')
    {
        $this->authorize('check', $topic_edit);
        // 通过审核 将 topic 中的 body 用 topic_edit 中的 body 替换
        $error = 0;
        if($topic_edit->status <> 0) {
            $message = '已审核过该文档！';
            $error = 1;
        } else {
        if ($type === 'on') {
            $topic->body = $topic_edit->body;
            if ($topic->save()) {
                $topic_edit->status = 1;
                $topic_edit->save();
                $message = '审核成功';
            }
            $message = '审核失败！';
            } else {
                $topic_edit->status = -1;
                $topic_edit->save();
                $message = '成功拒绝一份文档！';
            }
            
        }
        if ($request->ajax()) {
            return ['error' => $error,'message' => $message, 'data' => $topic_edit];
        }
        return redirect()->route('topic_edit.show', $topic_edit->id)->with('message', $message);
    }
}
