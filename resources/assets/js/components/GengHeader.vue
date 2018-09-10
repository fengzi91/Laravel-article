<template>
	<div>
		<md-toolbar class="md-transparent">
      		<md-button class="md-icon-button" @click="menuVisible = !menuVisible">
          		<md-icon>menu</md-icon>
        	</md-button>
      		<a href="/" class="appname"><h2 class="md-title">{{sitename}}</h2></a>
    	</md-toolbar>
    	<md-app-drawer :md-active.sync="menuVisible">
        	<md-toolbar class="md-transparent" md-elevation="0">Navigation</md-toolbar>

        	<md-list>
          		<md-list-item>
            		<md-icon>move_to_inbox</md-icon>
            		<span class="md-list-item-text">Inbox</span>
          		</md-list-item>

          		<md-list-item>
            		<md-icon>send</md-icon>
            		<span class="md-list-item-text">Sent Mail</span>
          		</md-list-item>
        </md-list>
      	</md-app-drawer>
	</div>
</template>
<script>
	export default {
		name: 'gengHeader',
		  data: () => ({
    		menuVisible: false,
    		sitename: window.App.siteName
  		}),
		computed: {
    		siteName() {
        	return window.App.siteName;
    	}
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
	.md-app {
    	max-height: 400px;
    	border: 1px solid rgba(#000, .12);
  	}

   // Demo purposes only
  	.md-drawer {
    	width: 230px;
    	max-width: calc(100vw - 125px);
  	}
</style>