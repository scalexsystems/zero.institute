<template>
<div class="container-zero c-session-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Create Session</h5>

      <div class="ml-auto">
        <input-button class="btn btn-secondary" @click.native="$emit('done')" value="Cancel"/>
        <input-button @click.native="edit" value="Save" :class="{ disabled }"/>
      </div>
    </div>

    <div class="card-block flex-auto">
      <alert v-autofocus v-if="formStatus" type="danger" v-html="formStatus"/>

      <form class="row" @submit.prevent="edit">
        <input type="submit" hidden>

        <div class="col-12 col-lg-6">
          <input-text title="Name" v-model="attributes.name" :errors="errors" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-typeahead title="Short Code" v-model="attributes.semester_id" :suggestions="semesters"
                           :errors="errors"/>
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
import { mapActions } from 'vuex'
import Create from './Create.vue'
import { only } from '../../util'

export default {
  name: 'EditSession',

  extends: Create,

  props: {

    session: {
      type: Object,
      required: true
    }

  },

  methods: {

    async edit () {
      this.clearErrors()

      this.disabled = true
      const { errors, session } = await this.update({ id: this.session.id, payload: this.attributes })
      this.disabled = false

      if (session) {
        this.$emit('done')
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    ...mapActions('sessions', ['update'])
  },

  created () {
    this.attributes = only(this.session, Object.keys(this.attributes))
  }
}
</script>
