<template lang="html">
<div class="card">
  <div class="card-header bg-white">
    <h5 class="my-2">{{ title }}</h5>
  </div>

  <div class="card-block">
    <form-component>

      <div class="row">

        <div class="col-12 col-lg-6">
          <input-text input-name="name" v-model="attributes.name" title="Name" v-bind="{ errors }" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-typeahead input-name="session_id" v-model="attributes.session_id" title="Session"
                           :suggestions="sessions" v-bind="{ errors }" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" input-name="started_at" v-model="attributes.started_at" title="Start Date"
                      v-bind="{ errors }" required subtitle="yes">
            <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
          </input-text>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" input-name="ended_at" v-model="attributes.ended_at" title="End Date"
                      v-bind="{ errors }" required subtitle="yes"
                      :min="attributes.started_at">
            <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
          </input-text>
        </div>

        <div class="col-12 mt-3 d-flex flex-row">
          <input-button @click.native.stop="onFormDelete" value="Delete" variant="outline-danger"/>
          <div class="ml-auto">
            <input-button @click.native="$emit('done')" value="Cancel" variant="secondary"/>
            <input-button type="submit" value="Create"/>
          </div>
        </div>

      </div>

    </form-component>
  </div>
</div>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import Create from './Create.vue'
import { only, dateIsoToInput } from '../../util'

export default {
  name: 'EditFeeSession',

  extends: Create,

  props: {
    feeSession: {
      type: Object,
      required: true
    }
  },

  data: () => ({ title: 'Edit Fee Session' }),

  methods: {
    setAttributes() {
      this.attributes = only(this.feeSession, Object.keys(this.attributes))
      this.attributes.started_at = dateIsoToInput(this.attributes.started_at)
      this.attributes.ended_at = dateIsoToInput(this.attributes.ended_at)
    },

    onUpdate () {
      return this.update({ id: this.feeSession.id, attributes: this.attributes })
    },

    onUpdated () {
      this.$debug('updated!', new Error())
      this.$emit('done')
    },

    onDelete () {
      return this.delete(this.feeSession.id)
    },

    onDeleted() {
      this.$emit('done')
    },

    ...mapActions('feeSessions', ['update', 'delete']),
  },

  created () {
    this.setAttributes()
  }
}
</script>


<style lang="scss">

</style>
