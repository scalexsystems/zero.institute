<template>
<abstract-card class="c-course-card" v-bind="{ remove, footer: true }" @remove="$emit('remove', course)">
  <h6 class="mb-0 card-title">{{ course.name }}</h6>

  <template slot="footer">
  <div class="d-flex flex-row">
    <div class="profile-field mb-0 mr-3">
      <div class="label">Code</div>
      <div class="value">{{ course.code }}</div>
    </div>

    <div class="profile-field flex-auto mb-0">
      <div class="label">Department</div>
      <div class="value">{{ department.name }}</div>
    </div>
  </div>
  </template>
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