<template>
<list :items="items">
  <router-link :to="{ name: 'dm' }" class="text-muted btn btn-block btn-link text-left">
    <icon type="plus-square-o"></icon> Send a DM
  </router-link>
</list>
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
        hasExtra: user.$has_unread,
        extra: user.$unread_count,
        route: { name: 'user.messages', params: { id: user.id }}
      }))
    },
    ...mapGetters('messages', { users: 'users' })
  },

  methods: mapActions('messages', { index: 'index' }),

  created () {
    if (!this.users.length) {
      this.index()
    }
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
