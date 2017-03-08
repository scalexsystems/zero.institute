<template lang="html">
<div class="card c-fee-session-summary">
  <div class="card-block">

    <h5 class="card-title">{{ session.name }}</h5>

    <div class="progress m-3">
      <div class="progress-bar" role="progressbar" style="height: 4px;" :style="{ width: progress + '%' }"
           :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="row">
      <div class="col-6">{{ session.started_at | dateForHumans }}</div>
      <div class="col-6 text-right">{{ session.ended_at | dateForHumans }}</div>
    </div>

    <div class="btn-group my-2 d-flex">
      <a class="btn btn-secondary flex-auto" target="_blank" rel="noreferrer">
        <icon type="external-link"/>
        Fee Details
      </a>
      <input-button variant="secondary" icon="edit" value="Edit"/>
    </div>

    <input-button icon="paper-plane" value="Send Reminder" class="btn-block"/>
  </div>
</div>
</template>

<script lang="babel">
import { dateForHumans } from '../../filters'
import moment from 'moment'

export default {
  name: 'SessionSummary',

  props: {
    session: {
      type: Object,
      required: true,
    }
  },

  computed: {
    progress () {
      const start = moment(this.session.started_at, moment.ISO_8601, true)
      const end = moment(this.session.ended_at, moment.ISO_8601, true)
      const today = moment(new Date())

      if (today.isBefore(start)) return 0
      if (today.isAfter(end)) return 100

      const total = end.diff(start, 'days')
      const passed = today.diff(start, 'days')

      this.$debug(total, passed)

      return (passed / total * 100).toFixed(2)
    }
  },

  filters: { dateForHumans }
}
</script>


<style lang="scss">
.c-fee-session-summary {
  height: 100%;
}
</style>
