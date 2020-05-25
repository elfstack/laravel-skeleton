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
    import Header from './Header'
    import SideNav from "./SideNav";
    export default {
        name: "App",
        components: {
            'admin-header': Header,
            'admin-side-nav': SideNav
        },
        metaInfo: {
            // if no subcomponents specify a metaInfo.title, this title will be used
            title: 'Page',
            // all titles will be injected into this template
            titleTemplate: '%s | Laravel Skeleton'
        },
        data () {
            return {
                loading: true
            }
        }
    }
</script>

<style scoped>

</style>
