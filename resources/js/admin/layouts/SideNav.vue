<template>
<<<<<<< HEAD
    <a-layout-sider
        width="256"
        v-model="collapsed"
        collapsible
    >
        <router-link to="/">
            <div class="logo h4 center" style="color: #fff;">{{ !collapsed ? 'Laravel Skeleton' : 'LS' }}</div>
        </router-link>
=======
    <a-layout-sider width="256">
>>>>>>> d346664... feat: admin login in/out
        <a-menu
            style="width: 256px"
            theme="dark"
            :default-selected-keys="['1']"
            :open-keys.sync="openKeys"
            mode="inline"
            @click="handleClick"
        >
            <a-sub-menu key="sub1" @titleClick="titleClick">
                <span slot="title"><a-icon type="mail" /><span>Navigation One</span></span>
                <a-menu-item-group key="g1">
                    <template slot="title"> <a-icon type="qq" /><span>Item 1</span> </template>
                    <a-menu-item key="1">
                        Option 1
                    </a-menu-item>
                    <a-menu-item key="2">
                        Option 2
                    </a-menu-item>
                </a-menu-item-group>
                <a-menu-item-group key="g2" title="Item 2">
                    <a-menu-item key="3">
                        Option 3
                    </a-menu-item>
                    <a-menu-item key="4">
                        Option 4
                    </a-menu-item>
                </a-menu-item-group>
            </a-sub-menu>
            <a-sub-menu key="sub2" @titleClick="titleClick">
                <span slot="title"><a-icon type="appstore" /><span>Navigation Two</span></span>
                <a-menu-item key="5">
                    Option 5
                </a-menu-item>
                <a-menu-item key="6">
                    Option 6
                </a-menu-item>
                <a-sub-menu key="sub3" title="Submenu">
                    <a-menu-item key="7">
                        Option 7
                    </a-menu-item>
                    <a-menu-item key="8">
                        Option 8
                    </a-menu-item>
                </a-sub-menu>
            </a-sub-menu>
            <a-sub-menu key="sub4">
<<<<<<< HEAD
                <span slot="title"><a-icon type="lock" /><span>Manage Access</span></span>
                <a-menu-item key="9">
                    <router-link to="/manage-access/admin-users">Admin Users</router-link>
                </a-menu-item>
                <a-menu-item key="10">
                    <router-link to="/manage-access/roles">Roles & Permissions</router-link>
                </a-menu-item>
                <a-menu-item key="11">
                    Action Log
=======
                <span slot="title"><a-icon type="setting" /><span>Navigation Three</span></span>
                <a-menu-item key="9">
                    Option 9
                </a-menu-item>
                <a-menu-item key="10">
                    Option 10
                </a-menu-item>
                <a-menu-item key="11">
                    Option 11
                </a-menu-item>
                <a-menu-item key="12">
                    Option 12
>>>>>>> d346664... feat: admin login in/out
                </a-menu-item>
            </a-sub-menu>
        </a-menu>
    </a-layout-sider>
</template>

<script>
    export default {
        name: "SideNav",
            data() {
                return {
<<<<<<< HEAD
                    current: [],
                    openKeys: [],
                    collapsed: false
=======
                    current: ['mail'],
                    openKeys: ['sub1'],
>>>>>>> d346664... feat: admin login in/out
                };
            },
            watch: {
                openKeys(val) {
                    console.log('openKeys', val);
                },
            },
            methods: {
                handleClick(e) {
                    console.log('click', e);
                },
                titleClick(e) {
                    console.log('titleClick', e);
                },
            },

    }
</script>

<style scoped>
<<<<<<< HEAD
    .logo {
        height: 64px;
        line-height: 64px;
    }
=======

>>>>>>> d346664... feat: admin login in/out
</style>
