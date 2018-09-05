@if (count($replies))
    @foreach ($replies as $reply)
  <div class="mdui-card mdui-m-b-2">
    <div class="mdui-card-primary">
        <div class="mdui-card-primary-title mdui-typo">
            <a href="{{ $reply->topic->link(['#reply' . $reply->id]) }}">
                {{ $reply->topic->title }}
            </a>
        </div>
        <div class="mdui-card-primary-subtitle">{{ $reply->content }}</div>
    </div>
  </div>
  @endforeach
@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="g-pagination">
{!! $replies->appends(Request::except('page'))->render() !!}
</div>