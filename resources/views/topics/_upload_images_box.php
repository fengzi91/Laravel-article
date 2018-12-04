    <div class="mdui-dialog" id="dialog">
        <div class="mdui-dialog-title">插入图片</div>
        <div class="mdui-dialog-content">
            <p>网络图片或者从本地上传</p>
            <div class="mdui-textfield">
                <input class="mdui-textfield-input" type="text" placeholder="输入网络图片地址" v-model="imgUrl" />
            </div>
            <div class="mdui-textfield">
                <input type="file" placeholder="本地上传" @change="getFile($event)"/>
            </div>
            <div class="mdui-typo-caption">@{{upload_error_message}}</div>
            <div class="mdui-progress" v-show="uploading">
                <div class="mdui-progress-indeterminate"></div>
            </div>
        </div>
        <div class="mdui-dialog-actions">
            <button class="mdui-btn mdui-ripple" mdui-dialog-confirm>确认</button>
            <button class="mdui-btn mdui-ripple" mdui-dialog-cancel>取消</button>
        </div>
    </div>