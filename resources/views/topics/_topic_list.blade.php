@if (count($topics))
    <div class="g-topic-list">
      @foreach ($topics as $topic)
        <div class="mdui-card mdui-m-t-3 mdui-hoverable">
          <div class="mdui-card-primary">
            <div class="mdui-card-primary-title mdui-typo">
              <a href="{{ route('topics.show', [$topic->id]) }}" title="{{ $topic->title }}">{{ $topic->title }}</a>
            </div>
          </div>  
          <div class="mdui-card-content">
              {{ $topic->body }}
          </div>
          <div class="mdui-card-content mdui-clearfix">
              <div class="mdui-float-left">
                <a href="javascript:;" class="mdui-btn mdui-btn-icon"><i class="mdui-icon material-icons mdui-text-color-theme">&#xe8dc;</i></a> {{ $topic->up_count }}
              </div>
              <div class="mdui-float-right">
                <a href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                {{ $topic->user->name }}
              </a>
                        <span> • </span>
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago" title="最后活跃于">{{ $topic->updated_at->diffForHumans() }}</span>
              </div>
          </div>
        </div>
      @endforeach
    </div>
@endif