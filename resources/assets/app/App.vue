<template>
<div class="app">
  <nav-bar></nav-bar>
  <router-view></router-view>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex';

import NavBar from './components/Navbar.vue';
import { getters, actions } from './vuex/meta';

export default {
  name: 'App',
  components: { NavBar },
  computed: { ...mapGetters({ user: getters.user }) },
  methods: {
    ...mapActions({ getUser: actions.getUser }),
    ...mapActions('school', ['getDepartments', 'getDisciplines', 'getSemesters']),
  },
  created() {
    if (!('id' in this.user)) {
      this.getUser();
    } else if (this.user && this.user.channel) {
      this.$echo.private(this.user.channel);
    }

    this.getDepartments();
    this.getDisciplines();
    this.getSemesters();
  },
  watch: {
    user() {
      this.$echo.private(this.user.channel);
    },
  },
};
</script>

<style lang="scss">
@import 'app';

body {
  background: $gray-lighter;
}
</style>
