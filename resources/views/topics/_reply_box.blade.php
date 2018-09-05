<form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8" class="mdui-m-b-4">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="topic_id" value="{{ $topic->id }}">
  <div class="mdui-textfield mdui-textfield-floating-label mdui-p-t-0 {{ $errors->has('content') ? ' mdui-textfield-invalid' : '' }}">
    <label class="mdui-textfield-label">发表你的看法</label>
    <textarea class="mdui-textfield-input" name="content"></textarea>
    @if ($errors->has('content')) 
      <div class="mdui-textfield-error">
        {{ $errors->first('content') }}
      </div>
    @endif
  </div>
  @auth
  <button type="submit" class="mdui-btn mdui-ripple mdui-color-blue-600">回复</button>
  @endauth
  @guest
  <button type="submit" class="mdui-btn mdui-ripple mdui-color-blue-600" disabled>回复</button>
  <a href="{{ route('login') }}" target="_blank">登录</a>
  @endguest
</form>