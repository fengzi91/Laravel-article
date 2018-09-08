@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
@include('users._header')
<div class="mdui-container">
  <div class="mdui-row mdui-m-t-5">
        <div class="mdui-clearfix">
            <div class="mdui-float-left mdui-p-l-2">
                <div class="mdui-typo-headline">修改头像</div>
            </div>
        </div>
        <div class="mdui-divider" style="height:2px;margin-top:2px;"></div>
  </div>
  @include('layouts._message')
  <div class="mdui-row mdui-m-t-2">
    @if($user->avatar)
      <img class="mdui-img-rounded" src="{{ $user->avatar }}" width="200" />
    @endif
    @include('common.error')
    <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
       <input type="hidden" name="_method" value="PUT">
       <input type="file" name="avatar"/>
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <button type="submit" class="mdui-btn mdui-color-blue-600">上 传</button>
    </form>
  </div>
</div>
@endsection