<template>
  <div class="c-sidebar-list">
    <slot></slot>

    <sidebar-button v-for="item of items" v-bind="item" :key="item" :class="item.class">
      {{ item.text }}
    </sidebar-button>
  </div>
</template>

<script lang="babel">
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
