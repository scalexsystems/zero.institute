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
      <div class="dropdown-item" @click="showSessionCreate = true">
        <icon type="plus-circle" class="text-muted mr-2"/>
        Add new session
      </div>

      <div class="dropdown-divider"></div>

      <router-link v-for="s in activeSessions" :key="s"
                   active-class="active" replace tag="div"
                   class="dropdown-item py-2 justify-content-between"
                   :to="{ name: 'fee-session.show', params: { id: s.id } }">
        {{ s.name }} <span class="badge badge-success badge-pill ml-2">active</span>
      </router-link>

      <router-link v-for="s in oldSessions" :key="s"
                   active-class="active" replace tag="div"
                   class="dropdown-item py-2 justify-content-between"
                   :to="{ name: 'fee-session.show', params: { id: s.id } }">
        {{ s.name }}
      </router-link>

    </div>
  </div>
  </template>

  <div v-if="isSessionFetched">
    <div class="bg-faded">
      <div class="container pt-3">
        <div class="row">

          <div class="col-12 col-lg-8 mb-3">
            <transaction-summary-card :session="session"/>
          </div>

          <div class="col-12 col-lg-4 mb-3">
            <fee-session-summary-card :session="session"/>
          </div>

        </div>
      </div>
    </div>

    <modal class="ps-child" v-if="showTransactionModal" open @close="showTransactionModal = false" :dismissable="false">
      <div class="container-zero">
        <create-transaction :fee-session="session_id" @done="showTransactionModal = false"/>
      </div>
    </modal>

    <paginator :value="paginator" bottom @next="fetchTransactions" class="mb-3">
      <div class="container-zero my-3">
        <div class="d-flex flex-row mb-3">
          <h2>Transactions</h2>

          <input-button class="ml-auto" icon="plus-circle" value="Add new" @click.native="showTransactionModal = true"/>
        </div>

        <transaction-card v-for="transaction in transactions" :key="transaction" v-bind="{ transaction }"/>
      </div>
    </paginator>
  </div>

  <loading v-else/>


  <modal v-if="showSessionCreate" open :dismissable="false">
    <div class="container-zero">
      <session-create @done="showSessionCreate = false"/>
    </div>
  </modal>
</container>
</template>

<script lang="babel">
import { directive as onClickAway } from 'vue-clickaway'
import { mapActions, mapGetters } from 'vuex'
import FeeSessionSummaryCard from '../../components/fee-session/Summary.vue'
import TransactionSummaryCard from '../../components/fee-session/TransactionSummary.vue'
import TransactionCard from '../../components/fee-session/Transaction.vue'
import CreateTransaction from '../../components/fee-session/CreateTransaction.vue'
import SessionCreate from '../../components/fee-session/Create.vue'

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
    showTransactionModal: false,
    showSessionCreate: false,
    paginator: {},
    transactions: [{ id: 1 }]
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
      setTimeout(() => {
        this.transactions.push({ id: this.transactions.length })

        done()

      }, 400)
    },

    ...mapActions('feeSessions', ['find', 'index'])
  },

  created () {
    if (!this.isSessionFetched) this.find(this.session_id)
    if (!this.allSessions.length) this.index()
  },

  components: {
    FeeSessionSummaryCard, TransactionSummaryCard, TransactionCard,
    CreateTransaction, SessionCreate
  },

  directives: { onClickAway }
}
</script>


<style lang="scss">
@import '../../styles/variables';
</style>
