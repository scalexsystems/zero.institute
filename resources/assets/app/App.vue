<template>
<div class="app">
  <nav-bar></nav-bar>
  <keep-alive>
    <router-view></router-view>
  </keep-alive>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import { each } from './util'

import NavBar from './components/navbar/Navbar.vue'

export default {
  name: 'Zero',

  computed: mapGetters({ user: 'user', groups: 'groups/my' }),

  methods: mapActions({
    getDepartments: 'departments/index',
    getDisciplines: 'disciplines/index',
    getSemesters: 'semesters/index',
    getSessions: 'sessions/index',
    getGroups: 'groups/my',
    getMyCourses: 'courses/my',
    getCourses: 'courses/index'
  }),

  created () {
    if (!this.user || !('id' in this.user)) {
      throw new Error('Although impossible! But there is no user!')
    }

    this.$echoAlias(`private:${this.user.channel}`, 'user')
    this.$echoAlias(`presence:${this.user.school.channel}`, 'school')

    this.$channel('user')
    this.$channel('school')

    // School specific.
    // TODO: Improve performance here.
    this.getCourses()
    this.getSessions()
    this.getDepartments()
    this.getDisciplines()
    this.getSemesters()

    // User specific.
    this.getGroups()
    this.getMyCourses()
  },

  components: { NavBar },

  watch: {
    groups (groups) {
      each(groups, group => this.$channel(`presence:${group.channel}`, undefined, group))
    }
  }
}
</script>

<style lang="scss">
@import 'app';

body {
  background: $gray-lighter;
}
</style>
