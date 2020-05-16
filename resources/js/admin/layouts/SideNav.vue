<template>
    <a-layout-sider
        width="256"
        v-model="collapsed"
        collapsible
    >
        <div class="logo h4 center" style="color: #fff;">{{ !collapsed ? 'Laravel Skeleton' : 'LS' }}</div>
        <a-menu
            theme="dark"
            :open-keys.sync="openKeys"
            v-model="selectedKeys"
            mode="inline"
        >
            <a-sub-menu key="sub1">
                <span slot="title"><a-icon type="mail"/><span>Navigation One</span></span>
                <a-menu-item-group key="g1">
                    <template slot="title">
                        <a-icon type="qq"/>
                        <span>Item 1</span></template>
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

            <a-sub-menu key="ManageAccess">
                <span slot="title"><a-icon type="lock"/><span>Manage Access</span></span>
                <a-menu-item key="AdminUsers" v-if="$can('admin.admin-users')">
                    <router-link to="/manage-access/admin-users">Admin Users</router-link>
                </a-menu-item>
                <a-menu-item key="Roles" v-if="$can('admin.roles')">
                    <router-link to="/manage-access/roles">Roles & Permissions</router-link>
                </a-menu-item>
                <a-menu-item key="Audits" v-if="$can('admin.audits')">
                    <router-link to="/manage-access/audits">Action Log</router-link>
                </a-menu-item>
            </a-sub-menu>

            <a-sub-menu key="site-settings">
                <span slot="title"><a-icon type="setting"/><span>Site Settings</span></span>
                <a-menu-item key="site-info">
                    <router-link to="/site-settings/site-info">Site Info</router-link>
                </a-menu-item>
                <a-menu-item key="clear-cache">
                    <router-link to="/site-settings/cache">Clear Cache</router-link>
                </a-menu-item>
                <a-menu-item key="manage-storage">
                    <router-link to="/site-settings/storage">Manage Storage</router-link>
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
                openKeys: [],
                selectedKeys: [],
                collapsed: false
            }
        },
        created() {
            const routes = this.$route.matched.map(route => route.name)
            this.openKeys = [routes[1]]
            this.selectedKeys = [routes[2]]
        }
    }
</script>

<style scoped>
    .logo {
        height: 64px;
        line-height: 64px;
    }
</style>
