<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
class PagesController extends Controller
{
    public function root(Request $request, Topic $topic, $page = 1)
    {
        $request->merge(['page' => $page]);
        $topics = $topic->with('user')->recent()->paginate(24);
        return view('pages.root', compact('topics'));
    }
    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('pages.permission_denied');
    }
}
