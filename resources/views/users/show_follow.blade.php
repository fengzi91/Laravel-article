@extends('layouts.app')
@section('title', $title)

@section('content')
@include('users._header')
<div class="mdui-col-offset-md-2 mdui-col-md-8 mdui-m-t-5">
  <div class="g-users-list">
    @foreach ($users as $user)
      @include('users._show_info', ['user' => $user])
    @endforeach
  </div>
  <div class="g-pagination">
  {!! $users->render() !!}
  </div>
</div>
@stop