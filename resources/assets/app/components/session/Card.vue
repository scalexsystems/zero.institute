<template>
<abstract-card v-bind="{ remove, footer }">

  <h6 class="card-title mb-0">
    <icon type="flash" v-if="session.current" v-tooltip="'Current Session'" class="float-right"/>

    {{ session.name }}

    <span class="text-muted" v-if="session.name !== session.original_name">({{ session.original_name }})</span>
  </h6>

  <template slot="footer">
  <div class="d-flex flex-row align-items-center text-center">

    <div class="profile-field flex-auto mb-0">
      <div class="label">Start Date</div>
      <div class="value">{{ session.started_on | dateForHumans }}</div>
    </div>

    <div class="profile-field flex-auto mb-0">
      <div class="label">Start Date</div>
      <div class="value">{{ session.ended_on | dateForHumans }}</div>
    </div>

  </div>
  </template>

</abstract-card>
</template>

<script lang="babel">
import { dateForHumans } from '../../filters'

export default {
  name: 'SessionCard',

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
  },

  filters: { dateForHumans }
}
</script>
