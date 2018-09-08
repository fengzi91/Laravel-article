@extends('layouts.app')
@section('title', '用户')
@section('content')
	<div class="mdui-container mdui-m-t-5">
		@if (count($users)) 
			@foreach($users as $user)
				<div class="mdui-float-left">
					<a href="{{ route('users.show', $user->id)}}"><img src="{{ $user->avatar }}" /></a>
				</div>
			@endforeach
		@endif
	</div>
@stop