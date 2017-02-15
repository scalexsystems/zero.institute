<template>
<div class="app">
  <nav-bar></nav-bar>
  <router-view></router-view>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import { each } from './util'

import NavBar from './components/navbar/Navbar.vue'

export default {
  name: 'Zero',

  computed: { ...mapGetters(['user']), ...mapGetters('groups', { groups: 'my' }) },

  methods: {
    ...mapActions('departments', { getDepartments: 'index' }),
    ...mapActions('disciplines', { getDisciplines: 'index' }),
    ...mapActions('semesters', { getSemesters: 'index' }),
    ...mapActions('groups', { getGroups: 'my' }),
  },

  created () {
    if (!this.user || !('id' in this.user)) {
      throw new Error('Although impossible! But there is no user!')
    }

    this.$echoAlias(`private:${this.user.channel}`, 'user')
    this.$echoAlias(`presence:${this.user.school.channel}`, 'school')

    this.$channel('user', ['Scalex.Zero.Events.Message.NewMessage'])
    this.$channel('school')

    this.getDepartments()
    this.getDisciplines()
    this.getSemesters()
    this.getGroups()
  },

  components: { NavBar },

  watch: {
    groups (groups) {
      each(
          groups,
          group => this.$channel(`presence:${group.channel}`, [
            'Scalex.Zero.Events.Message.NewMessage'
          ], group)
      )
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
