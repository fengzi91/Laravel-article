window.Vue = require('vue');
Vue.component('topic-create', require('./components/TopicCreate.vue'));

import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';
Vue.use(VueMaterial)
const app = new Vue({
    el: '#app'
});