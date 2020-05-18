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
            <a-sub-menu key="manage-access">
                <span slot="title"><a-icon type="lock"/><span>Manage Access</span></span>
                <a-menu-item key="admin-users" v-if="$can('admin.admin-users')">
                    <router-link to="/manage-access/admin-users">Admin Users</router-link>
                </a-menu-item>
                <a-menu-item key="roles" v-if="$can('admin.roles')">
                    <router-link to="/manage-access/roles">Roles & Permissions</router-link>
                </a-menu-item>
                <a-menu-item key="audits" v-if="$can('admin.audits')">
                    <router-link to="/manage-access/audits">Action Log</router-link>
                </a-menu-item>
            </a-sub-menu>

            <a-sub-menu key="site-settings" v-if="$can('admin.settings')">
                <span slot="title"><a-icon type="setting"/><span>Site Settings</span></span>
                <a-menu-item key="site-info">
                    <router-link to="/site-settings/site-info">Site Info</router-link>
                </a-menu-item>
                <a-menu-item key="storage">
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
            const name = this.$route.name.split('.')
            this.openKeys = [name[1]]
            this.selectedKeys = [name[2]]
        }
    }
</script>

<style scoped>
    .logo {
        height: 64px;
        line-height: 64px;
    }
</style>
