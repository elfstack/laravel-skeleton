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

const action = _.debounce(function (status) {
    switch (status) {
        case 401:
            if (router.currentRoute.name !== 'Login') {
                app.$message.warning('Logged out')
                router.push('/login');
            }
            break;
        case 403:
            // todo
            app.$message.error('You don\'t have permission to do this')
            break;
        case 500:
            // todo
            app.$message.error('Server error')
            break;
    }
}, 200)

window.axios.interceptors.response.use(undefined, error => {
    action(error.response.status)

    return Promise.reject(error)
})

Vue.prototype.$can = value => {
   return store.getters['adminUser/can'](value)
}
