<template>
<abstract-card v-bind="{ remove }" class="c-fee-session-card" @remove="$emit('remove', feeSession)">
  <div class="d-flex flex-row align-items-center">
    <div class="flex-auto">
      <div class="c-fee-session-card-title" :class="{ 'text-muted': !feeSession.name.trim() }">
        {{ feeSession.name.trim() || 'Name not set' }}
      </div>
      <div class="c-fee-session-card-subtitle">
        <slot name="subtitle">
          {{ feeSession.started_at | dateForHumans }} to {{ feeSession.ended_at | dateForHumans }}
        </slot>
      </div>
    </div>

    <slot>
      <icon type="chevron-right" class="text-muted"/>
    </slot>
  </div>
</abstract-card>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { dateForHumans } from '../../filters'

export default {
  props: {
    feeSession: {
      type: Object,
      required: true
    },

    remove: {
      type: Boolean,
      default: false
    }
  },

  computed: mapGetters('sessions', ['sessionById']),

  filters: { dateForHumans }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-fee-session-card {
  &-title {
    font-size: 1.14285rem;
  }

  &-subtitle {
    font-size: .75rem;
  }
}
</style>
