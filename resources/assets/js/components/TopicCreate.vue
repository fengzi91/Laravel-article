<template>
  <div class="page-container">
      <geng-header v-bind:appData="appData" v-on:logout="logout"></geng-header>
        <transition appear name="up-down" appear-class="dropdown-appear-class" appear-to-class="animated slideInDown" leave-to-class="animated slideOutUp" enter-active-class="animated slideInDown" leave-active-class="animated bounceOutRight" mode="out-in">
          <user-login class="user-login" v-if="! signIn" v-bind:appData="appData" v-on:userLogin="userLogin"></user-login>
          <div class="md-layout md-alignment-top-center edit-box" style="margin:64px auto;" v-else>
            <div class="md-title g-title-line md-layout-item md-size-60 md-medium-size-45 md-small-size-50 md-xsmall-size-100">{{topic.title}}</div>
            <div class="edit md-layout-item md-size-60 md-medium-size-45 md-small-size-50 md-xsmall-size-100">
              <mavon-editor ref=md @imgAdd="$imgAdd" @imgDel="upImgDel" v-model="topic.body" :ishljs="false" :boxShadow="true"></mavon-editor>
            </div>
            <div class="md-layout-item md-size-60 md-medium-size-45 md-small-size-50 md-xsmall-size-100">
              <md-field :class="{'md-invalid' : error.type == 'reason'}">
                <label>输入编辑理由</label>
                <md-input v-model="topic.reason" v-focus="error.type == 'reason'"></md-input>
                <span class="md-helper-text"></span>
                <span class="md-error">必须填写编辑理由才可以提交</span>
              </md-field>
              <md-button class="md-raised md-primary" @click="submitTopic">提交</md-button>
            </div>
          </div>
        </transition>
        <div class="up-info">
          <div class="upload-info md-snackbar" v-for="(upload, index) in uploadImg" v-show.sync="upload.show">
            <div class="upload-info-content"> 
              <div style="display:flex;align-items:center;">
                <div class="pre-img">
                  <img :src="upload.file.miniurl">
                </div>
                <div class="file-info">
                  <p>{{upload.file._name}}</p>
                  <p>{{upload.file.size / 1024}} KB </p>
                </div>
              </div>
              <div class="progress-content" v-show="upload.isProgress">
                <md-progress-bar md-mode="determinate" :md-value="upload.amount"></md-progress-bar>
              </div>
              <div class="buttons" v-show="! upload.isProgress">
                <md-button @click="upImgDelbtn(index, upload.file._name)" class="md-icon-button md-accent">
                  <md-icon>clear</md-icon>
                </md-button>
              </div>
            </div>  
          </div>
        </div>
        <md-snackbar md-position="left" :md-duration="msg.timeout" :md-active.sync="msg.show" md-persistent :class="msg.class">
          <span>{{ msg.info }}</span>
        </md-snackbar>
        </div>
    </div>
</template>

