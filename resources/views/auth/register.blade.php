@extends('layouts.app')

@section('content')
<div class="mdui-container">
    <div class="mdui-row mdui-m-t-5">
        <div class="mdui-col-md-6 mdui-col-offset-md-3">
            <div class="mdui-card">
                <div class="mdui-card-header mdui-valign mdui-typo-headline">加入梗来了</div>
                <div class="mdui-card-content mdui-m-t-0">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('name') ? ' mdui-textfield-invalid' : '' }}">
                            <label for="name" class="mdui-textfield-label">用户名</label>
                            <input id="name" type="text" class="mdui-textfield-input" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                            <div class="mdui-textfield-error">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>

                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('email') ? ' mdui-textfield-invalid' : '' }}">
                            <label for="email" class="mdui-textfield-label">邮箱</label>
                            <input id="email" type="email" class="mdui-textfield-input" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <div class="mdui-textfield-error">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('password') ? ' mdui-textfield-invalid' : '' }}">
                            <label for="password" class="mdui-textfield-label">密码</label>
                            <input id="password" type="password" class="mdui-textfield-input" name="password" required>
                            @if ($errors->has('password'))
                            <div class="mdui-textfield-error">
                                {{ $errors->first('password') }}
                            </div>
                            @endif
                        </div>

                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <label for="password-confirm" class="mdui-textfield-label">重复密码</label>
                            <input id="password-confirm" type="password" class="mdui-textfield-input" name="password_confirmation" required>
                        </div> 

                        <div class="mdui-container-fluid mdui-p-x-0 mdui-m-x-0">
                            <div class="mdui-row">
                                <div class="mdui-col-xs-6">
                                    <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                                </div>
                                <div class="mdui-col-xs-6">
                                    <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('captcha') ? ' mdui-textfield-invalid' : '' }}">
                                        <label for="captcha" class="mdui-textfield-label">验证码</label>
                                        <input id="captcha" type="text" class="mdui-textfield-input" name="captcha" required>
                                        @if ($errors->has('captcha'))
                                        <div class="mdui-textfield-error">
                                            {{ $errors->first('captcha') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mdui-textfield">
                            <button type="submit" class="mdui-ripple mdui-btn mdui-color-blue mdui-text-color-white">
                                注册
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
