<template>
<div>
  <div class="btn-group flex-row d-flex mb-3">
    <div class="btn" role="button" :class="[group ? 'btn-secondary' : 'btn-outline-secondary']" @click="group = true">
      Groups
    </div>
    <div class="btn btn-block" role="button" :class="[group ? 'btn-outline-secondary' : 'btn-secondary']"
         @click="group = false">People
    </div>
  </div>

  <group-list v-show="group"/>
  <user-list v-show="!group"/>
</div>

</template>

<script lang="babel">
import UserList from './UserList.vue'
import GroupList from './GroupList.vue'

export default {
  name: 'UserGroupList',

  data: () => ({
    group: true
  }),

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