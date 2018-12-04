<div class="reply-list" :class="list_class" style="overflow: hidden;position: relative;margin-top: 16px;" :style="'max-height' + comments_line * 88">
    <template v-for="item in comments">
        <div :key="item.id" class="media" :name="'reply' + item.id" :id="'reply' + item.id">
            <div class="avatar pull-left">
                <a :href="'/users/' + item.user.id" rel="nofollow">
                    <img :alt="item.user.name" :src="item.user.avatar ? item.user.avatar : '/users/avatar/' + item.user.id" class="media-object img-thumbnail" />
                </a>
            </div>
            <div class="infos">
                <div class="media-heading meta">
                    @{{ item.user.name }} <span> •  </span> @{{ item.created_at }}
                </div>
                <div class="reply-content">@{{ item.content }}</div>
            </div>
        </div>
    </template>
</div>
<div class="get-more">
    <button @click="get_next()" class="btn btn-primary" :disabled="(!next_page_url || updating)">@{{ get_more_text }}</button>
</div>