<template>
<abstract-card v-bind="{ remove }" class="c-student-card" @remove="$emit('remove', student)">
  <div class="d-flex flex-row align-items-center">
    <img :src="student.photo" class="rounded-circle c-student-card-photo fit-cover">
    <div>
      <div class="c-student-card-title" :class="{ 'text-muted': !student.name.trim() }">{{ student.name.trim() || 'Name not set' }}
      </div>
      <div class="c-student-card-subtitle">
        <span class="text-muted">Roll Number:</span> {{ student.uid }} <br>
        {{ department.name || 'Not set' }}
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
    student: {
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
      const student = this.student

      return this.departmentById(student.department_id) || {}
    },
    ...mapGetters('departments', ['departmentById'])
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-student-card {
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

  &-block {
    padding: .64286rem .71429rem;
  }
}
</style>
