<template>
<div class="dropdown c-navbar-user ml-auto align-self-center">
  <a class="toggler text-white"
     role="button" href="#"
     data-toggle="dropdown"
     aria-haspopup="true"
     aria-expanded="false">
    <div class="d-flex align-items-center">
      <div class="hidden-md-down flex-auto navbar-user-info mr-2">
        <div class="name">{{ user.name }}</div>
        <small class="school text-capitalize"> {{ user.type }}</small>
      </div>

      <img class="rounded-circle" width="28" height="28" :src="user.photo">
    </div>
  </a>

  <div class="dropdown-menu dropdown-menu-right user-menu-dropdown" aria-labelledby="navbar-toggler">

    <div class="dropdown-item hidden-lg-up fl-auto navbar-user-info">
      <div class="name">{{ user.name }}</div>
      <small class="school text-capitalize"> {{ user.type }}</small>
    </div>

    <div class="dropdown-item">
      <router-link :to="route" class="nav-link">View Profile</router-link>
    </div>

    <div class="dropdown-divider"></div>

    <div class="dropdown-item">
      <form method="POST" action="/logout" hidden>
        <input type="hidden" name="_token" :value="token">
        <input type="submit" class="btn-transparent btn-block text-left" ref="logout">
      </form>

      <a class="nav-link" href="#" @click.prevent="$refs.logout.click()">Logout</a>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'

export default {
  computed: {
    token: () => window.Laravel.csrfToken,
    route () {
      return '/profile'
//      return {
//        name: `${this.user.type}.profile`,
//        params: {
//          uid: this.user.uid
//        }
//      }
    },
    ...mapGetters(['user'])
  }
}
</script>


<style lang="scss">
.c-navbar-user {
  line-height: 1.3;

  .dropdown-menu {
    margin-top: 5px;
  }

  .name {
    font-size: to-rem(12px);
  }

  .school {
    font-size: to-rem(10px);
  }

  .toggler {
    &:hover, &:focus, &:active {
      text-decoration: none;
    }
  }

  .dropdown-item {
    cursor: pointer;

    .nav-link {
      color: inherit;
      padding-left: 0;
      padding-right: 0;
    }
  }
}

.btn-transparent {
  background: transparent;
  border-color: transparent;
}
</style>
