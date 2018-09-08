@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
@include('users._header')
<div class="mdui-container">
  <div class="mdui-row mdui-m-t-5">
        <div class="mdui-clearfix">
            <div class="mdui-float-left mdui-p-l-2">
                <div class="mdui-typo-headline">更改资料</div>
            </div>
        </div>
        <div class="mdui-divider" style="height:2px;margin-top:2px;"></div>
  </div>
  @include('layouts._message')
  <div class="mdui-row mdui-m-t-2">
    <div class="mdui-col-md-4 mdui-col-xs-12" style="min-height: 90vh">
    <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
       <input type="hidden" name="_method" value="PUT">
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('name') ? ' mdui-textfield-invalid' : '' }}">
                    <label class="mdui-textfield-label">昵称</label>
                    <input class="mdui-textfield-input" type="text" name="name" value="{{ old('name', $user->name ) }}"/>
                    @if ($errors->has('name')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                </div>
        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('introduction') ? ' mdui-textfield-invalid' : '' }}">
                    <label class="mdui-textfield-label">个人简介</label>
                    <textarea class="mdui-textfield-input" name="introduction" value="{{ old('introduction', $user->introduction ) }}"></textarea>
                    @if ($errors->has('introduction')) 
                    <div class="mdui-textfield-error">
                        {{ $errors->first('introduction') }}
                    </div>
                    @endif
                </div>
        <div class="mdui-textfield">
          <button type="submit" class="mdui-btn mdui-color-blue-600">提 交</button>
        </div>       
    </form>
  </div>
  </div>
</div>

@endsection