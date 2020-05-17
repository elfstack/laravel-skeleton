<template>
    <a-layout-header class="header" style="padding: 0 24px">
        <a-row type="flex"
               justify="space-between">
            <a-col></a-col>
            <a-col>
                <a-dropdown :trigger="['click']">
                    <div @click="e => e.preventDefault()">
                        <a-avatar size="large" :src="adminUser.avatar_url" v-if="adminUser.avatar_url"/>
                        <a-avatar size="large" icon="user" v-else/>
                        <span class="ml1">
                            {{ adminUser.name }} <a-icon type="down" />
                        </span>
                    </div>
                    <a-menu slot="overlay">
                        <a-menu-item key="0">
                            <router-link :to="{ name: 'AdminUsersProfile' }">My Profile</router-link>
                        </a-menu-item>
                        <a-menu-divider />
                        <a-menu-item key="1" @click="logout">
                            Logout
                        </a-menu-item>
                    </a-menu>
                </a-dropdown>
            </a-col>
        </a-row>
    </a-layout-header>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    export default {
        name: "Header",
        computed: {
            ...mapGetters('adminUser', [
                'adminUser'
            ])
        },
        methods: {
            ...mapActions('adminUser', [
                'logout'
            ])
        }
    }
</script>

<style scoped lang="less">
.header {
    background: #fff;
    top: 0;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important
}
</style>
