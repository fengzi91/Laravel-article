<div class="mdui-textfield mdui-textfield-floating-label mdui-p-t-0" :class="{'mdui-textfield-invalid': comment_submit_haserror}">
    <label class="mdui-textfield-label">发表你的看法</label>
    <textarea v-model="comment_content" class="mdui-textfield-input" name="content" :disabled="user_id <= 0"></textarea>
    <div class="mdui-textfield-error" v-if="comment_submit_haserror">@{{comment_submit_error_message}}</div>
  </div>
<div class="mdui-typo" v-if="user_id <= 0">
  需要<a href="{{ route('login') }}">登录</a>以后才可发表评论
</div>
<button class="mdui-btn mdui-ripple mdui-color-blue-600" @click="submits()" v-else>回复</button>