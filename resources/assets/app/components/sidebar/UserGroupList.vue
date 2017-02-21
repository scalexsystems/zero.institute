<template>
<div>
  <div class="btn-group d-flex flex-row align-items-end mb-3">
    <div class="btn btn-block" role="button" :class="[group ? 'btn-secondary' : 'btn-outline-secondary']"
         @click.stop="group = true">
      <icon v-if="group_unread_count > 0" type="circle" class="text-primary"/> Groups
    </div>
    <div class="btn btn-block" role="button" :class="[group ? 'btn-outline-secondary' : 'btn-secondary']"
         @click.stop="group = false">
      <icon v-if="user_unread_count > 0" type="circle" class="text-primary"/> People
    </div>
  </div>

  <group-list v-show="group"/>
  <user-list v-show="!group"/>
</div>

</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import UserList from './UserList.vue'
import GroupList from './GroupList.vue'

export default {
  name: 'UserGroupList',

  data: () => ({
    group: true
  }),

  computed: {
    ...mapGetters('groups', { group_unread_count: 'unread_total' }),

    ...mapGetters('messages', { user_unread_count: 'unread_total' })
  },

  methods: {
    isGroup () {
      if (this.$route.name === 'group.messages') {
        this.group = true
      } else if (this.$route.name === 'user.messages') {
        this.group = false
      }
    }
  },

  created () {
    this.isGroup()
  },

  components: { UserList, GroupList },

  watch: {
    $route () {
      this.isGroup()
    }
  }
}
</script>
