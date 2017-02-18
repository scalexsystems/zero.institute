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
      <input-text v-model="attributes.profession" title="Profession/Occupation" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.income" type="number" title="Income" min="0"
                  subtitle="Enter annual income in lakhs. Eg. 1.5 = ₹ 1.5 lakh / annum" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.phone" title="Phone Number" type="tel" v-bind="{ errors }"/>
    </div>
  </form>
</form>
</template>

<script lang="babel">
import { only } from '../../../util'
import GuardianInformation from '../view/GuardianInformation.vue'
import mixin from './mixin'

export default {
  name: 'EditGuardianInformation',

  extends: GuardianInformation,

  data: () => ({
    attributes: {
      first_name: '',
      last_name: '',
      profession: '',
      income: 0.0,
      phone: ''
    }
  }),

  methods: {
    prepareAttributes () {
      this.attributes = only(this.guardian, Object.keys(this.attributes))
    },
    async callAPI () {
      return await this.submit({ uid: this.source.uid, payload: this.attributes })
    }
  },

  mixins: [mixin]
}
</script>
