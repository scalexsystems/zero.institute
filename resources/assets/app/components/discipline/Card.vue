<template>
<abstract-card v-bind="{ remove, footer }">

  <h6 class="card-title">{{ discipline.name }} - {{ discipline.short_name }}</h6>

  <template slot="footer">
  <div class="d-flex flex-row align-items-center text-center">

    <div class="profile-field flex-auto mb-0">
      <div class="label">Students</div>
      <div class="value">{{ discipline.stats.student }}</div>
    </div>

  </div>
  </template>

</abstract-card>
</template>

<script lang="babel">
export default {
  props: {
    discipline: {
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
