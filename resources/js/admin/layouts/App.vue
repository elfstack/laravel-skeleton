<template>
  <a-layout>
      <admin-side-nav></admin-side-nav>
      <a-layout>
          <admin-header></admin-header>
          <a-layout>
              <a-layout-content>
                  <router-view></router-view>
              </a-layout-content>
          </a-layout>
      </a-layout>
  </a-layout>
</template>

<script>
    import { mapActions } from 'vuex'
    import Header from './Header'
    import SideNav from "./SideNav";
    export default {
        name: "App",
        components: {
            'admin-header': Header,
            'admin-side-nav': SideNav
        },
        created () {
            this.getAdminUser()
        },
        methods: {
            ...mapActions('adminUser', [
                'getAdminUser'
            ])
        }
    }
</script>

<style scoped>

</style>
