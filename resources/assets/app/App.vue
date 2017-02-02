<template>
<div class="app">
  <nav-bar></nav-bar>
  <router-view></router-view>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'

import NavBar from './components/navbar/Navbar.vue'

export default {
  name: 'Zero',

  computed: { ...mapGetters(['user']) },

  methods: {
    ...mapActions(['getUser'])
  },

  created () {
    if (!('id' in this.user)) {
      this.getUser()
    }
  },

  components: { NavBar }
}
</script>

<style lang="scss">
@import 'app';

body {
  background: $gray-lighter;
}
</style>
