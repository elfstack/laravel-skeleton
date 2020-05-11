require('./bootstrap');

import Vue from 'vue'
import router from './routes'
import App from './layouts/App'
import 'ant-design-vue/dist/antd.css';

import AntDesign from 'ant-design-vue'
Vue.use(AntDesign)

const app = new Vue({
    render: h => h(App),
    router
}).$mount('#app')
