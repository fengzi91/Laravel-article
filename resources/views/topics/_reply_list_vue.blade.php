<ul class="mdui-list" :class="list_class" style="overflow: hidden;position: relative;margin-top: 16px;" :style="'max-height' + comments_line * 88">
<transition-group name="list" mode="out-in">  
  <template v-for="item in comments">
  <li :key="item.id" class="g-reply-list-item mdui-clearfix" :name="'reply' + item.id" :id="'reply' + item.id">
    <div class="mdui-float-left">
      <div class="mdui-row">
        <div class="g-reply-list-item-avatar mdui-float-left">
          <a :href="'/users/' + item.user_id"><img :alt="item.user.name" :src="item.user.avatar ? item.user.avatar : '/users/avatar/' + item.user_id" width="40" height="40" /></a>
        </div>
      <div class="g-reply-list-item-name mdui-float-left">
        <div class="mdui-list-item-title">@{{ item.user.name }}</div>
        <div class="mdui-list-item-time">
          <span class="mdui-text-color-theme-text g-time">@{{ item.created_at }}</span>
        </div>
      </div>
    </div>
    <div class="mdui-row">
      <div class="g-reply-list-item-content">@{{ item.content }}</div>
    </div>
  </div>
  <div class="mdui-float-right">
      <button class="mdui-btn mdui-text-color-red mdui-btn-icon" v-if="item.user_id === user_id">
        <i class="mdui-icon material-icons">&#xe92b;</i>
      </button>
  </div>
  </li>
  </template>
</transition-group>
</ul>
<div class="g-pagination">
<button @click="get_prev()" class="mdui-btn" :disabled="!prev_page_url">上一页</button>
<button @click="get_next()" class="mdui-btn" :disabled="!next_page_url">下一页</button>
</div>