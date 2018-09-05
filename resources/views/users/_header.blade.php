<div class="mdui-container-fluid" style="min-height: 40vh; background-image: url('/uploads/images/users/1/banner.jpg');background-size:cover;background-repeat:no-repeat;background-position:50%">
  <div class="mdui-container">
    <div class="mdui-row g-user-banner ">
      <div class="g-user-banner-avatar">
        <a href="{{ route('users.editavatar', $user->id) }}"><img src="{{ $user->avatar }}" /></a>
      </div>
      <div class="g-user-banner-info">
        <h1>{{ $user->name }}</h1>
        <div class="mdui-m-l-2">{{ $user->introduction }}</div>
      </div>
    </div>
  </div>
</div>
<div class="mdui-container">
  <div class="mdui-tab g-user-tab-link">
      <a href="#1" class="mdui-ripple active">参与编辑</a>
      <a href="#2" class="mdui-ripple">发表评论</a>
      <a href="#3" class="mdui-ripple">关注的人</a>
      @can('update', $user)
      <a href="{{ route('users.edit', $user->id)}}" class="mdui-ripple">编辑资料</a>
      @endcan
  </div>
</div>