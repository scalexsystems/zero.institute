<template>
<abstract-card class="c-course-session-card" v-bind="{ remove }" @remove="$emit('remove', course)">
  <div class="d-flex flex-row align-items-center">
    <div>
      <div class="c-course-session-card-title" :class="{ 'text-muted': !session.name }">{{ session.name || 'Session name not set'
        }}
      </div>
      <p class="mb-1">
        {{ session.started_on | dateForHumans }} to {{ session.ended_on | dateForHumans }}
      </p>
      <div class="c-course-session-card-subtitle">
        <span class="text-muted">Instructed by:</span>
        <teacher-card class="border-0" :teacher="session.instructor" />
      </div>
    </div>
  </div>

  <slot></slot>
</abstract-card>
</template>

<script lang="babel">
import moment from 'moment'
import { mapGetters } from 'vuex'
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

  filters: {
    dateForHumans (value) {
      return value ? moment(value).format('D MMMM YYYY') : ''
    }
  },

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