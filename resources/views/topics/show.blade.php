@extends('layouts.app')
@section('title', $topic->title )
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h2>{{ $topic->title }}</h2>
        <div class="meta clearfix">
            <div class="pull-left">
                <a href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}" rel="nofollow">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    {{ $topic->user->name }}
                </a>
            </div>
            <div class="pull-right">
                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                <span class="timeago" title="最后活跃于">{{ $topic->updated_at->diffForHumans() }}   </span>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Markdown::html($topic->body) !!}
    </div>
</div>
<div class="panel panel-default topic-reply">
    <div class="panel-body">
        <div class="panel-primary">
            评论(@{{comments_total}})
        </div>
        <div class="panel-body">
            @include('topics._reply_box_vue', ['topic' => $topic])
            @include('topics._reply_list_vue')
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript"  src="{{ asset('js/vue.js') }}"></script>
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
                get_list_url: '/api/topics/{{$topic->id}}/replies',
                submit_url: '{{ route('replies.store') }}',
                next_page_url: '',
                prev_page_url: '',
                updating: false,
                list_class: 'list-next',
                get_more_text: '加载更多...'
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
                    axios.get(_this.get_list_url, {
                        params: {
                            include: 'user'
                        },
                        headers: {
                            'Accept': 'application/prs.geng.v1+json'
                        }
                    }).then( function (response) {
                        var data = response.data;
                        let pageinfo = data.meta.pagination;
                        _this.comments_total = pageinfo.total;
                        _this.comments_limit = pageinfo.per_page;
                        _this.comments = _.union(_this.comments, data.data);
                        console.log(_this.comments)
                        _this.next_page_url = pageinfo.links.next;
                        _this.prev_page_url = pageinfo.links.previous;
                        _this.updating = false;
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
