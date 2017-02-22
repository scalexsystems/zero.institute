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
          <input-typeahead title="Semester" v-model="attributes.semester_id" :suggestions="semesters" :errors="errors" autofocus required />
        </div>

        <div class="col-12 col-lg-6">
          <input-text title="Name" subtitle="Choose semester & dates, it would be auto-generated."
                      v-model="attributes.name" :errors="errors" :readonly="true"/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" title="Start Date" v-model="attributes.started_on" :errors="errors" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-text type="date" title="End Date" v-model="attributes.ended_on" :errors="errors" required :min="attributes.started_on"/>
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import { formHelper } from 'bootstrap-for-vue'
import moment from 'moment'

export default {
  name: 'CreateSession',

  data: () => ({
    attributes: {
      name: '',
      semester_id: 0,
      started_on: '',
      ended_on: ''
    },

    disabled: false
  }),

  computed: mapGetters('semesters', ['semesters']),

  methods: {
    async save () {
      this.clearErrors()

      this.disabled = true
      const { errors, session } = await this.store(this.attributes)
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

    setName () {
      if (this.attributes.semester_id < 1 || !this.attributes.started_on) return

      const date = moment(this.attributes.started_on)

      if (!date.isValid()) return

      const semester = this.semesters.find(semester => semester.id === this.attributes.semester_id)

      if (!semester) return

      this.attributes.name = `${semester.name} ${date.year()}`
    },


    ...mapActions('sessions', ['store'])
  },

  watch: {
    'attributes.semester_id': 'setName',
    'attributes.started_on': 'setName'
  },

  mixins: [formHelper]
}
</script>


<style lang="scss"></style>
