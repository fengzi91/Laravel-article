
window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// 定义 axios 响应拦截器， 响应成功以后刷新 crsf_token
axios.interceptors.response.use(function (response) {
    if (response.status < 400 ) {
    	let method = response.config.method;
    	if (method === 'post' || method === 'put' || method === 'delete') {
    		// 更新 crsf
    		axios.get('/crsf_token').then( function (res) {
    			let token = res.data.token;
    			document.head.querySelector('meta[name="csrf-token"]').content = token;		
    		})
    	}
    }
    return response;
  }, function (error) {
    return Promise.reject(error);
});
// axios 请求拦截器，每次发送需要验证的请求时，带上最新的 token
axios.interceptors.request.use(function (config) {
    config.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content
    return config;
  }, function (error) {
    return Promise.reject(error);
});

window.Vue = require('vue');

import VueMaterial from 'vue-material';

Vue.use(VueMaterial)

import mavonEditor from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'


Vue.component('topic-create', require('./components/TopicCreate.vue'));
Vue.component('user-login', require('./components/UserLogin.vue'));
Vue.component('geng-header', require('./components/GengHeader.vue'));

Vue.use(mavonEditor)

const app = new Vue({
    el: '#app'
});