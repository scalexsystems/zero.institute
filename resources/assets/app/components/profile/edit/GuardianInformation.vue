<template>
<form class="card-block" @submit="save">
  <alert type="danger" v-if="formStatus" v-html="formStatus"></alert>

  <form class="row" @submit.prevent="$emit('submit')">
    <input type="submit" hidden>
    <div class="col-12">
      <input-text title="Name of the institute" v-model="attributes.name" :errors="errors" required/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text type="Email" title="Institute Email" v-model="attributes.email" :email="errors" required/>
    </div>
    <div class="col-12 col-lg-6 ">
      <input-text title="University" v-model="attributes.university" :errors="errors" required/>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead title="Institute Type" v-model="attributes.institute_type" :suggestions="instituteTypes"
                       :errors="errors" required/>
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
