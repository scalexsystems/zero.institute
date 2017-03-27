<template>
<div class="py-3">

  <div class="pl-3 py-1">
    <icon type="cog" class="mr-2"/>
    <strong class="text-uppercase" style="letter-spacing: 1px">Settings</strong>
  </div>

  <sidebar-button v-for="item in items" :key="item" :route="{ name: item.id }" class="sidebar-list-item-settings px-3">{{ item.title }}</sidebar-button>
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
