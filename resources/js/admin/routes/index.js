import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: () => import('../pages/dashboard/Index')
        }
    ]
})

export default router
