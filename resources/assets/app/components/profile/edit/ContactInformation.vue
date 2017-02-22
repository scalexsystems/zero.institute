<template>
<form class="card-block" @submit="save">
  <alert type="danger" v-if="formStatus" v-html="formStatus"></alert>

  <form class="row" @submit.prevent="$emit('submit')">
    <input type="submit" hidden>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.address_line1" title="Address Line 1" autofocus required v-bind="{ errors }"
                  autocomplete="address-line1"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.address_line2" title="Address Line 2" required v-bind="{ errors }"
                  autocomplete="address-line2"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.landmark" title="Landmark" v-bind="{ errors }" autocomplete="address-line3"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.city_id" title="City" v-bind="{ errors, suggestions }" @search="getCities"
                       required autocomplete="city"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.pin_code" title="PIN Code" v-bind="{ errors }" required
                  autocomplete="postal-code"/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.phone" title="Phone" type="tel" v-bind="{ errors }" autocomplete="tel" required/>
    </div>

    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.email" title="Email" type="email" v-bind="{ errors }" autocomplete="email"/>
    </div>
  </form>
</form>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import mixin from './mixin'
import ContactInformation from '../view/ContactInformation.vue'

export default {
  name: 'EditContactInformation',

  extends: ContactInformation,

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

  computed: mapGetters('cities', { suggestions: 'cities', cityById: 'cityById' }),

  methods: {
    prepareAttributes () {
      if (this.address.city_id > 0 && !this.cityById(this.address.city_id)) {
        this.$store.dispatch('cities/find', this.address.city_id)
      }

      this.attributes = only(this.address || {}, Object.keys(this.attributes))
    },
    async callAPI () {
      return await this.submit({ uid: this.source.uid, payload: this.attributes })
    },

    getCities (q) {
      this.$store.dispatch('cities/index', { q })
    }
  },

  created () {
    if (!this.suggestions.length) {
      this.$store.dispatch('cities/index')
    }
  },

  mixins: [mixin]
}
</script>
