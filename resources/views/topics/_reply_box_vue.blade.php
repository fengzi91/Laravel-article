<div class="reply-box">
    <div class="form-group" :class="{'has-error': comment_submit_haserror}">
        <textarea v-model="comment_content" class="form-control" name="content" rows="3" placeholder="分享你的想法" :disabled="user_id <= 0"></textarea>
        <span class="help-block" v-if="comment_submit_haserror">@{{comment_submit_error_message}}</span>
    </div>
    <div class="typo" v-if="user_id <= 0">
        需要<a href="{{ route('login') }}">登录</a>以后才可发表评论
    </div>
    <button class="btn btn-primary btn-block" @click="submits()" v-else>回复</button>
</div>