<template>
<div class="c-navbar-apps dropdown d-flex align-self-center ml-auto">
  <user-icon class="navbar-toggler px-0"
             aria-haspopup="true" role="button" aria-expanded="false"
             data-toggle="dropdown"
             data-target="#apps-dropdown"/>


  <div class="dropdown-menu dropdown-menu-right">

    <router-link v-for="app in apps" :key="app" class="app dropdown-item d-flex flex-row py-2 align-items-center"
                 :to="app.link"
                 :ref="app">
      <img :src="app.icon" class="icon mr-2">
      <div class="label">{{ app.name }}</div>
    </router-link>

    <div class="dropdown-divider"></div>

    <div class="dropdown-item">
      <router-link to="/profile" class="nav-link no-link">View Profile</router-link>
    </div>

    <div class="dropdown-item">
      <form method="POST" action="/logout" hidden>
        <input type="hidden" name="_token" :value="token">
        <input type="submit" class="btn-transparent btn-block text-left" ref="logout">
      </form>

      <a class="nav-link no-link" href="#" @click.prevent="$refs.logout.click()">Logout</a>
    </div>

  </div>
</div>
</template>

<script lang="babel">
import UserIcon from './User.vue'
import { mapGetters } from 'vuex'

const APPS = [
  {
    name: 'The Hub',
    link: '/hub',
    icon: require('../../assets/apps/hub.svg')
  },
  {
    name: 'Course Management',
    link: '/hub/courses',
    icon: require('../../assets/apps/course.svg'),
    permission: 'course.app'
  },
  {
    name: 'People & Statistics',
    link: '/people',
    icon: require('../../assets/apps/people.svg'),
    permission: 'people.app'
  },
  {
    name: 'Academics',
    link: '/academics',
    icon: require('../../assets/apps/academics.svg'),
    permission: 'academics.app'
  },
  {
    name: 'Finances',
    link: '/finance',
    icon: require('../../assets/apps/finance.svg'),
    permission: 'finance.app'
  },
  {
    name: 'Institute Settings',
    link: '/settings',
    icon: require('../../assets/apps/settings.svg'),
    permission: 'settings.app'
  }
]

export default {
  name: 'NavApps',

  computed: {
    apps () {
      const permissions = this.permissions

      return APPS.filter(app => !app.permission || permissions.indexOf(app.permission) > -1)
    },

    token: () => window.Laravel.csrfToken,

    permissions () {
      return this.user.permissions
    },

    ...mapGetters(['user'])
  },

  components: { UserIcon }
}
</script>


<style lang="scss">
@import '../../styles/methods';

.c-navbar-apps {
  .dropdown-menu {
    margin-top: 2px;
    max-height: calc(100vh - #{$navbar-height});
  }
  .app {
    min-width: 250px;
    .icon {
      width: to-rem(28px);
      height: to-rem(28px);
    }
  }
}

.btn-transparent {
  background: transparent;
  border-color: transparent;
}
</style>
