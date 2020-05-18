require('./bootstrap')

import Vue from 'vue'
import router from './routes'
import store from './store'
import 'ant-design-vue/dist/antd.css';
import _ from 'lodash'

import AntDesign from 'ant-design-vue'
import Listing from '../common/listing'
import VueMoment from 'vue-moment'

Vue.use(AntDesign)
Vue.use(VueMoment)
Vue.component('listing', Listing)


const app = new Vue({
    el: '#app',
    template: "<router-view />",
    store,
    router
})

Vue.prototype.$can = value => {
   return store.getters['adminUser/can'](value)
}
