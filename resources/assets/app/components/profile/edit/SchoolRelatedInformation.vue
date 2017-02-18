<template>
<form class="card-block" @submit="save">
  <alert type="danger" v-if="formStatus" v-html="formStatus"></alert>

  <form class="row" @submit.prevent="$emit('submit')">
    <input type="submit" hidden>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.uid" :title="uidLabel" autofocus required v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6" v-if="isStudent">
      <input-text type="date" v-model="attributes.date_of_admission" title="Date of Admission" placeholder="dd/mm/yyyy"
                  required subtitle="true" v-bind="{ errors }">
        <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
      </input-text>
    </div>
    <div class="col-12 col-lg-6" v-else>
      <input-text type="date" v-model="attributes.date_of_joining" title="Date of Joining" placeholder="dd/mm/yyyy"
                  required subtitle="true" v-bind="{ errors }">
        <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
      </input-text>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.department_id" title="Department" :suggestions="departments" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6" v-if="isTeacher">
      <input-text v-model="attributes.specialization" title="Specialization" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6" v-if="isStudent">
      <input-typeahead v-model="attributes.discipline_id" title="Discipline" :suggestions="disciplines" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6" v-if="!isStudent">
      <input-text v-model="attributes.job_title" title="Position" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.govt_id" title="AADHAR" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.passport" title="Passport" v-bind="{ errors }"/>
    </div>
  </form>
</form>
</template>

<script lang="babel">
import moment from 'moment'
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import mixin from './mixin'
import SchoolRelatedInformation from '../view/SchoolRelatedInformation.vue'

export default {
  name: 'EditSchoolRelatedInformation',

  extends: SchoolRelatedInformation,

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
      aadhar: '',
      passport: ''
    }
  }),

  computed: mapGetters({
    disciplines: 'disciplines/disciplines',
    departments: 'departments/academic'
  }),

  methods: {
    prepareAttributes () {
      const keys = Object.keys(this.attributes)

      if (this.isStudent) {
        keys.splice(keys.indexOf('date_of_joining'), 1)
        keys.splice(keys.indexOf('specialization'), 1)
        keys.splice(keys.indexOf('job_title'), 1)
      }

      if (this.isTeacher || this.isEmployee) {
        keys.splice(keys.indexOf('discipline_id'), 1)
        keys.splice(keys.indexOf('date_of_admission'), 1)
      }

      if (this.isEmployee) {
        keys.splice(keys.indexOf('specialization'), 1)
      }

      const date = moment(this.isStudent ? this.source.date_of_admission : this.source.date_of_joining)
      this.attributes = only(this.source, keys)
      this.attributes[this.isStudent ? 'date_of_admission' : 'date_of_joining'] = date.isValid() ? date.format('YYYY-MM-DD') : ''
    },
    async callAPI () {
      return await this.submit({ uid: this.source.uid, payload: this.attributes })
    }
  },

  mixins: [mixin]
}
</script>
