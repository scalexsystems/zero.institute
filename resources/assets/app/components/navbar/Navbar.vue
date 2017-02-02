<template>
<nav class="navbar fixed-top navbar-dark bg-accent">
  <div class="container navbar-container d-flex">
    <a role="button" class="navbar-brand nav-sidebar hidden-lg-up" tabindex @click="$root.$emit('sidebar')">
      <icon class="fa-fw" type="bars"/>
    </a>

    <router-link to="/" class="navbar-brand nav-zero">
      <img src="../../assets/logo.svg" alt="Zero">
    </router-link>

    <navbar-search class="flex-auto"></navbar-search>

    <navbar-user></navbar-user>
    <navbar-apps></navbar-apps>
  </div>
</nav>
</template>

<script lang="babel">
import NavbarApps from './Apps.vue'
import NavbarSearch from './Search.vue'
import NavbarUser from './User.vue'

export default {
  name: 'Navbar',

  components: { NavbarApps, NavbarSearch, NavbarUser }
}
</script>

<style lang="scss">
@import '../../styles/methods';
@import '../../styles/mixins';

$navbar-height: 46px !default;

.bg-accent {
  background: $brand-accent;
}

.navbar {
  border-top: 2px solid black;
  padding: to-rem(1px) 1rem to-rem(3px);
}

.navbar-brand {
  text-overflow: ellipsis;
  white-space: nowrap;
  margin-right: 0;
  img {
    width: to-rem(35px);
    height: to-rem(35px);
  }
}

.navbar-text {
  padding: 0;
  color: white;
  align-items: center;
}

@include media-breakpoint-down(md) {
  .navbar {
    padding-left: 0;
    padding-right: 0;
  }
  .navbar-container {
    width: 100%;
  }
}

body {
  padding-top: $navbar-height;

  .nav-zero {
    display: inline-flex !important;
  }

  .nav-sidebar {
    color: white;
    font-size: to-rem(28px);
    display: none !important;
  }

  @include media-breakpoint-down(md) {
    &.has-sidebar {
      .nav-zero {
        display: none !important;
      }

      .nav-sidebar {
        display: inline-flex !important;
      }
    }
  }
}
</style>
