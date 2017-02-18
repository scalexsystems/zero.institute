<template>
<div class="py-3">
  <sidebar-button v-for="item in items" :route="{ name: item.id }" class="sidebar-list-item-settings px-3">{{ item.title }}</sidebar-button>
</div>
</template>

<script lang="babel">
import SidebarButton from '../sidebar/Button.vue'
import items from './items'

export default {
  name: 'SettingsSidebar',

  computed: {
    items: () => items
  },

  components: { SidebarButton }
}
</script>


<style lang="scss">
.card.sidebar-list-item-settings {
  background: transparent;
  border-color: transparent;
}
</style>
