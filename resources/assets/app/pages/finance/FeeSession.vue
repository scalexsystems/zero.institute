<template lang="html">
<container v-bind="{ title: session.name || '...' }" class="p-finance-fee-session" back @back="$router.go(-1)"
           subtitle="Edit fee structure, set start and end date and track every student’s payment history">

  <template slot="buttons">
  <div v-on-click-away="() => (showSessionDropdown = false)" class="dropdown" :class="{ show: showSessionDropdown }"
       :selected="[]">
    <input-button @click.native="showSessionDropdown = !showSessionDropdown" variant="secondary">
      <icon type="calendar-o"/>
      <span class="hidden-md-down">Switch Sessions</span>
      <icon :type="showSessionDropdown ? 'chevron-up' : 'chevron-down'" class="text-muted ml-3 hidden-md-down"/>
    </input-button>

    <div class="dropdown-menu dropdown-menu-right mt-2">
      <div class="dropdown-item">
        <icon type="plus-circle" class="text-muted mr-2"/>
        Add new session
      </div>

      <div class="dropdown-divider"></div>

      <div class="dropdown-item py-2 justify-content-between" v-for="s in activeSessions" :key="s">
        {{ s.name }} <span class="badge badge-success badge-pill ml-2">active</span>
      </div>

      <div class="dropdown-item py-2 justify-content-between" v-for="s in oldSessions" :key="s">
        {{ s.name }}
      </div>

    </div>
  </div>
  </template>

  <div v-if="isSessionFetched">
    <div class="bg-faded">
      <div class="container py-3">
        <div class="row">

          <div class="col-12 col-lg-8">
          </div>

          <div class="col-12 col-lg-4">
            <fee-session-summary-card :session="session"/>
          </div>

        </div>
      </div>
    </div>

    <div class="container-zero py-3">
      <paginator :value="paginator" bottom @next="fetchTransactions">

      </paginator>
    </div>
  </div>

  <loading v-else/>
</container>
</template>

<script lang="babel">
import { directive as onClickAway } from 'vue-clickaway'
import { mapActions, mapGetters } from 'vuex'
import FeeSessionSummaryCard from '../../components/fee-session/Summary.vue'
export default {
  name: 'FeeSession',

  props: {
    session_id: {
      type: Number,
      required: true,
    }
  },

  data: () => ({
    showSessionDropdown: false,
    paginator: {}
  }),

  computed: {
    session () {
      return this.findById(this.session_id) || {}
    },

    isSessionFetched () {
      return 'id' in this.session
    },

    ...mapGetters('feeSessions', {
      activeSessions: 'active',
      oldSessions: 'old',
      allSessions: 'sessions',
      findById: 'feeSessionById',
    })
  },

  methods: {
    onSessionChange (session) {
      this.$debug(session)
    },

    fetchTransactions ({ done }) {
      setTimeout(done, 4000)
    },

    ...mapActions('feeSessions', ['find', 'index'])
  },

  created () {
    if (!this.isSessionFetched) this.find(this.session_id)
    if (!this.allSessions.length) this.index()
  },

  components: { FeeSessionSummaryCard },

  directives: { onClickAway }
}
</script>


<style lang="scss">
@import '../../styles/variables';
</style>
