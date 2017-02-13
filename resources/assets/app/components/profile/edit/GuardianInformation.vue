<template>
<form class="card-block" @submit="save">
  <div class="row">
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
      <input-text v-model="attributes.salary" type="number" title="Salary" min="0" subtitle="Enter annual salary in lakhs. Eg. 1.5 = ₹ 1.5 lakh / annum" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.phone" title="Phone Number" type="tel" v-bind="{ errors }"/>
    </div>
  </div>
</form>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import { formHelper } from 'bootstrap-for-vue'
import GuardianInformation from '../view/GuardianInformation.vue'

export default {
  name: 'EditGuardianInformation',

  extends: GuardianInformation,

  props: {
    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    attributes: {
      first_name: '',
      last_name: '',
      profession: '',
      salary: 0.0,
      phone: ''
    }
  }),

  methods: {
    prepareAttributes () {
      this.clearErrors()
      this.attributes = only(this.guardian, Object.keys(this.attributes))
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
