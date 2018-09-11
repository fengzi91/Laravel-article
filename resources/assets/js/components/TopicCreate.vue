<template>
  <div class="page-container">
      <geng-header v-bind:appData="appData" v-on:logout="logout" />
        <transition appear name="up-down" appear-class="dropdown-appear-class" appear-to-class="animated slideInDown" leave-to-class="animated slideOutUp" enter-active-class="animated slideInDown" leave-active-class="animated bounceOutRight" mode="out-in">
          <user-login class="user-login" v-if="! signIn" v-bind:appData="appData" v-on:userLogin="userLogin"></user-login>
          <div class="md-layout md-alignment-top-center edit-box" style="margin-top:64px;" v-else>
          <md-card class="md-layout-item md-size-60 md-medium-size-45 md-small-size-50 md-xsmall-size-100">
            <md-card-header>
              <div class="md-title g-title-line">{{topic.title}}</div>
            </md-card-header>

            <md-card-content>
                <mavon-editor v-model="topic.body" :ishljs="false" :boxShadow="false" />

                <md-field>
                  <label>输入编辑理由</label>
                  <md-input></md-input>
                </md-field>
            </md-card-content>

            <md-card-actions md-alignment="left">
              <md-button class="md-raised md-primary" @click="submitTopic">提交</md-button>
            </md-card-actions> 
          </md-card>
          </div>
        </transition>
  </div>
</template>

<style lang="scss" scoped>
  .page-container{
    min-height: 100vh;
    padding-top: 64px;
  }
  .g-title-line{
    border-bottom:2px solid rgba(231,231,231,.7);
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
</style>

<script>
Vue.component('geng-header', require('./GengHeader.vue'));
export default {
  name: 'TopicCreate',
  data: () => ({
    appData: [], // window.App,
    signIn: false, // window.APP.signIn,
    siteName: '', // window.App.siteName
    topic: []
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
      console.log('提交更新')
    },
    refresh_token () {
      // 更新 laravel 的 crsf_token
      axios.get('/crsf_token').then( function (res) {
        console.log(res.data);
      });
    },
    getTopicData () {
      console.log(this.topicData)
    }
  }
}
</script>