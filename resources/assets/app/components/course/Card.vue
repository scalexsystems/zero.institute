<template>
<abstract-card class="c-course-card" v-bind="{ remove }" @remove="$emit('remove', course)">
  <div class="d-flex flex-row align-items-start">
    <div>
      <div class="c-course-card-title">{{ course.code }} - {{ course.name }}</div>
      <div class="c-course-card-subtitle">
        <span class="text-muted">Department:</span> {{ department.name }}
      </div>
    </div>
  </div>

  <slot></slot>
</abstract-card>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'

export default {
  props: {
    course: {
      type: Object,
      required: true
    },

    remove: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    department () {
      return this.departmentById(this.course.department_id) || {}
    },
    ...mapGetters('departments', ['departmentById'])
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-course-card {
  &-photo {
    width: to-rem(48px);
    height: to-rem(48px);
    margin-right: to-rem(10px);
  }

  &-title {
    font-size: 1.14285rem;
  }

  &-subtitle {
    font-size: .75rem;
  }
}
</style>
