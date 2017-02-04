<template>
<div class="c-navbar-apps dropdown align-self-center">
  <a href="#" class="btn navbar-toggler"
     data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"
     data-target="#apps-dropdown">
    <img src="../../assets/apps.svg" height="18" width="18" alt="Menu">
  </a>

  <div class="dropdown-menu dropdown-menu-right">
    <router-link v-for="app in apps" class="app dropdown-item d-flex flex-row py-2 align-items-center" :to="app.link" :ref="app">
      <img :src="app.icon" class="icon mr-2">
      <div class="label">{{ app.name }}</div>
    </router-link>
  </div>
</div>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'

const APPS = [
  { name: 'Hub', link: '/hub', icon: require('../../assets/apps/hub.svg') },
  { name: 'People', link: '/people', icon: require('../../assets/apps/people.svg'), permission: 'app.people' },
  { name: 'Academics', link: '/academics', icon: require('../../assets/apps/academics.svg'), permission: 'app.academics' },
  { name: 'Finances', link: '/finances', icon: require('../../assets/apps/finance.svg'), permission: 'app.finance' },
  { name: 'Institute', link: '/settings', icon: require('../../assets/apps/people.svg'), permission: 'app.settings' }
]

export default {
  computed: {
    apps () {
      const permissions = this.permissions

      return APPS.filter(app => !app.permission || permissions[app.permission] === true)
    },

    permissions () {
      return { 'app.people': true }
    }
  }
}
</script>


<style lang="scss">
@import '../../styles/methods';

.c-navbar-apps {
  .dropdown-menu {
    margin-top: 9px;
  }
  .app {
    min-width: 250px;
    .icon {
      width: to-rem(28px);
      height: to-rem(28px);
    }
  }
}
</style>
