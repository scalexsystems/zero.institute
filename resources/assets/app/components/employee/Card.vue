<template>
<abstract-card v-bind="{ remove }" class="c-employee-card" @remove="$emit('remove', employee)">
  <div class="d-flex flex-row align-items-center">
    <img :src="employee.photo" class="rounded-circle c-employee-card-photo fit-cover">
    <div>
      <div class="c-employee-card-title" :class="{ 'text-muted': !employee.name.trim() }">{{ employee.name.trim() || 'Name not set' }}
      </div>
      <div class="c-employee-card-subtitle">
        <span class="text-muted">Employee ID:</span> {{ employee.uid }} <br>
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
    employee: {
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
      return this.departmentById(this.employee.id) || {}
    },
    ...mapGetters('departments', ['departmentById'])
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-employee-card {
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
