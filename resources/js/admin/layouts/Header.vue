<template>
    <a-layout-header class="header">
        <a-row type="flex"
               justify="space-between">
            <a-col><div class="logo h4" style="color: #fff;">Laravel Skeleton</div></a-col>
            <a-col style="color: #fff">
                <a-dropdown :trigger="['click']">
                    <div @click="e => e.preventDefault()">
                        <a-avatar size="large" icon="user" />
                        <span class="ml1">
                            {{ adminUser.name }} <a-icon type="down" />
                        </span>
                    </div>
                    <a-menu slot="overlay">
                        <a-menu-item key="0">
                            <a href="http://www.alipay.com/">1st menu item</a>
                        </a-menu-item>
                        <a-menu-item key="1">
                            <a href="http://www.taobao.com/">2nd menu item</a>
                        </a-menu-item>
                        <a-menu-divider />
                        <a-menu-item key="3" @click="logout">
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

<style scoped>

</style>
