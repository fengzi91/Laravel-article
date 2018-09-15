<template>
	<div class="page-container">
		<geng-header v-bind:appData="appData" v-bind:headerInfo="headerInfo" v-on:logout="logout" v-on:back="$back"></geng-header>
		<transition appear name="up-down" appear-class="dropdown-appear-class" appear-to-class="animated slideInDown" leave-to-class="animated slideOutUp" enter-active-class="animated slideInDown" leave-active-class="animated bounceOutRight" mode="out-in">
			<div class="md-layout md-alignment-top-center edit-box" style="margin:64px auto;">
            <div class="md-layout-item md-size-60 md-medium-size-45 md-small-size-50 md-xsmall-size-100">	
            	<div class="md-headline g-title-line">{{appData.topicData.title}}</div>
            	<div class="md-caption subline">
              		<md-icon>person</md-icon>{{topic.userinfo.name}} <md-icon>access_time</md-icon>{{topic.time}}
            	</div>
            	<div class="md-body-1" v-html="topic.body"></div>
            	<div>
            		<md-button class="md-accent md-raised" disabled>
            			审核状态：{{topic.status_text}}
            		</md-button>
            		<template v-if="topic.status === 0 && cancheck">
            			<md-button @click="check('on')" class="md-raised md-primary">通过审核</md-button>
            			<md-button @click="check('off')" class="md-raised md-accent">拒绝</md-button>
            		</template>
            		<md-button :href="'/topic_edit/' + topic.id + '/edit'" class="md-raised md-primary" v-if="isauthor">编辑</md-button>
            	</div>
            </div>
        	</div>
       </transition>
       <md-snackbar md-position="left" :md-duration="msg.timeout" :md-active.sync="msg.show" md-persistent :class="msg.class">
          <span>{{ msg.info }}</span>
        </md-snackbar>
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
  .subline{
  	margin-top:8px;
  }
  .g-title-line{
    border-bottom:2px solid rgba(231,231,231,.7);
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
export default {
  name: 'TopicShow',
  data: () => ({
  	topic: [],
  	headerInfo: {
      leftbtn: 'back'
    },
    msg: {
      show: false,
      timeout: 3000,
      info:'',
      class: 'md-primary'
    },
    cancheck:0,
    isauthor:0,
  }),
  created () {
    this.appData = window.App
    this.signIn = window.App.signIn
    this.siteName = window.App.siteName
    this.topic = window.Topic
    this.cancheck = window.cancheck
    this.isauthor = window.isauthor
  },
  methods: {
  	logout () {

  	},
  	$back () {

  	},
  	check (type) {
  		let _this = this
  		let id = this.topic.id;
  		let tid = this.appData.topicData.id;
  		axios.get('/topic_edit/' + tid + '/check/' + id + '/' + type).then( function (res) {
  			if ( res.data.error > 0) {
  				_this.msg.info = res.data.message
        		_this.msg.show = true
        		_this.msg.class = 'md-accent'
  			} else {
  				_this.msg.info = res.data.message
        		_this.msg.show = true
  			}
  		})
  	}
  }
}
</script>
