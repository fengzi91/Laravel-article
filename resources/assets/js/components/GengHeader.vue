<template>
	<div>
    <md-toolbar class="md-primary topbar" md-mode="flexible">
      <md-button class="md-icon-button" @click="showNavigation = true">
        <md-icon>menu</md-icon>
      </md-button>
      <span class="md-title" style="flex: 1">{{appData.siteName}}</span>
      <md-menu md-size="medium" style="margin-right: 24px;"md-align-trigger v-if="appData.signIn" >
        <md-avatar md-menu-trigger style="cursor: pointer;">
          <img :src="appData.user.avatar" />
        </md-avatar>
        <md-menu-content>
          <md-menu-item :href="'/users/' + appData.user.id">个人中心</md-menu-item>
          <md-menu-item :href="'/users/' + appData.user.id + '/edit'">编辑资料</md-menu-item>
          <md-menu-item @click="$emit('logout')">退出</md-menu-item>
        </md-menu-content>
      </md-menu>
    </md-toolbar>

    <md-drawer :md-active.sync="showNavigation">
      <md-toolbar class="md-transparent" md-elevation="0">
        <span class="md-title">{{appData.siteName}}</span>
      </md-toolbar>

      <md-list>
        <md-list-item href="/">
          <md-icon>move_to_inbox</md-icon>
          <span class="md-list-item-text">首页</span>
        </md-list-item>

        <md-list-item href="/topics/">
          <md-icon>send</md-icon>
          <span class="md-list-item-text">梗列表</span>
        </md-list-item>
      </md-list>
    </md-drawer>
  </div>
</template>
<script>
	export default {
		name: 'gengHeader',
    props: ['appData'],
    data: () => ({
      showNavigation: false,
      username: '',
    }),
    watch: {
　　　　appData: {
　　　　　　handler(newValue, oldValue) {
　　　　　　 if (newValue.user.name !== null ) {
              this.username = newValue.user.name
          }
　　　　　},
　　　　　　deep: true
　　　　}
    },
    created () {
      if (this.appData.user !== null ) {
        this.username = this.appData.user.name
      }
    },
    methods: {

    }
	}
</script>

<style lang="scss" scoped>
	.appname {
		text-decoration: none;
		&:hover{
			text-decoration:none;
		}
	}
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }
  .topbar {
    position: fixed;
    top: 0;
  }
</style>