@if (count($topics))
    <ul class="media-list row">
      @foreach ($topics as $topic)
        <li class="media col-md-3">
            <div class="panel panel-default">
                <div class="media-heading">
                    <a class="topic-image" href="{{ route('topics.show', [$topic->id]) }}" title="{{ $topic->title }}">
                        <img src="{{ $topic->user->newavatar }}" title="{{ $topic->user->name }}">
                        <h4>{{ $topic->title }}</h4>
                    </a>
                </div>
                <div class="media-body meta">
                    {{ $topic->excerpt }}
                </div>
                <div class="media-info meta clearfix">
                    <div class="pull-left">
                        <a href="{{ route('users.show', [$topic->user_id]) }}" rel="nofollow" title="{{ $topic->user->name }}">
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
        </li>
        @endforeach
    </ul>
@endif