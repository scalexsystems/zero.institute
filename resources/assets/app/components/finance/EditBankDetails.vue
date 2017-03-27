<template lang="html">

<div class="card">
  <div class="card-header bg-white">
    <h5 class="my-2">Institute Bank Details</h5>
  </div>

  <div class="card-block">
    <form-component>
      <div class="row">

        <div class="col-12">
          <input-text v-model="attributes.name" title="Name of the account holder" required autofocus/>
        </div>

        <div class="col-12">
          <input-text v-model="attributes.bank" title="Name of the bank" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text v-model="attributes.account_number" title="Account Number" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text v-model="attributes.ifsc_code" title="IFSC Code" required/>
        </div>

        <div class="col-12 mt-3 text-right">
          <input-button @click.native="$emit('done')" value="Cancel" variant="secondary"/>
          <input-button type="submit" value="Create"/>
        </div>

      </div>
    </form-component>
  </div>
</div>

</template>

<script lang="babel">
import resource from '../mixins/resource'

export default {
  name: 'EditBankDetails',

  resource: 'item',

  data: () => ({
    attributes: {
      name: '',
      bank: '',
      account_number: '',
      ifsc_code: '',
    }
  }),

  methods: {

    onUpdate () {
    },

    onUpdated () {
      this.$emit('done')
    },
  },

  mixins: [resource]
}
</script>

<style lang="scss"></style>
