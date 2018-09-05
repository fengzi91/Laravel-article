<nav class="mdui-container-fluid mdui-p-x-0 mdui-shadow-3" mdui-headroom style="position: fixed; top: 0; left: 0; right: 0;">
    <div class="mdui-color-blue mdui-color-theme">
        <div class="mdui-container mdui-center mdui-row">
            <div class="g-logo mdui-col-xs-4">
                <a class="mdui-typo-headline mdui-hidden-xs mdui-text-color-white g-logo" href="{{ url('/') }}">
                    <i>梗</i>来了
                </a>
                <a href="/topics">浏览文章</a>
            </div>
            @guest
            <div class="mdui-float-right mdui-btn-group g-user-btn">
                <a href="{{ route('login') }}" class="mdui-btn mdui-ripple">登录</a>
                <a href="{{ route('register') }}" class="mdui-btn mdui-ripple">注册</a>
            </div>
            @else
            <div class="mdui-float-right mdui-valign g-user-header-btn mdui-p-t-1">
                <a href="#" class="user-avatar mdui-ripple" mdui-menu="{target: '#example-attr', position: 'bottom', align: 'right', covered: false}">
                    <img src="{{ Auth::user()->avatar }}" class="mdui-img-circle" width="40" height="40" />
                </a>
                <ul class="mdui-menu" id="example-attr">
                    <li class="mdui-menu-item">
                        <a href="{{ route('users.show', Auth::id()) }}">个人中心</a>
                    </li>
                    <li class="mdui-menu-item">
                        <a href="{{ route('users.edit', Auth::id()) }}">编辑资料</a>
                    </li>
                    <li class="mdui-menu-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            退出登录
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
            @endguest
        </div>
    </div>
</nav>