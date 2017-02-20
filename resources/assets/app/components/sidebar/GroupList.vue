<template>
<list :items="items">
  <router-link :to="{ name: 'group.index' }" class="text-muted btn btn-block btn-link text-left">
    <icon type="puzzle-piece"></icon>
    Join a group
  </router-link>
</list>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import List from './List.vue'

export default {
  computed: {
    items () {
      return this.groups.map(group => ({
        text: group.name,
        photo: group.photo,
        type: 'rounded-circle',
        class: 'sidebar-list-item-group',
        hasExtra: group.$has_unread,
        extra: group.$unread_count,
        route: { name: 'group.messages', params: { id: group.id } },
        last: group.$last_message_id
      })).sort((a, b) => b.last - a.last)
    },
    ...mapGetters('groups', { groups: 'myGroups' })
  },

  components: { List }
}
</script>

<style lang="scss">
.card.sidebar-list-item-group {
  background: transparent;
  border-color: transparent;
}
</style>
