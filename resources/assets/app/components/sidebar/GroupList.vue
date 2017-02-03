<template>
<list :items="items">
  <router-link :to="{ name: 'group.index' }" class="text-muted btn btn-block btn-link text-left">
    <icon type="plus-square-o"></icon> Join a group
  </router-link>
</list>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import List from './List.vue'

export default {
  computed: {
    items () {
      return this.groups.map(group => ({
        text: group.name,
        photo: group.photo,
        type: 'rounded-circle',
        class: 'sidebar-list-item-group',
        hasExtra: group.unread > 0,
        extra: group.unread,
        route: { name: 'group.messages', params: { id: group.id } }
      }))
    },
    ...mapGetters('messages/groups', ['groups'])
  },

  methods: mapActions('messages/groups', ['index']),

  created () {
    this.index()
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