<template>
    <Navbar/>
    <router-view></router-view>
</template>

<script>
import Navbar from './components/Navbar.vue'
export default{
    components:{
        Navbar,
    },
    watch: {
    // watch for changes to the current route's meta property
    $route(to, from) {
      // update the page title with the new meta title
        document.title = to.meta.title || 'My Website' // set default title if no meta title is provided
    }
  }
}
</script>
<style>
</style>
