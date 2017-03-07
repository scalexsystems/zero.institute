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
          <input-typeahead input-name="session_id" v-model="attributes.session_id" title="Session" :suggestions="sessions" v-bind="{ errors }" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" input-name="started_at" v-model="attributes.started_at" title="Start Date" v-bind="{ errors }" required subtitle="yes">
            <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
          </input-text>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" input-name="ended_at" v-model="attributes.ended_at" title="End Date" v-bind="{ errors }" required subtitle="yes"
                      :min="attributes.started_at">
            <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
          </input-text>
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
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'CreateFeeSession',

  resource: 'fee_session',

  data: () => ({
    attributes: {
      name: '',
      started_at: '',
      ended_at: '',
      session_id: '',
    },

    title: 'Create Fee Session'
  }),

  computed: mapGetters('sessions', ['sessions']),

  methods: {
    onCreate () {
      return this.store(this.attributes)
    },

    onCreated () {
      this.$emit('done')
    },

    ...mapActions('feeSessions', ['store'])
  },

  mixins: [resource]
}
</script>
