<template>
<form class="card-block" @submit="save">
  <alert type="danger" v-if="formStatus" v-html="formStatus"></alert>

  <form class="row" @submit.prevent="$emit('submit')">
    <input type="submit" hidden>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.first_name" title="First Name" autofocus required v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.last_name" title="Last Name" required v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <checkbox-wrapper title="Gender" required v-bind="{ errors }">
        <input-box v-model="attributes.gender" radio="female" title="Female" inline/>
        <input-box v-model="attributes.gender" radio="male" title="Male" inline/>
        <input-box v-model="attributes.gender" radio="other" title="Other" inline/>
      </checkbox-wrapper>
    </div>
    <div class="col-12 col-lg-6">
      <input-text type="date" v-model="attributes.date_of_birth" title="Date of Birth" placeholder="dd/mm/yyyy" required
                  subtitle="true" v-bind="{ errors }">
        <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
      </input-text>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.category" title="Category" :suggestions="categories" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.religion" title="Religion" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.language" title="Native Language" v-bind="{ errors }"/>
    </div>
  </form>
</form>
</template>

<script lang="babel">
import moment from 'moment'
import { only } from '../../../util'
import mixin from './mixin'
import PersonalInformation from '../view/PersonalInformation.vue'

export default {
  name: 'EditPersonalInformation',

  extends: PersonalInformation,

  data: () => ({
    attributes: {
      first_name: '',
      middle_name: '',
      last_name: '',
      gender: '',
      date_of_birth: '',
      category: '',
      religion: '',
      language: ''
    }
  }),

  methods: {
    prepareAttributes () {
      const date = moment(this.source.date_of_birth)
      this.attributes = only(this.source, Object.keys(this.attributes))
      this.attributes.date_of_birth = date.isValid() ? date.format('YYYY-MM-DD') : ''
    },
    async callAPI () {
      return await this.submit({ uid: this.source.uid, payload: this.attributes })
    }
  },

  mixins: [mixin]
}
</script>
