<div class="mdui-container-fluid g-user-banner-full" style="background-image:url('/images/banner.jpg');">
  <div class="mdui-container">
    <div class="mdui-row g-user-banner ">
      <div class="g-user-banner-avatar">
        @can ('update', $user)
        <a href="{{ route('users.editavatar', $user->id) }}">
        @endcan
          <img src="{{ $user->newavatar }}" />
        @can ('update', $user)  
        </a>
        @endcan

      </div>
      <div class="g-user-banner-info">
        <h1>{{ $user->name }}</h1>
        <div class="mdui-m-l-2">{{ $user->introduction }}</div>
      </div>
      <div class="g-user-banner-button">
        @if (Auth::check())
          @include('users._follow_form')
        @endif
      </div>
    </div>
  </div>
</div>
<div class="mdui-container">
  <div class="mdui-tab g-user-tab-link">
      <a href="{{ route('users.show', $user->id) }}" class="mdui-ripple {{ active_class((if_route('users.show') && if_query('tab', null))) }}">参与编辑</a>

      <a href="{{ route('users.show', $user->id) }}?tab=replies" class="mdui-ripple {{ active_class((if_route('users.show') && if_query('tab', 'replies'))) }}">发表评论</a>

      <a href="{{ route('users.followings', $user->id) }}" class="mdui-ripple {{ active_class(if_route('users.followings')) }}">关注</a>
      
      <a href="{{ route('users.followers', $user->id) }}" class="mdui-ripple {{ active_class(if_route('users.followers')) }}">粉丝</a>

      @can('update', $user)
      <a href="{{ route('users.edit', $user->id)}}" class="mdui-ripple {{ active_class(if_route('users.edit')) }}">编辑资料</a>
      @endcan
  </div>
</div>