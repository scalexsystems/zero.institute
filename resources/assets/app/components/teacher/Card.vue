<template>
<abstract-card v-bind="{ remove }" class="c-teacher-card" @remove="$emit('remove', teacher)">
  <div class="d-flex flex-row align-items-center">
    <img :src="teacher.photo" class="rounded-circle c-teacher-card-photo fit-cover">
    <div>
      <div class="c-teacher-card-title" :class="{ 'text-muted': !teacher.name.trim() }">{{ teacher.name.trim() || 'Name not set' }}
      </div>
      <div class="c-teacher-card-subtitle">
        <span class="text-muted">Teacher ID:</span> {{ teacher.uid }} <br>
        <span class="text-muted">Department:</span> {{ department.name || 'Not set' }}
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
    teacher: {
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
      return this.departmentById(this.teacher.id) || {}
    },
    ...mapGetters('departments', ['departmentById'])
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-teacher-card {
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
