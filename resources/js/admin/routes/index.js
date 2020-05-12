import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: () => import('../pages/Login')
        },
        {
            path: '/',
            component: () => import('../layouts/App'),
            children: [
                {
                    path: '/',
                    name: 'Dashboard',
                    component: () => import('../pages/dashboard/Index')
                },
                {
                    path: '/manage-access/admin-users',
                    name: 'AdminUsersIndex',
                    component: () => import('../pages/AdminUsers/Index')
                },
                {
                    path: '/manage-access/roles',
                    name: 'RolesIndex',
                    component: () => import('../pages/Roles/Index'),
                    children: [
                        {
                            path: ':id',
                            name: 'RoleShow',
                            component: () => import('../pages/Roles/Show')
                        }
                    ]
                }
            ]
        },

    ]
})

export default router
