    @if ($user->id !== Auth::user()->id)
		<div class="button">
			@if (Auth::user()->isFollowing($user->id))
			<form action="{{ route('followers.destroy', $user->id) }}" method="post">
        		{{ csrf_field() }}
        		{{ method_field('DELETE') }}
        		<button type="submit" class="mdui-btn mdui-color-blue">取消关注</button>
      		</form>
			@else
      		<form action="{{ route('followers.store', $user->id) }}" method="post">
        		{{ csrf_field() }}
        		<button type="submit" class="mdui-btn mdui-color-blue">关注Ta</button>
      		</form>
			@endif
		</div>
		@endif