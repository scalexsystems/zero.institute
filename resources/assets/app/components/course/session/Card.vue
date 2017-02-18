<template>
<abstract-card class="c-course-session-card" v-bind="{ remove, footer: true }" @remove="$emit('remove', course)">
  <div class="d-flex flex-column">
    <div class="c-course-session-card-title card-title" :class="{ 'text-muted': !session.name }">
      {{ session.name || 'Session name not set' }}
    </div>
    <div class="c-course-session-card-subtitle">
      <span class="text-muted">Instructed by:</span>
      <teacher-card class="border-0" :teacher="session.instructor"/>
    </div>
  </div>

  <slot></slot>

  <template slot="footer">
  <div class="d-flex flex-row align-items-center">

    <div class="profile-field mb-0 flex-auto text-center">
      <div class="label">Start Date</div>
      <div class="value">{{ session.started_on | dateForHumans }}</div>
    </div>

    <div class="profile-field mb-0 flex-auto text-center">
      <div class="label">End Date</div>
      <div class="value">{{ session.ended_on | dateForHumans }}</div>
    </div>

  </div>
  </template>
</abstract-card>
</template>

<script lang="babel">
import { dateForHumans } from '../../../filters'
import TeacherCard from '../../teacher/Card.vue'

export default {
  props: {
    session: {
      type: Object,
      required: true
    },

    remove: {
      type: Boolean,
      default: false
    }
  },

  filters: { dateForHumans },

  components: { TeacherCard }
}
</script>

<style lang="scss">
.c-course-session-card {
  &-title {
    font-size: 1.14285rem;
  }

  &-subtitle {
    font-size: .75rem;
  }
}
</style>
