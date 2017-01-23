<template>
<div class="content-box">
  <div class="content-box-content" :class="[contentClass]">
    <slot></slot>
  </div>
  <div class="content-box-sidebar" :class="[stateClass, sidebarClass]">
    <slot name="sidebar"></slot>
  </div>
</div>
</template>

<script lang="babel">
import { bool } from '../util';

export default {
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    contentClass: String,
    sidebarClass: String,
  },
  computed: {
    stateClass() {
      const state = this.open;

      return bool(state) === true ? 'open' : undefined;
    },
  },
};
</script>

<style lang="scss">
@import '../styles/variables';

$content-box-sidebar-width: 360px !default;

.content-box {
  display: flex;
  flex-direction: row;

  overflow-x: hidden;
  overflow-y: auto;
}

.content-box-content {
  flex: 1 0 100%;
}

.content-box-sidebar {
  flex: 0 0 $content-box-sidebar-width;
  width: $content-box-sidebar-width;
  transition: margin 300ms ease-in-out;

  &.open {
    margin-left: -$content-box-sidebar-width;
  }
}
</style>
