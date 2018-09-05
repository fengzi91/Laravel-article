<ul class="mdui-list">
  @foreach ($replies as $index => $reply)
  <li class="g-reply-list-item" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
    <div class="mdui-row">
    <div class="g-reply-list-item-avatar mdui-float-left">
      <a href="{{ route('users.show', [$reply->user_id]) }}"><img alt="{{ $reply->user->name }}" src="{{ $reply->user->newavatar }}" width="40" height="40" /></a>
    </div>
    <div class="g-reply-list-item-name mdui-float-left">
      <div class="mdui-list-item-title">{{ $reply->user->name }}</div>
      <div class="mdui-list-item-time">
        <span class="mdui-text-color-theme-text g-time">{{ $reply->created_at->diffForHumans() }}</span>
      </div>
    </div>
    </div>
    <div class="mdui-row">
      <div class="g-reply-list-item-content">{{ $reply->content }}</div>
    </div>
  </li>
  <li class="mdui-divider-inset mdui-m-y-0 mdui-m-x-0"></li>
  @endforeach
</ul>
<div class="g-pagination">
{!! $replies->appends(Request::except('page'))->render() !!}
</div>