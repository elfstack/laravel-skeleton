require('./bootstrap');

import Vue from 'vue'
import router from './routes'
import store from './store'
import 'ant-design-vue/dist/antd.css';

import AntDesign from 'ant-design-vue'
Vue.use(AntDesign)

const app = new Vue({
    el: '#app',
    template: "<router-view />",
    store,
    router
})
