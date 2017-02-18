<template>
<div class="c-sidebar py-2" @click="onClick">

  <slot></slot>

</div>
</template>

<script lang="babel">
import scrollbar from '../mixins/scrollbar'

export default {
  name: 'Sidebar',

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

  mixins: [scrollbar],
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
        transform: translateX(310px);
      }
    }
  }
}
</style>
