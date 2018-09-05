<div class="g-reply-list-item mdui-m-t-2">
    <div class="mdui-row">
    <div class="g-reply-list-item-avatar mdui-float-left">
      <a href="{{ route('users.show', $notification->data['user_id']) }}"><img alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}" /></a>
    </div>
    <div class="g-reply-list-item-name mdui-float-left">
      <div class="mdui-list-item-title">
        {{ $notification->data['user_name'] }}
        <span class="mdui-text-color-theme-text g-time">{{ $notification->created_at->diffForHumans() }} 评论了您的文章 </span>
        <a href="{{ $notification->data['topic_link'] }}" class="mdui-text-color-theme-text g-time">{{ $notification->data['topic_title'] }}</a>
      </div>
      <div class="mdui-list-item-time">{!! $notification->data['reply_content'] !!}</div>
    </div>
    </div>
</div>