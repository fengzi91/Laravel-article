@extends('layouts.app')
@section('title', '用户')
@section('content')
	<div class="mdui-container mdui-m-t-5">
		@if (count($users)) 
			@foreach($users as $user)
				<img src="{{ $user->newavatar }}" />
			@endforeach
		@endif
	</div>
@endsection('content')