<style lang="scss" scoped>
  .page-container{
    min-height: 100vh;
    padding-top: 64px;
  }
  .edit{
    margin: 32px auto;
  }
  .g-title-line{
    border-bottom:2px solid rgba(231,231,231,.7);
  }
  .up-info{
    position:fixed;
    bottom: 24px;
    left: 24px;
    display: flex;
    flex-direction: column;
    align-content:flex-end;
  }
  .v-note-wrapper{
    z-index: 1;
  }
  .upload-info{
    &.md-snackbar {
      max-height: 176px;
      max-width: 12vw;
      position: static;
      margin-top: 24px;
      background-color: rgba(0,0,0,0);
      .pre-img {
        margin-right: 8px;
        img{
          max-width: 160px;
          max-height: 120px;
        }
      }
      .file-info {
        color: rgba(0,0,0,.87);
        overflow:hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }
    .upload-info-content{
      flex-direction:  column;
      display: flex;
      width: 100%;
    }
    .progress-content {
      margin-top: 8px;
    }
    .buttons {
      position: absolute;
      top: 0px;
      right: -6px;
    }
  }
  .up-down-enter, .up-down-leave-to {
    transform: translateY(-200%);
  }
  .up-down-enter-active{
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
  }
  .up-down-enter-to, .up-down-leave {
    transform: translateY(0);
  }
  .up-down-leave-active{
    transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
  }
  .md-snackbar {
    &.md-primary {
      background-color: var(--md-theme-default-primary, #448aff);
    }
    &.md-accent {
      background-color: var(--md-theme-light-accent,#ff5252);
    }
  }
</style>

<script>
import { mavonEditor } from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'

export default {
  name: 'TopicCreate',
  components: {
    mavonEditor,
  },
  directives: {
    focus: {
      update: function (el, binding) {
        if(binding.value) {
          el.focus()
        }
      }
    }
  },
  data: () => ({
    appData: [], // window.App,
    signIn: false, // window.APP.signIn,
    siteName: '', // window.App.siteName
    topic: [],
    uploadImg: [],
    message: [],
    msg: {
      show: false,
      timeout: 3000,
      info:'',
      class: 'md-primary'
    },
    error: {
      type: null
    }
  }),
  created () {
    this.appData = window.App;
    this.signIn = window.App.signIn
    this.siteName = window.App.siteName
    this.topic = window.App.topicData
  },
  computed: {
  },
  methods: {
    userLogin (user) {
      if( user.id > 0) {
        this.signIn = true
        this.appData.signIn = true
        this.appData.user = user
      }
    },
    logout () {
      let _this = this;
      axios.post('/logout').then( function (res) {
        _this.signIn = false
        _this.appData.signIn = false
        _this.appData.user = []
      });
    },
    submitTopic () {
      console.log(this.topic)
      if( ! this.topic.reason ) {
        // 添加一个出错信息
        this.msg.info = '请输入编辑理由'
        this.msg.show = true
        this.msg.class = 'md-accent'
        this.error.type = 'reason'
        return;
      }
      if(! this.topic.topic_id) {
        this.topic.topic_id = this.topic.id;
        this.topic.id = null
      }
      axios.post('/topic_edit', this.topic).then( function (res) {
        console.log(res)
      })
    },
    refresh_token () {
      // 更新 laravel 的 crsf_token
      axios.get('/crsf_token').then( function (res) {
        console.log(res.data);
      });
    },
    getTopicData () {
      console.log(this.topicData)
    },
    $imgAdd (pos, $file) {
      console.log('上传时的 md 信息')
      console.log(this.$refs.md)
      // 上传图片 
      let formData = new FormData();
        // 向 formData 对象中添加文件
      formData.append('upload_file', $file);
      let _this = this;
      let key = this.showUploading (pos, $file)
      this.uploadFile("upload_image", formData, (res) =>{
        
        let loaded = res.loaded,
            total = res.total;
            _this.uploadImg[key] .isProgress = true;
            _this.$nextTick(() =>{
              _this.uploadImg[key] .amount = (loaded/total) * 100;
            })
        }).then(function (response) {
          if(response.data.success) {
            let imgUrl = response.data.file_path;
            _this.uploadImg[key] .isProgress = false
            _this.uploadImg[key] .imgUrl = imgUrl;
            _this.$refs.md.$img2Url(pos, imgUrl);
            _this.$refs.md.$refs.toolbar_left.$imgUpdateByFilename($file , imgUrl)
          } else {
            // 上传失败的提示
            _this.uploading = false;
            _this.upload_error_message = response.data.msg;
          }
      })
    },
    upImgDel (pos) {
      console.log(pos)
      this.uploadImg.splice(pos, 1)
      
    },
    upImgDelbtn (pos, imgUrl) {
      let fileInfo = this.uploadImg[pos] .file;
      this.$refs.md.$refs.toolbar_left.$imgDelByFilename(fileInfo)
    },
    showUploading (pos, $file) {
      // 添加一个上传消息
      
      let uploadInfo = {
        file: $file,
        show: true,
        amount: 0,
        isProgress: true,
        imgUrl: pos
      }
      this.uploadImg.push(uploadInfo)
      return this.uploadImg.length - 1;
    },
    uploadFile: function (url, data, upProgress) {
      // 执行这个方法时，显示上传进度条
      this.uploading = true;
      let _this = this;
      let config = {
        url: url,
        baseURL: '/',
        transformResponse: [function (data1) {
          var data = data1;
          if (typeof data1 == "string") {
            data = JSON.parse(data1);
          }
          return data;
        }],
        headers: {'Content-Type': "multipart/form-data"},
        withCredentials: true,
        responseType: 'json', //default
        onUploadProgress: function (e) {
          upProgress(e)
        }
      }
      return axios.post(url, data, config);
    }
  }
}
</script>