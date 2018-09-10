<template>
  <div class="page-container">
    <md-app md-mode="reveal">
      <geng-header></geng-header>
      <md-app-content><user-login v-if="! signIn"></user-login>
      <div v-else>
        文档编辑框
      </div>
    </md-app-content>
    </md-app>
  </div>
</template>

<style lang="scss" scoped>
  .md-app {
    max-height: 400px;
    border: 1px solid rgba(#000, .12);
  }
</style>

<script>
export default {
  name: 'TopicCreate',
  data: () => ({
    menuVisible: false
  }),
  computed: {
    signIn() {
        return window.App.signIn;
    }
  }
}
</script>