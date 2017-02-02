<template>
<div class="c-sidebar">
  <group-list></group-list>
</div>
</template>

<script lang="babel">
import GroupList from './GroupList.vue'

export default {
  name: 'Sidebar',

  components: { GroupList }
}
</script>