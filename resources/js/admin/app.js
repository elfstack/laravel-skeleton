require('./bootstrap')

import Vue from 'vue'
import router from './routes'
import store from './store'
import 'ant-design-vue/dist/antd.css'

import AntDesign from 'ant-design-vue'
import VueMoment from 'vue-moment'
import Viser from 'viser-vue'
import VueMeta from 'vue-meta'

Vue.use(AntDesign)
Vue.use(VueMoment)
Vue.use(Viser)
Vue.use(VueMeta)

const app = new Vue({
    el: '#app',
    template: "<router-view />",
    store,
    router
})

Vue.prototype.$can = value => {
   return store.getters['adminUser/can'](value)
}
