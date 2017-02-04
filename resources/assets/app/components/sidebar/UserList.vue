<template>
<list :items="items"></list>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import List from './List.vue'

export default {
  computed: {
    items () {
      return this.users.map(user => ({
        text: user.name,
        photo: user.photo,
        type: 'rounded-circle',
        class: 'sidebar-list-item-user',
        hasExtra: user.unread > 0,
        extra: user.unread,
        route: { name: 'user.messages', params: { id: user.id }}
      }))
    },
    ...mapGetters('messages/users', ['users'])
  },

  methods: mapActions('messages/users', ['index']),

  created () {
    this.index()
  },

  components: { List }
}
</script>

<style lang="scss">
.card.sidebar-list-item-user {
  background: transparent;
  border-color: transparent;
}
</style>
