<template>
  <div class="c-sidebar-list">
    <slot></slot>

    <sidebar-button v-for="(item, index) of items" v-bind="{ key: item, ...item }"></sidebar-button>
  </div>
</template>

<script>
import SidebarButton from './Button.vue'

export default {
  name: 'SidebarList',

  props: {
    items: {
      type: Array,
      required: true
    }
  },

  components: { SidebarButton }
}
</script>
