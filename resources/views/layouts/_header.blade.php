<nav class="mdui-container-fluid mdui-p-x-0 mdui-shadow-2 g-nav" mdui-headroom>
    <div class="">
        <div class="mdui-container mdui-center mdui-row">
            <div class="g-logo mdui-col-xs-4">
                <a class="mdui-typo-headline mdui-hidden-xs g-logo" href="{{ url('/') }}">
                    <i>梗</i>来了
                </a>
                <a href="/topics" class="mdui-m-l-3 g-header-link">发现</a>
            </div>
            @guest
            <div class="mdui-float-right g-user-btn">
                <a href="{{ route('login') }}" class="mdui-btn mdui-ripple">登录</a>
                <a href="{{ route('register') }}" class="mdui-btn mdui-ripple">注册</a>
            </div>
            @else
            <div class="mdui-float-right mdui-valign g-user-header-btn">
                <a href="{{ route('notifications.index') }}" class="mdui-btn mdui-m-r-1">新消息({{ Auth::user()->notification_count }})</a>
                <a href="{{ route('topics.create') }}" class="mdui-btn mdui-btn-icon mdui-text-color-theme-accent mdui-ripple mdui-m-r-1"><i class="mdui-icon material-icons">add</i></a>
                <a href="javascript:void(0);" class="user-avatar mdui-ripple" mdui-menu="{target: '#example-attr', position: 'bottom', align: 'right', covered: false}">
                    <img src="{{ Auth::user()->newavatar }}" class="mdui-img-circle" width="40" height="40" />
                </a>
                <ul class="mdui-menu" id="example-attr">
                    @can('manage_contents')
                     <li class="mdui-menu-item">
                        <a href="{{ url(config('administrator.uri')) }}">
                            管理后台
                        </a>
                    </li>
                    @endcan
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