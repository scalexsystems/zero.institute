<template>
<div class="c-sidebar" @click="onClick">

  <div class="btn-group flex-row d-flex mt-2">
    <a class="btn" tabindex="-1" role="button" :class="[group ? 'btn-primary' : 'btn-secondary']" @click.prevent="group = true">Groups</a>
    <a class="btn btn-block" tabindex="-1" role="button" :class="[group ? 'btn-secondary' : 'btn-primary']" @click.prevent="group = false">People</a>
  </div>

  <group-list v-show="group"></group-list>
  <user-list v-show="!group"></user-list>
</div>
</template>

<script lang="babel">
import scrollbar from '../mixins/scrollbar'
import GroupList from './GroupList.vue'
import UserList from './UserList.vue'

export default {
  name: 'Sidebar',

  data: () => ({
    group: true
  }),

  computed: {
    scroll: () => true,
    scrollSelector: () => true
  },

  methods: {
    onClick () {
      const classes = document.body.classList

      if (classes.contains('has-sidebar')) {
        classes.remove('has-sidebar')
      } else {
        classes.add('has-sidebar')
      }
    }
  },

  components: { GroupList, UserList },
  mixins: [scrollbar]
}
</script>

<style lang="scss">
@import '../../styles/variables';
@import '../../styles/mixins';

.c-sidebar {
  @include match-parent();
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
}

@include media-breakpoint-down(md) {
  .c-sidebar {
    z-index: $zindex-navbar !important;
    position: fixed !important;
    width: 300px !important;
    left: -300px !important;
    transition: left .3s !important;

    + * {
      transition: transform .3s !important;
    }
  }
  body.has-sidebar {
    .c-sidebar {
      left: 0 !important;
      + * {
        transform: translateX(250px);
      }
    }
  }
}
</style>
