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
                    path: '',
                    name: 'Dashboard',
                    component: () => import('../pages/dashboard/Index')
                },
                {
                    path: 'profile',
                    name: 'AdminUsersProfile',
                    component: () => import('../pages/AdminUsers/Profile')
                },
                {
                    path: 'manage-access',
                    component: { render: h => h('router-view') },
                    children: [
                        {
                            path: 'admin-users',
                            component: { render: h => h('router-view') },
                            meta: {
                                permission: 'admin.admin-users'
                            },
                            children: [
                                {
                                    path: '/',
                                    name: 'AdminUsersIndex',
                                    component: () => import('../pages/AdminUsers/Index')
                                },
                                {
                                    path: '/:id(\\d+)',
                                    name: 'AdminUsersShow',
                                    component: () => import('../pages/AdminUsers/Show')
                                },
                                {
                                    path: '/create',
                                    name: 'AdminUsersCreate',
                                    component: () => import('../pages/AdminUsers/Create')
                                },
                            ]
                        },
                        {
                            path: 'roles',
                            component: { render: h => h('router-view') },
                            meta: {
                                permission: 'admin.roles'
                            },
                            children: [
                                {
                                    path: '/',
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
                        }
                    ]
                },
                {
                    path: '/403',
                    name: '403',
                    component: () => import('../pages/Error/403')
                },
                {
                    path: '/not-found',
                    name: '404',
                    component: () => import('../pages/Error/404')
                },
                {
                    path: '*',
                    redirect: '/not-found'
                }
            ]
        },
    ]
})

export default router
