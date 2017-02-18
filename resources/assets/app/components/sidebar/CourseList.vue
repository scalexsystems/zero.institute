<template>
<list :items="items" class="mt-3">
  <div class="pl-3 py-1">
    <icon type="paper-plane" class="mr-2"/>
    <strong class="text-uppercase" style="letter-spacing: 1px">Courses</strong>
  </div>
</list>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import List from './List.vue'

export default {
  computed: {
    items () {
      const courses = this.courses
      const sessions = this.sessions
      const groups = this.groups
      const n = sessions.length

      const items = []

      for (let i = 0; i < n; i += 1) {
        items.push({
          text: courses[i].code || '...',
          tip: courses[i].name,
          photo: courses[i].photo,
          type: 'rounded-circle',
          class: 'sidebar-list-item-course',
          hasExtra: groups[i].$has_unread,
          extra: groups[i].$unread_count,
          route: { name: 'course.session', params: { id: sessions[i].id }}
        })
      }

      return items
    },
    groups () {
      return this.sessions.map(session => (this.groupById(session.group_id) || {}))
    },
    courses () {
      return this.sessions.map(session => (this.courseById(session.course_id) || {}))
    },
    ...mapGetters('courses', ['sessions', 'courseById']),
    ...mapGetters('groups', ['groupById'])
  },

  components: { List }
}
</script>

<style lang="scss">
.card.sidebar-list-item-course {
  background: transparent;
  border-color: transparent;
}
</style>
