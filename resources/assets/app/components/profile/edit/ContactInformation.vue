<template>
<form class="card-block" @submit="save">
  <div class="row">
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.address_line1" title="Address Line 1" autofocus required v-bind="{ errors }"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.address_line2" title="Address Line 2" v-bind="{ errors }"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.landmark" title="Landmark" v-bind="{ errors }"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.city_id" title="City" v-bind="{ errors, suggestions }" @search="getCities" required />
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.pin_code" title="PIN Code" type="number" v-bind="{ errors }" required/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.phone" title="Phone" type="tel" v-bind="{ errors }" />
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.email" title="Email" type="email" v-bind="{ errors }" />
    </div>
  </div>
</form>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import { formHelper } from 'bootstrap-for-vue'
import ContactInformation from '../view/ContactInformation.vue'

export default {
  name: 'EditContactInformation',

  extends: ContactInformation,

  props: {
    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    attributes: {
      address_line1: '',
      address_line2: '',
      landmark: '',
      city_id: 0,
      pin_code: '',
      phone: '',
      email: ''
    }
  }),

  computed: mapGetters('cities', { suggestions: 'cities' }),

  methods: {
    prepareAttributes () {
      this.clearErrors()
      this.attributes = only(this.address || {}, Object.keys(this.attributes))
    },
    async save () {
      const { errors } = await this.submit({ id: this.source.id, payload: this.attributes })

      if (errors) {
        this.setErrors(errors)
      } else {
        this.$emit('updated')
      }
    },

    getCities (q) {
      this.$store.dispatch('cities/index', { q })
    }
  },

  created () {
    this.$on('edit', () => this.prepareAttributes())
    this.$on('save', () => this.save())
    this.$store.dispatch('cities/index')
  },

  mixins: [formHelper]
}
</script>
