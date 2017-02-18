<template>
<div class="container-zero c-settings-edit-institute mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">About Institute</h5>

      <div class="ml-auto">
        <input-button class="btn btn-secondary" @click.native="$emit('done')" value="Cancel"/>
        <input-button @click.native="save" value="Save"/>
      </div>
    </div>

    <div class="card-block flex-auto">
      <form class="row" @submit.prevent="save">
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
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { formHelper } from 'bootstrap-for-vue'
import { mapActions, mapGetters } from 'vuex'
import { only } from '../../../util'
import instituteTypes from '../institute-types'

export default {
  name: 'EditInstituteSettings',

  data: () => ({
    attributes: {
      name: '',
      email: '',
      university: '',
      institute_type: ''
    }
  }),

  computed: {
    instituteTypes: () => instituteTypes,
    ...mapGetters(['school'])
  },

  methods: {
    async save () {
      const { errors } = await this.update(this.attributes)

      if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.$emit('done')
      }
    },
    ...mapActions('schools', ['update'])
  },

  created () {
    this.attributes = only(this.school, Object.keys(this.school))
  },

  mixins: [formHelper]
}
</script>


<style lang="scss">
.c-settings-edit-institute {
  max-width: 600px;
}
</style>
