@extends('layouts.app')
@section('title', $topic->title )
@section('content')
<div class="mdui-container">
<div class="mdui-row mdui-m-t-5">
    <div class="mdui-col-md-8 mdui-col-offset-md-2">
        <div class="mdui-card">  
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">{{ $topic->title }}</div>
            </div>
            <div class="mdui-card-content markdown-body mdui-typo">
                {!! Markdown::html($topic->body) !!}
            </div>
            <div class="mdui-card-content">
                @if (count($topic->tags))
                    @foreach ($topic->tags as $tag)
                    <div class="mdui-chip mdui-m-r-1"> 
                        <span class="mdui-chip-title">
                            <a href="{{ route('tags.show', $tag->id) }}">{{ $tag->name }}</a>
                        </span>
                        @can('destroy', $topic)   
                            <span class="mdui-chip-delete" onclick="event.preventDefault();document.getElementById('delete-form-{{$tag->id}}').submit();"><i class="mdui-icon material-icons">cancel</i></span>
                            <form id="delete-form-{{$tag->id}}" action="{{ route('topics.deletetag', $topic->id) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            <input type="hidden" name="tagid" value="{{$tag->id}}" />
                            </form>
                        @endcan
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="mdui-card-actions">
                <a href="{{ route('topic_edit.show', $topic->id) }}" class="mdui-btn mdui-ripple">参与编辑</a>
                <button class="mdui-btn mdui-ripple">举报</button>
                <button class="mdui-btn mdui-btn-icon mdui-float-right"><i class="mdui-icon material-icons">expand_more</i></button>
            </div>
        </div>
        <div class="mdui-card mdui-m-t-4">
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">参与编辑的用户</div>
            </div>
            <div class="mdui-card-content mdui-p-t-0">
                @if (count($topic->edits))
                    @foreach($topic->edits()->distinct()->get() as $edit)
                        <img src="{{$edit->avatar}}" alt="{{$edit->name}}"/>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="mdui-card mdui-m-t-4">
            <div class="mdui-card-primary">
                <div class="mdui-card-primary-title">评论(@{{comments_total}})</div>
            </div>
            <div class="mdui-card-content mdui-p-t-0">
                @include('topics._reply_box_vue', ['topic' => $topic])
                @include('topics._reply_list_vue')
                {{--@include('topics._reply_list', ['replies' => $topic->replies()->with('user')->recent()->paginate(5)])--}}
            </div>
        </div>
    </div>
    {{--<div class="mdui-col-md-4">
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
    </div>--}}
</div>
</div>
@endsection

@section('scripts')
    <script>
        var user_id = @guest 0 @else {{Auth::id()}}@endguest;
        var app = new Vue({
            el: '#app',
            data: {
                title: '{{$topic->title}}',
                id: {{$topic->id}},
                user_id: user_id,
                comments_total: 0,
                comments_limit: 0,
                comments_line: 5,
                comment_content: '',
                comment_submit_haserror: false,
                comments: [],
                comment_submit_error_message: '',
                get_list_url: '{{ route('topics.getcomments', $topic->id)}}',
                submit_url: '{{ route('replies.store') }}',
                next_page_url: '',
                prev_page_url: '',
                updating: false,
                list_class: 'list-next'
            },
            mounted: function () {
                this.comments_list()
            },
            methods: {
                submits: function () {
                    if (this.comment_content) {
                        this.comment_submit_haserror = false
                        var _this = this;
                        axios.post(_this.submit_url, {
                            topic_id: _this.id,
                            content: _this.comment_content
                        })
                        .then(function (response) {
                            // 设置动画
                            _this.list_class = 'list-add';
                            _this.comments.unshift(response.data.data);
                            if (_this.comments.length > _this.comments_limit) {
                                _this.comments.pop();
                            }
                            _this.comments_total ++;
                            _this.comment_content = '';
                        })
                        .catch(function (error) {
                            _this.comment_submit_haserror = true;
                            if (error.response) {
                                if(error.response.data.errors.content) {
                                    var content = error.response.data.errors.content;
                                    _this.comment_submit_error_message = content[0];
                                } else {
                                    _this.comment_submit_error_message = error.response.data.errors.message;
                                }
                            }
                            console.log('发生了错误');
                        });

                    } else {
                        this.comment_submit_haserror = true;
                        this.comment_submit_error_message = '请填写评论内容';
                    }
                },
                comments_list: function () {
                    var _this = this;
                    this.updating = true;
                    axios.get(_this.get_list_url).then( function (response) {
                        var data = response.data;
                        _this.comments_total = data.total;
                        _this.comments_limit = data.per_page;
                        _this.comments = data.data;
                        _this.next_page_url = data.next_page_url;
                        _this.prev_page_url = data.prev_page_url;
                        _this.updating = false;
                        if(_this.comments_total < _this.comments_limit) _this.comments_line = _this.comments_total
                        else _this.comments_line = _this.comments_limit
                    });
                },
                get_prev: function () {
                    if(this.prev_page_url) {
                        this.list_class = 'list-prev';
                        this.get_list_url = this.prev_page_url;
                        this.comments_list();
                    }
                },
                get_next: function () {
                    if(this.next_page_url) {
                        this.list_class = 'list-next';
                        this.get_list_url = this.next_page_url;
                        this.comments_list();
                    }
                }
            }
        })
    </script>

@endsection
