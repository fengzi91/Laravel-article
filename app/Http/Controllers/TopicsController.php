<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;
use App\Handlers\ImageUploadHandler;
use App\Models\Tag;
use Markdown;
use App\Transformers\RepliesTransformer;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'getComments']]);
    }

	public function index(Request $request, Topic $topic)
	{
		$topics = Topic::with(['user', 'tags'])->withOrder($request->order)->paginate(10);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
		return view('topics.create_and_edit', compact('topic'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
        $tagIds = [];
        if ($request->get('tag')) {
            $tagIds = $topic->autoTag($request->get('tag'));
        }
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        $topic->tags()->attach($tagIds);
		return redirect()->route('topics.show', $topic->id)->with('message', '内容创建成功!');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
        // 对于内容的修改，统一纳入历史记录里

        $user = Auth::user();

        $this->authorize('update', $topic);

		$topic->update($request->all());
        // 处理话题的标签
        $tagIds = [];
        if ($request->get('tag')) {
            $tagIds = $topic->autoTag($request->get('tag'));
        }
        $topic->tags()->sync($tagIds);
		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
    // 删除话题下的标签
    public function deleteTag(Topic $topic, Request $request)
    {
        //拥有删除话题的权限，才可以删除标签
        $this->authorize('destroy', $topic);
        $topic->tags()->detach($request->tagid);
        return redirect()->route('topics.show', $topic->id)->with('message', '成功删除一个标签！');
    }
    // 获取评论
    public function getComments(Topic $topic, Request $request)
    {
        $replies = $topic->replies()->with('user')->recent()->paginate(10);
        return response()->json($topic->replies()->with('user'), new RepliesTransformer());
    }
  /**
   * 图片上传
   * @param  Request            $request  [description]
   * @param  ImageUploadHandler $uploader [description]
   * @return [type]                       [description]
   */
  public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id());
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}