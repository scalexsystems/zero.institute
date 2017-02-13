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
      <checkbox-wrapper title="Gender" required>
        <input-box v-model="attributes.gender" radio="female" title="Female" inline/>
        <input-box v-model="attributes.gender" radio="male" title="Male" inline/>
        <input-box v-model="attributes.gender" radio="other" title="Other" inline/>
      </checkbox-wrapper>
    </div>
    <div class="col-12 col-lg-6">
      <input-text type="date" v-model="attributes.date_of_birth" title="Date of Birth" placeholder="dd/mm/yyyy" required subtitle="true">
        <span slot="subtitle">Use date format <code>dd/mm/yyyy</code>.</span>
      </input-text>
    </div>
    <div class="col-12 col-lg-6">
      <input-typeahead v-model="attributes.category" title="Category" :suggestions="categories" />
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.religion" title="Religion" />
    </div>
    <div class="col-12 col-lg-6">
      <input-text v-model="attributes.mother_tongue" title="Mother Tongue" />
    </div>
  </div>
</form>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import { only } from '../../../util'
import { formHelper } from 'bootstrap-for-vue'
import PersonalInformation from '../view/PersonalInformation.vue'

export default {
  name: 'EditPersonalInformation',

  extends: PersonalInformation,

  props: {
    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    attributes: {
      first_name: '',
      middle_name: '',
      last_name: '',
      gender: '',
      date_of_birth: '',
      category: '',
      religion: '',
      mother_tongue: ''
    }
  }),

  computed: {
    categories: () => [
      { id: 'gen', name: 'General' },
      { id: 'sc', name: 'Scheduled Castes (SC)' },
      { id: 'st', name: 'Scheduled Tribes (ST)' },
      { id: 'obc', name: 'Other Backward Classes (OBC)' },
      { id: 'sbc', name: 'Special Backward Classes (SBC)' },
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
