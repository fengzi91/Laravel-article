@extends('layouts.app')
@section('title', '无权限访问')

@section('content')
<div class="mdui-container">
<div class="mdui-col-md-4 mdui-col-offset-md-4">
    <div class="mdui-card mdui-m-t-5">
        <div class="mdui-card-primary">
            @if (Auth::check())
                <div class="alert alert-danger text-center">
                    当前登录账号无后台访问权限。
                </div>
            @else
                <div class="alert alert-danger text-center">
                    请登录以后再操作
                </div>

                <a class="btn btn-lg btn-primary btn-block" href="{{ route('login') }}">
                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                    登 录
                </a>
            @endif
        </div>
    </div>
</div>
</div>
@stop