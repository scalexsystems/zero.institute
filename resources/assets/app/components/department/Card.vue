<template>
<abstract-card v-bind="{ remove, footer }">

  <h6 class="card-title">{{ department.name }} - {{ department.short_name }}</h6>

  <small class="text-muted d-block">
    Head of Department: {{ department.head.name || '...' }}
  </small>

  <template slot="footer">
  <div class="d-flex flex-row align-items-center text-center">

    <div class="profile-field flex-auto mb-0">
      <div class="label">Students</div>
      <div class="value">{{ department.stats.student }}</div>
    </div>

    <div class="profile-field flex-auto mb-0">
      <div class="label">Teachers</div>
      <div class="value">{{ department.stats.teacher }}</div>
    </div>

    <div class="profile-field flex-auto mb-0">
      <div class="label">Employees</div>
      <div class="value">{{ department.stats.employee }}</div>
    </div>

  </div>
  </template>

</abstract-card>
</template>

<script lang="babel">
export default {
  props: {
    department: {
      type: Object,
      required: true
    },

    remove: {
      type: Boolean,
      default: false
    },

    footer: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style lang="scss"></style>
