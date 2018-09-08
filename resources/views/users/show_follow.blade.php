@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="mdui-col-offset-md-2 mdui-col-md-8">
  <h1>{{ $title }}</h1>
  <ul class="g-users-list mdui-clearfix">
    @foreach ($users as $user)
      <li class="mdui-typo">
        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="gravatar"/>
        <a href="{{ route('users.show', $user->id )}}" class="username">{{ $user->name }}</a>
      </li>
    @endforeach
  </ul>
  <div class="g-pagination">
  {!! $users->render() !!}
  </div>
</div>
@stop