@if ($user->id)
	<div class="mdui-card g-user-micro-info">
		<div class="avatar">
			<img src="{{$user->avatar ?: $user->newavatar}}" />
		</div>
		<div class="name">
			<a href="{{route('users.show', $user->id)}}">{{$user->name}}</a>
		</div>
		<div class="info">
			<div class="count">
				<div class="total">111</div>
				<div class="text">发表</div>
			</div>
			<div class="count">
				<div class="total">111</div>
				<div class="text">回复</div>
			</div>
			<div class="count">
				<div class="total">{{count($user->followers)}}</div>
				<div class="text">粉丝</div>
			</div>
		</div>
		@if (Auth::check())
        	@include('users._follow_form')
      	@endif
	</div>
@endif
