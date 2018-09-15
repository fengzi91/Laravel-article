@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
@include('users._header')
<div class="mdui-container">
  @include('layouts._message')
  <div class="mdui-row mdui-m-t-5">
    <div class="mdui-col-md-6">
      @if (if_query('tab', 'replies'))
        @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(15)])
      @else
        @include('users._topics', ['topics' => $user->topic_edits()->with('topic')->paginate(15)])
      @endif
    </div>
  </div>
</div>
@stop