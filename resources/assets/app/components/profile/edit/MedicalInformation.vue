<template>
<form class="card-block" @submit="save">
  <alert type="danger" v-if="formStatus" v-html="formStatus"></alert>

  <form class="row" @submit.prevent="$emit('submit')">
    <input type="submit" hidden>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.blood_group" title="Blood Group" :suggestions="bloodGroups" autofocus autocomplete v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <checkbox-wrapper title="Physically Challenged" required v-bind="{ errors }">
        <input-box v-model="attributes.is_disabled" :radio="true" title="Yes" inline/>
        <input-box v-model="attributes.is_disabled" :radio="false" title="No" inline/>
      </checkbox-wrapper>
    </div>
    <div class="col-12 col-lg-6" v-if="attributes.is_disabled">
      <input-text v-model="attributes.disability" title="Type of Disability" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.disease" title="Disease" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.allergy" title="Allergy" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.visible_marks" title="Body Marks/Identification Marks" v-bind="{ errors }"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.food_habit" title="Food Habit" :suggestions="foodHabits" v-bind="{ errors }"/>
    </div>
    <div class="col-12">
      <input-textarea v-model="attributes.medical_remarks" title="Remarks" v-bind="{ errors }"/>
    </div>
  </form>
</form>
</template>

<script lang="babel">
import { only } from '../../../util'
import mixin from './mixin'
import MedicalInformation from '../view/MedicalInformation.vue'

export default {
  name: 'EditMedicalInformation',

  extends: MedicalInformation,

  data: () => ({
    attributes: {
      blood_group: '',
      is_disabled: false,
      disability: '',
      disease: '',
      allergy: '',
      visible_marks: '',
      food_habit: [],
      medical_remarks: ''
    }
  }),

  computed: {
    bloodGroups: () => [
      { id: 'A+', name: 'A+' },
      { id: 'A-', name: 'A-' },
      { id: 'B+', name: 'B+' },
      { id: 'B-', name: 'B-' },
      { id: 'AB+', name: 'AB+' },
      { id: 'AB-', name: 'AB-' },
      { id: 'O+', name: 'O+' },
      { id: 'O-', name: 'O-' }
    ]
  },

  methods: {
    prepareAttributes () {
      this.attributes = only(this.source, Object.keys(this.attributes))
    },

    async callAPI () {
      const payload = this.attributes

      payload.food_habit = payload.food_habit.filter(h => h.length > 0)

      return await this.submit({ uid: this.source.uid, payload })
    }
  },

  mixins: [mixin]
}
</script>
