<template>
  <a-layout>
      <admin-header></admin-header>
      <a-layout-content>
          <router-view></router-view>
      </a-layout-content>
  </a-layout>
</template>

<script>
import Header from './Header'
export default {
  name: "App",
  components: {
    'admin-header': Header
  }
}
</script>

<style scoped>

</style>
