require('./bootstrap')

import Vue from 'vue'
import router from './routes'
import store from './store'
import 'ant-design-vue/dist/antd.css';
import _ from 'lodash'

import AntDesign from 'ant-design-vue'
import Listing from '../common/listing'

Vue.use(AntDesign)
Vue.component('listing', Listing)

router.beforeEach((to, from, next) => {
    to.matched.forEach(route => {
        if (route.meta.permission) {
            let can = store.getters['adminUser/can'](route.meta.permission)
            if (!can) {
                // TODO: abort 403
            }
        }
    })
    next()
})

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
