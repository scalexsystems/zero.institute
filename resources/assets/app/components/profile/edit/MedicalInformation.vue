<template>
<form class="card-block" @submit="save">
  <div class="row">
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.blood_group" title="Blood Group" :suggestions="bloodGroups" autocomplete/>
    </div>
    <div class="col-12 col-lg-6">
      <checkbox-wrapper title="Physically Challenged" required>
        <input-box v-model="attributes.is_disabled" :radio="true" title="Yes" inline/>
        <input-box v-model="attributes.is_disabled" :radio="false" title="No" inline/>
      </checkbox-wrapper>
    </div>
    <div class="col-12 col-lg-6" v-if="attributes.is_disabled">
      <input-text v-model="attributes.disability" title="Type of Disability"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.disease" title="Disease"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.allergy" title="Allergy"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.body_marks" title="Body Marks/Identification Marks"/>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.food_habit" title="Food Habit" :suggestions="foodHabits"/>
    </div>
    <div class="col-12">
      <input-textarea v-model="attributes.medical_remarks" title="Remarks" />
    </div>
  </div>
</form>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import { formHelper } from 'bootstrap-for-vue'
import MedicalInformation from '../view/MedicalInformation.vue'

export default {
  name: 'EditMedicalInformation',

  extends: MedicalInformation,

  props: {
    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    attributes: {
      blood_group: '',
      is_disabled: false,
      disability: '',
      disease: '',
      allergy: '',
      body_marks: '',
      food_habit: [],
      medical_remarks: ''
    }
  }),

  computed: {
    bloodGroups: () => [
      { id: 'A+',  name: 'A+' },
      { id: 'A-',  name: 'A-' },
      { id: 'B+',  name: 'B+' },
      { id: 'B-',  name: 'B-' },
      { id: 'AB+', name: 'AB+' },
      { id: 'AB-', name: 'AB-' },
      { id: 'O+',  name: 'O+' },
      { id: 'O-',  name: 'O-' },
    ],

    foodHabits: () => [
      { id: 'veg', name: 'Vegetarian' },
      { id: 'non-veg', name: 'Non Vegetarian' },
      { id: 'egg', name: 'Egg & Egg Products' },
      { id: 'vegan', name: 'Vegan' },
      { id: 'fish', name: 'Fish & Fish Products' },
      { id: 'sea', name: 'Sea Food' },
    ]
  },

  methods: {
    prepareAttributes () {
      this.clearErrors()
      this.attributes = only(this.source, Object.keys(this.attributes))
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
