<template>
	<div class="g-login-box md-layout md-alignment-top-center">
		<div class="md-layout-item md-medium-size-33 md-small-size-25 md-xsmall-size-0">
		</div>
		<div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
			<md-card>
				<md-card-header>
        			<div class="md-title">登录{{appData.siteName}}</div>
      			</md-card-header>
      			<md-card-content>
					<md-autocomplete v-model="email" :md-options="emailSearch">
				      <label>邮箱</label>
				    </md-autocomplete>
		    		<md-field>
		      			<label>密码</label>
		      			<md-input v-model="password" type="password"></md-input>
		    		</md-field>
		    		<md-button @click="userLogin" class="md-raised md-primary g-login-btn">登 录</md-button>
		    	</md-card-content>
    		</md-card>
		</div>
		<div class="md-layout-item md-medium-size-33 md-small-size-25 md-xsmall-size-0">
		</div>
		<md-snackbar md-position="left" :md-duration="timeout" :md-active.sync="showMsg" md-persistent>
      		<span>{{loginMsg}}</span>
    	</md-snackbar>
	</div>
</template>

<style lang="scss" scoped>
  .g-login-box{
    margin-top: 64px;
  }
  .g-login-btn{
  	margin-left: 0;
  }
</style>

<script>
	export default {
		name: 'UserLogin',
    	props: ['appData'],
    	data: () => ({
      		email: '',
      		password: '',
      		emailList: [
      			'@qq.com',
      			'@163.com',
      			'@126.com',
      			'@gmail.com',
      			'@sina.com.cn',
      			'@vip.qq.com'
      		],
      		emailSearch:[],
      		showMsg: false,
      		loginMsg: '',
      		timeout: 3000,
    	}),
    	watch: {
    		email(value) {
    			var _this = this;
    			if ( ! /[\.@]/ .test(value)) {
    				_this.emailSearch = []
    				if (value !== '') {
    					this.emailList.forEach(function (item) {
    						_this.emailSearch.push(value + item);
    					})
    				}
    			}
    		}
    	},
    	methods: {
    		userLogin () {
    			this.showMsg = false
    			if (this.email == '' || this.password == '') {
    				this.showMsg = true
    				this.loginMsg = '请输入用户名和密码'
    				return;
    			}
    			// 登录操作
    			let _this = this;
    			axios.post('/login',
    				{
    					email: this.email,
    					password: this.password
    				}, 
    				{
    					responseType: 'json'
    				})
    			.then(function (responsed) {
    				_this.$emit('userLogin', responsed.data)
    			})
    			.catch(function (error) {
    				if (error.response) {
      					let errorData = error.response.data;
      					_this.showMsg = true
      					_this.loginMsg = errorData.errors.email[0]
    				}
    			})
    		}
    	}
	}
</script>
