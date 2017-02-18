<template>
<abstract-card v-bind="{ remove, footer }">

  <h6 class="card-title">{{ session.name }} - {{ session.short_name }}</h6>

  <template slot="footer">
  <div class="d-flex flex-row align-items-center text-center">

    <div class="profile-field flex-auto mb-0">
      <div class="label">Start Date</div>
      <div class="value">{{ session.started_on }}</div>
    </div>

    <div class="profile-field flex-auto mb-0">
      <div class="label">Start Date</div>
      <div class="value">{{ session.ended_on }}</div>
    </div>

  </div>
  </template>

</abstract-card>
</template>

<script lang="babel">
export default {
  props: {
    session: {
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