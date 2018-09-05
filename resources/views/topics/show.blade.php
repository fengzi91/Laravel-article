@extends('layouts.app')

@section('content')
<div class="mdui-container">
<div class="mdui-row mdui-m-t-5">
    <div class="mdui-col-md-8">
        <div class="mdui-card">  
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">{{ $topic->title }}</div>
            </div>
            <div class="mdui-card-content">
                {!! $topic->body !!}
            </div>
            <div class="mdui-card-actions">
                <a href="{{ route('topics.edit', $topic->id) }}" class="mdui-btn mdui-ripple">参与编辑</a>
                <button class="mdui-btn mdui-ripple">举报</button>
                <button class="mdui-btn mdui-btn-icon mdui-float-right"><i class="mdui-icon material-icons">expand_more</i></button>
            </div>
        </div>
        <div class="mdui-card mdui-m-t-4">
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">评论</div>
            </div>
            <div class="mdui-card-content mdui-p-t-0">
                @include('topics._reply_box', ['topic' => $topic])
                @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->recent()->paginate(5)])
            </div>
        </div>
    </div>
    <div class="mdui-col-md-4">
        <div class="mdui-card">
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">相关人物</div>
            </div>
            <div class="mdui-card-content">
                <ul class="mdui-list mdui-list-dense">
                    <li class="mdui-list-item mdui-ripple">
                        <div class="mdui-list-item-avatar"><img src="https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=4139029209,1389232728&fm=58"/></div>
                        <div class="mdui-list-item-content">
                            <div class="mdui-list-item-title">诺言</div>
                            <div class="mdui-list-item-text mdui-list-item-two-line"><span class="mdui-text-color-theme-text">明凯</span> 1993年7月25日出生于湖北武汉，游戏ID：Clearlove，中国《英雄联盟》电子竞技职业选手，EDG战队打野。</div>
                        </div>
                    </li>
                    <li class="mdui-divider-inset mdui-m-y-0"></li>
                    <li class="mdui-list-item mdui-ripple">
                        <div class="mdui-list-item-avatar"><img src="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=3199136532,4093974124&fm=26&gp=0.jpg" /></div>
                        <div class="mdui-list-item-content">
                            <div class="mdui-list-item-title">小花生</div>
                            <div class="mdui-list-item-text mdui-list-item-two-line"><span class="mdui-text-color-theme-text">peanut</span> - 韩国KZ(KingzoneDragonX)俱乐部职业选手.</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mdui-card mdui-m-t-2">
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">相关事件</div>
            </div>
            <div class="mdui-card-content">
                <ul class="mdui-list mdui-list-dense">
                    <li class="mdui-list-item mdui-ripple">
                        <div class="mdui-list-item-avatar"><img src="https://timg01.bdimg.com/timg?pacompress&imgtype=0&sec=1439619614&di=6d5e53c1f5f8bab3fa864529f260b63d&quality=90&size=b870_10000&src=http%3A%2F%2Fbos.nj.bpc.baidu.com%2Fv1%2Fmediaspot%2Fd33f1181553447438c93669544ad90c3.jpeg"/></div>
                        <div class="mdui-list-item-content">
                            <div class="mdui-list-item-title">S6总决赛</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
