<template>
<div class="container-zero c-session-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Create Session</h5>

      <div class="ml-auto">
        <input-button class="btn btn-secondary" @click.native="$emit('done')" value="Cancel"/>
        <input-button @click.native="save" value="Create" :class="{ disabled }"/>
      </div>
    </div>

    <div class="card-block flex-auto">
      <alert v-autofocus v-if="formStatus" type="danger" v-html="formStatus"/>

      <form class="row" @submit.prevent="save">
        <input type="submit" hidden>

        <div class="col-12 col-lg-6">
          <input-text title="Name" v-model="attributes.name" :errors="errors" required autofocus/>
        </div>

        <div class="col-12 col-lg-6">
          <input-typeahead title="Semester" v-model="attributes.semester_id" :suggestions="sessions" :errors="errors" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" title="Start Date" v-model="attributes.started_on" :errors="errors" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" title="End Date" v-model="attributes.ended_on" :errors="errors" required/>
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import { formHelper } from 'bootstrap-for-vue'
import throttle from 'lodash.throttle'

export default {
  name: 'EditSession',

  data: () => ({
    attributes: {
      name: '',
      semester_id: 0,
      started_on: '',
      ended_on: ''
    },

    disabled: false
  }),

  computed: mapGetters('sessions', ['sessions']),

  methods: {
    async save () {
      this.clearErrors()

      this.disabled = true
      const { errors, session } = await this.store(this.attributes)
      this.disabled = false

      if (session) {
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    ...mapActions('sessions', ['store']),
  },

  mixins: [formHelper]
}
</script>


<style lang="scss"></style>
