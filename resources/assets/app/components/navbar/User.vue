<template>
<a class="c-navbar-user text-white"
   role="button" href="#"
   data-toggle="dropdown"
   aria-haspopup="true"
   aria-expanded="false">
  <div class="d-flex align-items-center">
    <div class="hidden-md-down d-flex flex-column mr-2 text-right">
      <div class="name">{{ user.name }}</div>
      <small class="school text-capitalize">{{ user.type }} @ {{ user.school.name }}</small>
    </div>

    <img class="rounded fit-cover" width="32" height="32" :src="user.photo">
  </div>
</a>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'

export default {
  name: 'NavUser',

  computed: mapGetters(['user'])
}
</script>


<style lang="scss">
@import '../../styles/methods';

.c-navbar-user {
  line-height: 1.3;

  .name {
    font-size: to-rem(12px);
  }

  .school {
    font-size: to-rem(10px);
  }
  &:hover, &:focus, &:active {
    text-decoration: none;
  }
}
</style>
