<template lang="html">
<div class="card">
  <div class="card-header bg-white">
    <h5 class="my-2">Add offline transaction</h5>
  </div>

  <div class="card-block">
    <form-component>
      <div class="row">

        <div class="col-12">
          <input-student v-model="attributes.student_id" input-name="student_id"
                         title="Paid by" subtitle="Name of the student."
                         autofocus required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-typeahead v-model="attributes.payment_method"
                           title="Mode of payment" :suggestions="paymentModes"
                           required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="number" v-model="attributes.amount" step="0.01"
                      title="Amount" subtitle="In rupees (INR)" min="0"
                      required/>
        </div>

        <div class="col-12" v-if="attributes.payment_method === 'cash'">
          <input-employee v-model="attributes.accountant_id" title="Collected By" subtitle="Name of the accountant."/>
        </div>

        <div class="col-12" v-else-if="attributes.payment_method === 'cheque'">
          <input-text v-model="attributes.cheque_number" title="Cheque Number" required/>
        </div>

        <div class="col-12" v-else-if="attributes.payment_method === 'dd'">
          <input-text v-model="attributes.dd_number" title="Demand Draft Number" required/>
        </div>

        <div class="col-12">
          <input-textarea v-model="attributes.remark" title="Remarks"/>
        </div>

        <div class="col-12 text-right mt-3">
          <input-button value="Cancel" variant="secondary" @click.native="$emit('done')"/>
          <input-button type="submit" value="Add Transaction"/>
        </div>

      </div>
    </form-component>
  </div>
</div>
</template>

<script lang="babel">
import resource from '../mixins/resource'
import InputStudent from '../student/InputStudent.vue'
import InputEmployee from '../employee/InputEmployee.vue'
import { mapActions } from 'vuex'
import { only } from '../../util'

export default {
  name: 'CreateTransaction',

  resource: 'fee_payment',

  props: {
    feeSession: {
      type: Number,
      required: true,
    }
  },

  data: () => ({
    attributes: {
      student_id: 0,
      payment_method: '',
      amount: '',
      accountant_id: 0,
      cheque_number: '',
      dd_number: '',
      remark: '',
    }
  }),

  computed: {
    paymentModes: () => ([
      { id: 'cash', name: 'Cash' },
      { id: 'dd', name: 'Demand Draft' },
      { id: 'cheque', name: 'Cheque' },
    ])
  },

  methods: {
    onCreate () {
      const attributes = only(this.attributes, ['student_id', 'payment_method', 'amount', 'remark'])

      switch (this.attributes.payment_method) {
        case 'cash':
          attributes.accountant_id = this.attributes.accountant_id
          break
        case 'dd':
          attributes.dd_number = this.attributes.dd_number
          break
        case 'cheque':
          attributes.cheque_number = this.attributes.cheque_number
          break
      }

      return this.offline({
        id: this.feeSession,
        attributes,
      })
    },

    onCreated (transaction) {
      this.$emit('created', transaction)
      this.$emit('done')
    },

    ...mapActions('feeSessions', ['offline'])
  },

  components: { InputStudent, InputEmployee },

  mixins: [resource]
}
</script>


<style lang="scss">

</style>
