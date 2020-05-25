import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from './middleware/auth'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/login',
            // TODO: rename to admin.login
            name: 'Login',
            component: () => import('../pages/Login')
        },
        {
            path: '/reset-password',
            name: 'admin.reset-password',
            component: () => import('../pages/Auth/ResetPassword')
        },
        {
            path: '/password-reset/:token/:email',
            name: 'admin.password-reset',
            component: () => import('../pages/Auth/PasswordReset')
        },
        {
            path: '/',
            component: () => import('../layouts/App'),
            async beforeEnter (to, from, next) {
                await auth(to, from, next)
            },
            children: [
                {
                    path: '',
                    name: 'admin.Dashboard',
                    component: () => import('../pages/Dashboard/Index')
                },
                {
                    path: 'profile',
                    name: 'admin.profile',
                    component: () => import('../pages/AdminUsers/Profile')
                },
                {
                    path: 'manage-access/',
                    component: { render: h => h('router-view') },
                    children: [
                        {
                            path: 'admin-users/',
                            component: { render: h => h('router-view') },
                            meta: {
                                permission: 'admin.admin-users'
                            },
                            children: [
                                {
                                    path: '/',
                                    name: 'admin.manage-access.admin-users.index',
                                    component: () => import('../pages/AdminUsers/Index')
                                },
                                {
                                    path: ':id(\\d+)',
                                    name: 'admin.manage-access.admin-users.show',
                                    component: () => import('../pages/AdminUsers/Show')
                                },
                                {
                                    path: 'create',
                                    name: 'admin.manage-access.admin-users.create',
                                    component: () => import('../pages/AdminUsers/Create')
                                },
                            ]
                        },
                        {
                            path: 'roles/',
                            component: { render: h => h('router-view') },
                            meta: {
                                permission: 'admin.roles'
                            },
                            children: [
                                {
                                    path: '/',
                                    name: 'admin.manage-access.roles.index',
                                    component: () => import('../pages/Roles/Index'),
                                    children: [
                                        {
                                            path: ':id',
                                            name: 'admin.manage-access.roles.index.show',
                                            component: () => import('../pages/Roles/Show')
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            path: 'audits/',
                            component: { render: h => h('router-view') },
                            meta: {
                                permission: 'admin.audits'
                            },
                            children: [
                                {
                                    path: '/',
                                    name: 'admin.manage-access.audits.index',
                                    component: () => import('../pages/Audits/Index')
                                }
                            ]
                        }
                    ]
                },
                {
                    path: 'site-settings/',
                    component: { render: h => h('router-view') },
                    meta: {
                        permission: 'admin.settings'
                    },
                    children: [
                        {
                            path: 'site-info',
                            name: 'admin.site-settings.site-info',
                            component: () => import('../pages/Settings/Info')
                        },
                        {
                            path: 'storage',
                            name: 'admin.site-settings.storage',
                            component: () => import('../pages/Settings/Storage')
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
