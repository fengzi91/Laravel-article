@if (count($topics))
    <div class="g-topic-list">
      @foreach ($topics as $topic)
        <div class="mdui-card mdui-m-t-3">
          <div class="mdui-card-primary">
            <div class="mdui-card-primary-title mdui-typo">
              <a href="{{ route('topics.show', [$topic->id]) }}" title="{{ $topic->title }}">{{ $topic->title }}</a>
            </div>
          </div>  
          <div class="mdui-card-content">
              {{ $topic->body }}
          </div>
          <div class="mdui-card-content mdui-clearfix">
              <div class="mdui-float-left g-topic-button-color">
                <a href="javascript:;" class="mdui-btn mdui-btn-dense mdui-btn-icon mdui-hoverable">
                  <i class="mdui-icon material-icons" style="font-size: 16px;">&#xe8dc;</i>
                </a>
                {{ $topic->up_count }}
                <a href="javascript:;" class="mdui-btn mdui-m-l-1 mdui-btn-dense mdui-btn-icon mdui-hoverable">
                  <i class="mdui-icon material-icons" style="font-size: 16px;">&#xe0b9;</i>
                </a>
                {{ $topic->reply_count }}
                @if (count($topic->tags))
                  <i class="mdui-icon material-icons mdui-m-l-1">&#xe54e;</i>
                  @foreach ($topic->tags as $tag)
                    <a href="{{ route('tags.show', [$tag->id]) }}" class="mdui-m-r-1">{{$tag->name}}</a>
                  @endforeach
                @endif
              </div>
              <div class="mdui-float-right">
                
              </div>
          </div>
        </div>
      @endforeach
    </div>
@endif