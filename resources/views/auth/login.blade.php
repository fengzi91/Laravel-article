@extends('layouts.app')

@section('content')
    <div class="mdui-row mdui-m-t-5">
        <div class="mdui-col-md-6 mdui-col-offset-md-3">
            <div class="mdui-card">
                <div class="mdui-card-header mdui-valign mdui-typo-headline">登 录</div>
                <div class="mdui-card-content mdui-p-t-0">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('email') ? ' mdui-textfield-invalid' : '' }}">
                            <label for="email" class="mdui-textfield-label">邮 箱</label>
                            <input id="email" type="email" class="mdui-textfield-input" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                            <div class="mdui-textfield-error">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>

                        <div class="mdui-textfield mdui-textfield-floating-label {{ $errors->has('password') ? ' mdui-textfield-invalid' : '' }}">
                            <label for="password" class="mdui-textfield-label">密 码</label>
                            <input id="password" type="password" class="mdui-textfield-input" name="password" required>
                            @if ($errors->has('password'))
                            <div class="mdui-textfield-error">
                                {{ $errors->first('password') }}
                            </div>
                            @endif
                        </div>
                        <div class="mdui-textfield mdui-p-l-2">
                            <label class="mdui-switch">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                <i class="mdui-switch-icon"></i>
                                <i class="mdui-p-l-1">记住我</i>
                            </label>
                        </div>
                        <div class="mdui-textfield">
                            <button type="submit" class="mdui-btn mdui-color-blue mdui-ripple mdui-text-color-white">
                                登  录
                            </button>
                            <a class="mdui-p-l-2" href="{{ route('password.request') }}">
                                忘记密码?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
