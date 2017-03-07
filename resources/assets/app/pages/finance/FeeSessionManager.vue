<template lang="html">
<container title="Fee Sessions" subtitle="Manage fee sessions." back @back="$router.go(-1)"
           class="p-finance-fee-session-manager">

  <template slot="buttons">
  <input-button @click.native="bankDetails = true" value="Institute Bank Details" variant="secondary"/>
  </template>

  <modal v-if="bankDetails" open :dismissable="false">
    <div class="container-zero">
      <edit-bank-details @done="bankDetails = false"/>
    </div>
  </modal>

  <modal v-if="creating" open :dismissable="false">
    <div class="container-zero">
      <session-create @done="creating = false"/>
    </div>
  </modal>

  <modal v-if="updating" open :dismissable="false">
    <div class="container-zero">
      <session-edit @done="updating = false" :fee-session="cursor"/>
    </div>
  </modal>

  <div v-if="initialFetchDone" class="container-zero my-3">
    <div class="row">

      <div v-if="!activeFeeSessions.length" class="col-12">
        <div class="card">
          <div class="card-block">
            <div class="row">

              <div class="col-12 col-lg-8 offset-lg-2 text-center">

                <img class="m-3" src="../../assets/finance/fee/inactive.svg">

                <h2>Fee Payment Inactive</h2>

                <p>Add new session by entering start and end date for allowing students to pay fees.
                  Students will be notified on start date.</p>

                <input-button value="Add new session" class="mb-3" @click.native="creating = true"/>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div v-if="activeFeeSessions.length" class="col-12 text-muted text-uppercase split-header my-3">Active Sessions
      </div>
      <div class="col-12 col-lg-4" v-for="feeSession in activeFeeSessions" :key="feeSession">
        <fee-session-card v-bind="{ feeSession }" role="button" @click.native="browseSession(feeSession)"/>
      </div>

      <div v-if="futureFeeSessions.length" class="col-12 text-muted text-uppercase split-header my-3">Future Sessions
      </div>
      <div class="col-12 col-lg-4" v-for="feeSession in futureFeeSessions" :key="feeSession">
        <fee-session-card v-bind="{ feeSession }">
          <input-button variant="link" class="text-muted px-0" @click.native="editSession(feeSession)">
            <icon type="edit"/>
          </input-button>
        </fee-session-card>
      </div>

      <div v-if="oldFeeSessions.length" class="col-12 text-muted text-uppercase split-header my-3">Old Sessions</div>
      <div class="col-12 col-lg-4" v-for="feeSession in oldFeeSessions" :key="feeSession">
        <fee-session-card v-bind="{ feeSession }" role="button" @click.native="browseSession(feeSession)"/>
      </div>

    </div>
  </div>
  <loading v-else/>

</container>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import SessionCreate from '../../components/fee-session/Create.vue'
import SessionEdit from '../../components/fee-session/Edit.vue'
import FeeSessionCard from '../../components/fee-session/Card.vue'
import EditBankDetails from '../../components/finance/EditBankDetails.vue'
import moment from 'moment'

export default {
  name: 'FeeSessionManager',

  data: () => ({
    creating: false,
    updating: false,
    bankDetails: false,
    cursor: null,
    initialFetchDone: false
  }),

  computed: mapGetters('feeSessions', {
    activeFeeSessions: 'active',
    oldFeeSessions: 'old',
    futureFeeSessions: 'future',
    feeSessions: 'sessions'
  }),

  methods: {
    editSession (session) {
      this.cursor = session
      this.updating = true
    },

    browseSession (session) {
      this.$router.push({ name: 'fee-session.show', params: { id: session.id } })
    },

    ...mapActions('feeSessions', ['index'])
  },

  created () {
    if (!this.initialFetchDone) {
      this.index().then(() => {
        this.initialFetchDone = true
      })
    }
  },

  components: { SessionCreate, SessionEdit, FeeSessionCard, EditBankDetails }
}
</script>

<style lang="scss">
@import "../../styles/variables";

.p-finance-fee-session-manager {
  .body {
    background: $gray-lighter;
  }
}
</style>
