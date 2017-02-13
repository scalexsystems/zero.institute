<template>
<form class="card-block" @submit="save">
  <div class="row">
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.uid" :title="uidLabel" autofocus required v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6" v-if="isStudent">
      <input-text type="date" v-model="attributes.date_of_admission" title="Date of Birth" placeholder="dd/mm/yyyy" required subtitle="true">
        <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
      </input-text>
    </div>
    <div class="col-12 col-lg-6" v-else>
      <input-text type="date" v-model="attributes.date_of_joining" title="Date of Joining" placeholder="dd/mm/yyyy" required subtitle="true">
        <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
      </input-text>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.department_id" title="Department" :suggestions="departments" />
    </div>
    <div class="col-12 col-lg-6" v-if="isTeacher">
      <input-text v-model="attributes.specialization" title="Specialization" />
    </div>
    <div class="col-12 col-lg-6" v-if="isStudent">
      <input-typeahead v-model="attributes.discipline_id" title="Discipline" :suggestions="disciplines" />
    </div>
    <div class="col-12 col-lg-6" v-if="!isStudent">
      <input-text v-model="attributes.job_title" title="Position" />
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.govt_id" title="AADHAR" />
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.passport" title="Passport" />
    </div>
  </div>
</form>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import { formHelper } from 'bootstrap-for-vue'
import SchoolRelatedInformation from '../view/SchoolRelatedInformation.vue'

export default {
  name: 'EditSchoolRelatedInformation',

  extends: SchoolRelatedInformation,

  props: {
    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    attributes: {
      uid: '',
      department_id: 0,
      discipline_id: 0,
      date_of_admission: '',
      date_of_joining: '',
      specialization: '',
      job_title: '',
      govt_id: '',
      aadhar: ''
    }
  }),

  computed: mapGetters({
    disciplines: 'disciplines/disciplines',
    departments: 'departments/academic'
  }),

  methods: {
    prepareAttributes () {
      this.clearErrors()

      const keys = Object.keys(this.attributes)

      if (this.isStudent) {
        keys.splice(keys.indexOf('discipline_id'), 1)
        keys.splice(keys.indexOf('date_of_joining'), 1)
        keys.splice(keys.indexOf('specialization'), 1)
        keys.splice(keys.indexOf('job_title'), 1)
      }

      if (this.isTeacher || this.isEmployee) {
        keys.splice(keys.indexOf('date_of_admission'), 1)
      }

      if (this.isEmployee) {
        keys.splice(keys.indexOf('specialization'), 1)
      }

      this.attributes = only(this.source, keys)
    },
    async save () {
      const { errors } = await this.submit({ id: this.source.id, payload: this.attributes })

      if (errors) {
        this.setErrors(errors)
      } else {
        this.$emit('updated')
      }
    }
  },

  created () {
    this.$on('edit', () => this.prepareAttributes())
    this.$on('save', () => this.save())
  },

  mixins: [formHelper]
}
</script>
